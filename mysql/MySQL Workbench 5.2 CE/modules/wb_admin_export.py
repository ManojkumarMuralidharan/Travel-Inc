# Copyright (c) 2007, 2011, Oracle and/or its affiliates. All rights reserved.
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License as
# published by the Free Software Foundation; version 2 of the
# License.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA
# 02110-1301  USA

import os
import re
import sys
import subprocess
import threading
import thread
import time
import grt
import tempfile
import platform

import wb_admin_export_options
import wb_common

try:
 import _subprocess
except ImportError:
 pass

from wb_server_management import local_run_cmd

from db_utils import MySQLConnection, MySQLError, ConnectionTunnel, escape_sql_string, escape_sql_identifier
from wb_admin_utils import not_running_warning_label
from collections import deque

from mforms import newBox, newButton, newPanel, newTextBox, newRadioButton, newLabel, newTreeView, newProgressBar, newTextEntry, newCheckBox, newScrollPanel, newTabView
from mforms import Utilities, FileChooser
import mforms

def quote_shell_token(s):
    t = '"%s"' % s.replace('\\', '\\\\').replace('"', '\\"').replace('$', '\\$')
    if t[:5] == '"\\\\\\\\':
      t = t[3:]
      t = '\"' + t
    return t

def normalize_filename(s):
    s = s.replace(":", "_").replace("/", "_").replace("\\", "_")
    return s



####################################################################################################

class DumpThread(threading.Thread):


    # description, object_count, pipe_factory, extra_args, objects
    #operations.append((title, len(tables), lambda schema=schema:self.dump_to_file([schema]), params, objects))
    class TaskData:
        def __init__(self, title, table_count, extra_arguments, objec_names, make_pipe = lambda:None):
            self.title = title
            self.table_count = table_count
            self.extra_arguments = extra_arguments
            self.objec_names = objec_names
            self.make_pipe = make_pipe

    def __init__(self, command, operations, pwd, owner, log_queue):
        self.owner = owner
        self.pwd = pwd
        self.logging_lock, self.log = log_queue
        self.is_import = False
        self.command = command
        self.operations = operations
        self.done = False
        self.progress = 0
        self.status_text = "Starting"
        self.error_count = 0
        self.process_handle = None
        self.abort_requested = False
        self.e = None
        threading.Thread.__init__(self)

    def process_db(self, respipe, extra_arguments, object_names):
        pwdfilename = None
        tmpdir = None
        try:
            params = [self.command] + extra_arguments
            for arg in object_names:
                params.append(quote_shell_token(arg))
            
            strcmd = " ".join(params)
                                                     
            logstr = strcmd.partition("--password=")[0]
    
            if platform.system() == 'Windows':
                pwdfile = tempfile.NamedTemporaryFile(delete=False, suffix=".cnf")
                pwdfilename = pwdfile.name
            else:
                tmpdir = tempfile.mkdtemp()
                pwdfilename = os.path.join(tmpdir, 'extraparams.cnf')
                os.mkfifo(pwdfilename)
   
            logstr += "--defaults-extra-file=\"" + pwdfilename + "\" "
    
            logstr += strcmd.partition("--password=")[2]
    
            self.print_log_message("Running: " + logstr)
            if platform.system() != 'Windows':
                try:
                    p1 = subprocess.Popen(logstr,stdout=respipe,stdin=subprocess.PIPE, stderr=subprocess.PIPE, shell=True)
                except OSError, exc:
                    import traceback
                    traceback.print_exc()
                    self.print_log_message("Error executing task: %s" % str(exc))

                pwdfile = open(pwdfilename, 'w')
            else:
                pwdfile = open(pwdfilename, 'w')
            pwdfile.write('[client]\npassword="')
            pwdfile.write(self.pwd.replace("\\", "\\\\"))
            pwdfile.write('"')
            pwdfile.close()
            if platform.system() == 'Windows':
                try:
                    info = subprocess.STARTUPINFO()
                    info.dwFlags |= _subprocess.STARTF_USESHOWWINDOW
                    info.wShowWindow = _subprocess.SW_HIDE
                    fse = sys.getfilesystemencoding()
                    cmd = logstr.encode(fse) if isinstance(arg,unicode) else logstr
                    p1 = subprocess.Popen(cmd,stdout=respipe or subprocess.PIPE,stdin=subprocess.PIPE, stderr=subprocess.PIPE,startupinfo=info,shell=logstr[0] != '"')
                except OSError, exc:
                    import traceback
                    traceback.print_exc()
                    self.print_log_message("Error executing task: %s" % str(exc))
#                finally:
#                    pass


            self.process_handle = p1

            while p1.poll() == None and not self.abort_requested:
                err = p1.stderr.read()
                if err != "":
                    self.print_log_message(err)
                    if 'Access denied for user' in err:
                        self.e = wb_common.InvalidPasswordError('Wrong username/password!')
            result = ""


        except Exception, exc:
            import traceback
            traceback.print_exc()
            self.print_log_message("Error executing task: %s" % str(exc))
#        finally:
#            pass
        if pwdfilename:
            os.remove(pwdfilename)
        if platform.system() != 'Windows' and tmpdir:
            os.rmdir(tmpdir)

        err = p1.stderr.read()
        if err != "":
            result += err
        if p1.poll() != 0:
            self.print_log_message("Operation failed with exitcode " + str(p1.poll()))
        else:
            self.print_log_message("")

        if result:
            self.print_log_message(result)
        return p1.poll()
      
    def kill(self):
        self.abort_requested = True
        if self.process_handle:
            if platform.system() == 'Windows':
                subprocess.Popen("taskkill /F /T /PID %i" % self.process_handle.pid , shell=True)
            else:
                import signal
                try:
                    os.kill(self.process_handle.pid, signal.SIGTERM)
                except OSError, exc:
                    self.print_log_message("kill task: %s" % str(exc))

    def print_log_message(self,message):
        if message:
            self.logging_lock.acquire()
            self.log.append(message)
            self.logging_lock.release()  

    def run(self):
        try:
            self.progress = 0
            tables_processed = 0.0
            tables_total = 0.0
#            for title, count, make_pipe, args, objs in self.operations:
            for task in self.operations:
                tables_total += task.table_count or 1

#            for title, table_count, make_pipe, arguments, objects in self.operations:
            for task in self.operations:
                self.print_log_message(time.strftime(u'%X ') + task.title.encode('utf-8'))

                tables_processed += task.table_count or 1
                pipe = task.make_pipe()
                exitcode = self.process_db(pipe, task.extra_arguments, task.objec_names)
                if exitcode == 0:
                    if self.is_import:
                        self.status_text = "%i of %i imported." % (tables_processed, tables_total)
                    else:
                        self.status_text = "%i of %i exported." % (tables_processed, tables_total)
                else:
                    self.owner.fail_callback()
                    self.error_count += 1

                if self.abort_requested:
                    break

                self.progress = float(tables_processed) / tables_total
#                print self.progress
#               Emulate slow dump
#                import time
#                time.sleep(1)
        except Exception, exc:
            import traceback
            traceback.print_exc()
            self.print_log_message("Error executing task %s" % str(exc) )
#        finally:
        if not self.abort_requested:
            self.progress = 1
        self.done = True

class TableListModel(object):
    def __init__(self):
        self.tables_by_schema = {}
        self.routines_placeholder = None

    def get_full_selection(self):
        result = []
        for schema, (tables, selection) in self.tables_by_schema.items():
            for table in selection:
                result.append((schema,table))
        result.sort()
        return result

    def get_schema_names(self):
        return self.tables_by_schema.keys()

    def set_tables_by_schema(self, tables_by_schema):
        self.tables_by_schema = tables_by_schema

    def set_routines_placeholder(self, placeholder):
        self.routines_placeholder = placeholder

    def get_tables(self, schema):
        tables, selection = self.tables_by_schema[schema]
        return tables
        
    def is_view(self, schema, table):
        return False

    def list_icon_for_table(self, schema, table):
        if (schema, table) == self.routines_placeholder:
            return "db.RoutineGroup.16x16.png"
        else:
            return "db.Table.16x16.png"

    def get_selection(self, schema):
        tables, selection = self.tables_by_schema[schema]
        return selection

    def count_selected_tables(self):
        count = 0
        for tlist, selected in self.tables_by_schema.values():
            count += len(selected)
        return count

    def get_count(self):
        return sum([len(item[1]) for item in self.tables_by_schema.values()])

    def get_objects_to_dump(self, include_empty_schemas=False):
        schemas_to_dump = []
        names = self.tables_by_schema.keys()
        names.sort()
        for schema in names:
        #No tables selected for schema so skip it
            tables, selection = self.tables_by_schema[schema]
            if not selection and not include_empty_schemas:
                continue
            schemas_to_dump.append((schema, list(selection)))
        return schemas_to_dump


    def get_tables_to_ignore(self):
        ignore_list = []
        names = self.tables_by_schema.keys()
        names.sort()
        for schema in names:
        #No tables selected for schema so skip it
            tables, selection = self.tables_by_schema[schema]
            if not selection or len(selection) == len(tables):
                continue
            for t in tables:
                if not t in selection:
                    ignore_list.append((schema, t))
        return ignore_list
        

####################################################################################################


class WbAdminSchemaListTab(mforms.Box):
    def __init__(self, owner, instance_info, progress_tab, is_importing = False):
        self.savefile_path = None
        self.savefolder_path = None

        super(WbAdminSchemaListTab, self).__init__(False)
        
        self.suspend_layout()

        progress_tab.operation_tab = self

        self.owner = owner
        self.progress_tab = progress_tab
        self.is_importing = is_importing
        
        self.dump_thread = None
        self.bad_password_detected = False      
        self.instance_info = instance_info
        self.out_pipe = None
        if self.savefolder_path is None:
            self.savefolder_path = self.get_default_dump_folder()
        if self.savefile_path is None:
            self.savefile_path = os.path.join(self.savefolder_path, "export.sql")

        self.schema_list = newTreeView(mforms.TreeDefault)
        self.schema_list.add_column(mforms.CheckColumnType, is_importing and "Import" or "Export", 40, True)
        self.schema_list.add_column(mforms.IconColumnType, "", 18, False)
        self.schema_list.add_column(mforms.StringColumnType, "Schema", 300, False)

        self.schema_list.set_cell_edited_callback(self.schema_list_edit)
        self.schema_list.end_columns()
        self.schema_list.set_allow_sorting(True)

        self.table_list = newTreeView(mforms.TreeDefault)
        self.table_list.add_column(mforms.CheckColumnType, is_importing and "Import" or "Export", 40, True)
        self.table_list.add_column(mforms.IconColumnType, "", 18, False)
        self.table_list.add_column(mforms.StringColumnType, "Schema Objects", 300, False)
        self.table_list.end_columns()
        self.table_list.set_allow_sorting(True)

        self.table_list.set_cell_edited_callback(self.table_list_edit)
        
        self.schema_list.add_changed_callback(self.schema_selected)

        self.set_padding(8)
        self.set_spacing(10)


        box = newBox(True)
        box.set_spacing(12)
        optionspanel = newPanel(mforms.TitledBoxPanel)
        optionspanel.set_title("Options")
        optionsbox = newBox(False)
        optionsbox.set_padding(8)
        optionsbox.set_spacing(6)

        self.file_btn = newButton()
        self.file_btn.set_text("...")
        self.file_btn.enable_internal_padding(False)
        self.file_btn.set_enabled(False)

        if is_importing:
          self.folderlabel = newLabel("Select the Dump Project Folder to import. You can do a selective restore.")
          self.folderradio = newRadioButton(0)
          self.statlabel = newLabel("Press [Start Import] to start...")
          self.filelabel = newLabel("Select the SQL/dump file to import. Please note that the whole file will be imported.")
          self.single_transaction_check = None
          #self.dump_view_check = None
          self.skip_data_check = None
          self.dump_routines_check = None
          self.dump_events_check = None
        else:
          self.filelabel = newLabel("All selected database objects will be exported into a single, self-contained file.")
          self.folderlabel = newLabel("Each table will be exported into a separate file. This allows a selective restore, but may be slower.")
          self.folderradio = newRadioButton(1)
          self.statlabel = newLabel("Press [Start Export] to start...")
          self.single_transaction_check = newCheckBox()
          #self.dump_view_check = newCheckBox()
          self.skip_data_check = newCheckBox()
          self.dump_routines_check = newCheckBox()
          self.dump_events_check = newCheckBox()
          
        self.filelabel.set_enabled(False)
        self.filelabel.set_style(mforms.SmallStyle)

        if is_importing:
          self.fileradio = newRadioButton(0)
          self.fileradio.set_text("Import from Self-Contained File")
        else:
          self.fileradio = newRadioButton(1)
          self.fileradio.set_text("Export to Self-Contained File")

        self.fileradio.add_clicked_callback(self.set_save_option)

        file_path = newBox(True)
        file_path.set_spacing(4)
        labelfile = newLabel("   File Path")
        self.file_te = newTextEntry()
        self.file_te.set_value(self.savefile_path)
        file_path.add(labelfile, False, False)
        file_path.add(self.file_te, True, True)
        file_path.add(self.file_btn, False, True)

        self.folderradio.add_clicked_callback(self.set_save_option)
        self.folderradio.set_active(True)
        self.folderlabel.set_style(mforms.SmallStyle)

        folder_path = newBox(True)
        folder_path.set_spacing(4)
        labelfolder = newLabel("   Folder Path")
        self.folder_te = newTextEntry()
        self.folder_te.set_value(self.savefolder_path)
        self.folder_btn = newButton()
        self.folder_btn.set_text("...")
        self.folder_btn.enable_internal_padding(False)
        self.folder_btn.add_clicked_callback(self.open_folder_chooser)
        folder_path.add(labelfolder, False, False)
        folder_path.add(self.folder_te, True, True)
        folder_path.add(self.folder_btn, False, True)

        optionsbox.add(self.folderradio, False, True)
        optionsbox.add(self.folderlabel, False, True)
        optionsbox.add(folder_path, False, True)
        if is_importing:
            self.folder_te.add_changed_callback(self.folder_path_changed)
            self.folder_load_btn = newButton()
            self.folder_load_btn.set_text("Load Folder Contents")
            self.folder_load_btn.add_clicked_callback(self.refresh_table_list)
            tbox = newBox(True)
            tbox.add(self.folder_load_btn, False, True)
            optionsbox.add(tbox, False, False)

        optionsbox.add(self.fileradio, False, True)
        optionsbox.add(self.filelabel, False, True)
        optionsbox.add(file_path, False, True)

        if self.single_transaction_check or self.dump_routines_check:
            suboptionsbox = newBox(False)
            optionsbox.add_end(suboptionsbox, False, True)
        
        if self.single_transaction_check:
            suboptionsbox.add(self.single_transaction_check, False, True)
        #if self.dump_view_check:
        #    suboptionsbox.add(self.dump_view_check, False, True)
        if self.dump_routines_check:
            suboptionsbox.add(self.dump_routines_check, False, True)
        if self.dump_events_check:
            suboptionsbox.add(self.dump_events_check, False, True)
        if self.skip_data_check:
            suboptionsbox.add(self.skip_data_check, False, True)
            
        if os.getenv("WB_DUMP_TEST_BUTTON"):
            self.test_button = newButton()
            self.test_button.set_text("Test")
            optionsbox.add(self.test_button, False, True)
            self.test_button.add_clicked_callback(self.test_clicked)


        self.file_te.set_enabled(False)
        
        #spanel = newScrollPanel(mforms.ScrollPanelNoFlags)
        #spanel.add(optionsbox)
        #spanel.set_autohide_scrollers(True)
        #optionspanel.add(spanel)
        optionspanel.add(optionsbox)

        selectionpanel = newPanel(mforms.TitledBoxPanel)
        if is_importing:
            selectionpanel.set_title("Select Database Objects to Import (only available for Project Folders)")
        else:
            selectionpanel.set_title("Select Database Objects to Export")
        selectionvbox = newBox(False)
        selectionvbox.set_padding(8)
        selectionvbox.set_spacing(8)
        selectionbox = newBox(True)
        selectionvbox.add(selectionbox, True, True)
        selectionbox.set_spacing(12)
        selectionbox.add(self.schema_list, True, True)
        selectionbox.add(self.table_list, True, True)
        selectionbbox = newBox(True)
        selectionbbox.set_spacing(8)
        
        if not is_importing:
            self.refresh_button = newButton()
            self.refresh_button.set_text("Refresh")
            selectionbbox.add(self.refresh_button, False, True)
            self.refresh_button.add_clicked_callback(self.refresh_table_list)
        
        self.select_summary_label = newLabel("")
        selectionbbox.add(self.select_summary_label, True, True)

        self.select_all_btn = newButton()
        self.select_all_btn.set_text("Select Tables")
        self.select_all_btn.add_clicked_callback(self.select_all_tables)
        self.select_all_btn.set_enabled(False)
        self.unselect_all_btn = newButton()
        self.unselect_all_btn.set_text("Unselect All")
        self.unselect_all_btn.add_clicked_callback(self.unselect_all_tables)
        self.unselect_all_btn.set_enabled(False)
        selectionbbox.add_end(self.unselect_all_btn, False, True)
        selectionbbox.add_end(self.select_all_btn, False, True)
        selectionvbox.add(selectionbbox, False, True)
        selectionpanel.add(selectionvbox)

        #box.set_homogeneous(True)
        if is_importing:
            self.add(optionspanel, False, True)
        self.add(selectionpanel, True, True)
        if not is_importing:
            self.add(optionspanel, False, True)

        #self.add(box, True, True)

        #box = newBox(True)
        #box.set_padding(8)
        #box.set_spacing(12)
        #statusbox = newBox(False)
        #statusbox.set_spacing(2)
        #self.dump_progressbar = newProgressBar()
        #self.statlabel = newLabel("")
        #statusbox.set_size(400, -1)
        #statusbox.add(self.hintlabel, False, False)
        #statusbox.add(self.dump_progressbar, False, False)
        #statusbox.add(newLabel("Statistics:"), False, False)
        #statusbox.add(self.statlabel, False, False)

        #self.progress_log = newTextBox(mforms.VerticalScrollBar)
        #self.progress_log.set_read_only(True)

        #box.add(statusbox, False, False)
        #label = newLabel("Log:")
        #label.set_text_align(mforms.TopRight)
        #box.add(label, False, False)
        #box.add(self.progress_log, True, True)
        #self.add(box, False, False)

        box = newBox(True)
        self.add(box, False, True)
        
        box.add(self.statlabel, True, True)
        
        box.set_spacing(8)
        box.set_padding(0)
                
        self.export_button = newButton()
        if is_importing:
            self.export_button.set_enabled(False)
        box.add_end(self.export_button, False, True)
        self.export_button.add_clicked_callback(self.start)

        #self.stop_button = newButton()
        #self.stop_button.set_text("Stop")
        #self.stop_button.set_enabled(False)
        #self.stop_button.add_clicked_callback(self.stop)
        #box.add_end(self.stop_button, False, True)

        if is_importing:
          self.file_btn.add_clicked_callback(lambda: self.open_file_chooser(mforms.OpenFile))
          self.single_transaction_check = None
          self.folderradio.set_text("Import from Dump Project Folder")
          self.export_button.set_text("Start Import")
        else:
          self.file_btn.add_clicked_callback(lambda: self.open_file_chooser(mforms.SaveFile))
          self.single_transaction_check.set_text("Create Dump in a Single Transaction (self-contained file only)")
          self.single_transaction_check.set_enabled(False)
          self.single_transaction_check.add_clicked_callback(self.single_transaction_clicked)
          #self.dump_view_check.set_text("Dump Views")
          self.dump_routines_check.set_text("Dump Stored Routines (Procedures and Functions)")
          self.dump_events_check.set_text("Dump Events")
          self.skip_data_check.set_text("Skip table data (no-data)")

          self.folderradio.set_text("Export to Dump Project Folder")
          self.export_button.set_text("Start Export")

        self.resume_layout()


    def print_log_message(self, msg):
        self.progress_tab.print_log_message(msg)


    def get_default_dump_folder(self):
        try:
            path = grt.root.wb.options.options["dumpdirectory"] or "~/dumps"
        except:
            path = "~/dumps"
        path = os.path.expanduser(path)
        return os.path.normpath(path)

    def schema_list_edit(self, row, col, data): 
        if col == 0:
            self.schema_list.set_bool(row, 0, int(data))
            schema = self.schema_list.get_string(row, 2)
            tables = self.table_list_model.get_tables(schema)
            selection = self.table_list_model.get_selection(schema)
            if int(data):
                selection.update(set(tables))
            else:
                selection.difference_update(set(tables))
            self.schema_selected()

    def table_list_edit(self, row, col, data): 
        self.table_list.set_bool(row, col, int(data))
        self.update_table_selection()
        if int(data):
            # select the schema if its not        
            sel = self.schema_list.get_selected()
            if not self.schema_list.get_check(sel, 0):
                self.schema_list.set_bool(sel, col, True)
                self.schema_selected()

    def update_table_selection(self):
        if not self.get_selected_schema():
             return
        schema = self.get_selected_schema()
        tables = self.table_list_model.get_tables(schema)
        selection = self.table_list_model.get_selection(schema)
        for r in range(self.table_list.count()):
            table_name = self.table_list.get_row_tag(r)
            if self.table_list.get_check(r, 0):
                selection.add(table_name)
            else:
                selection.discard(table_name)
        self.select_summary_label.set_text("%i tables/views selected" % self.table_list_model.count_selected_tables())

    def get_selected_schema(self):
        sel = self.schema_list.get_selected()
        if sel < 0:
            return None
        return self.schema_list.get_string(sel, 2)

    def schema_selected(self):
        sel = self.schema_list.get_selected()
        self.table_list.freeze_refresh()
        self.table_list.clear_rows()
        if sel < 0:
            self.unselect_all_btn.set_enabled(False)
            self.select_all_btn.set_enabled(False)
            self.table_list.thaw_refresh()
            return
        schema = self.get_selected_schema()
        tables = self.table_list_model.get_tables(schema)
        selection = self.table_list_model.get_selection(schema)
        for table in tables:
            r = self.table_list.add_row()
            self.table_list.set_bool(r, 0, table in selection)
            self.table_list.set_string(r, 1, self.table_list_model.list_icon_for_table(schema, table))
            self.table_list.set_string(r, 2, table)
            self.table_list.set_row_tag(r, table)
        self.table_list.thaw_refresh()
        self.unselect_all_btn.set_enabled(True)
        self.select_all_btn.set_enabled(True)
        
        self.select_summary_label.set_text("%i tables selected" % self.table_list_model.count_selected_tables())

    def select_all_tables(self, exclude_views=True):
        sel = self.schema_list.get_selected()
        if sel < 0:
            return
        self.schema_list.set_bool(sel, 0, True)
        schema = self.get_selected_schema()
        for row in range(self.table_list.count()):
            table = self.table_list.get_string(row, 2)
            self.table_list.set_bool(row, 0, not self.table_list_model.is_view(schema, table))
        self.update_table_selection()
        

    def unselect_all_tables(self):
        for row in range(self.table_list.count()):
            self.table_list.set_bool(row, 0, False)
        self.update_table_selection()

    def set_save_option(self):
        folder_selected = self.folderradio.get_active()
        self.folder_te.set_enabled(folder_selected)
        self.folder_btn.set_enabled(folder_selected)
        self.folderlabel.set_enabled(folder_selected)
        self.file_te.set_enabled(not folder_selected)
        self.file_btn.set_enabled(not folder_selected)
        self.filelabel.set_enabled(not folder_selected)

        if self.is_importing:
            if folder_selected:
                count = self.table_list_model.get_count()
                self.progress_tab.set_start_enabled(count > 0)
            else:
                self.progress_tab.set_start_enabled(True)
            self.schema_list.set_enabled(folder_selected)
            self.table_list.set_enabled(folder_selected)
        else:
            if folder_selected:
                self.single_transaction_check.set_active(False)
                self.single_transaction_check.set_enabled(False)
            else:
                self.single_transaction_check.set_enabled(True)


    def refresh(self):
        pass


    def update_progress(self):
        completed = True
        progress = 0
        progress_info = ""
        if self.dump_thread != None:
            if not self.dump_thread.done:
                completed = False
            progress = self.dump_thread.progress
            self.progress_tab.flush_queued_logs()
            progress_info = self.dump_thread.status_text
            if isinstance(self.dump_thread.e, wb_common.InvalidPasswordError):
                self.dump_thread = None
                self.bad_password_detected = True
                self.start()
                return False
        self.progress_tab.set_progress(progress, progress_info)
#       Python 2.6 needed
#       completed = self.dump_thread.is_alive()
        if completed:
#            print progress
            self.close_pipe()
            if self.dump_thread.abort_requested:
                self.tasks_aborted()
            else:
                self.tasks_completed()
            self.dump_thread = None
        return not completed

    def open_folder_chooser(self):
        filechooser = FileChooser(mforms.OpenDirectory)
        filechooser.set_directory(self.savefolder_path)
        if filechooser.run_modal():
            self.savefolder_path = filechooser.get_path()
            self.folder_te.set_value(self.savefolder_path)
            if self.is_importing:
                self.refresh_table_list()

    def open_file_chooser(self, chooser_type=mforms.SaveFile):
        filechooser = FileChooser(chooser_type)
        filechooser.set_directory(os.path.dirname(self.savefile_path))
        if filechooser.run_modal():
            self.savefile_path = filechooser.get_path()
            self.file_te.set_value(self.savefile_path)
            if self.is_importing:
                self.refresh_table_list()

    def get_mysql_password(self, reset_password=False):
        parameterValues = self.instance_info.db_connection_params.parameterValues
        pwd = parameterValues["password"]
        if not pwd or reset_password:
            username = parameterValues["userName"]
            host = self.instance_info.db_connection_params.hostIdentifier
            title = self.is_importing and "Import" or "Export"
            if self.bad_password_detected:
                title += ' (type the correct password)'
                self.bad_password_detected = False
            accepted, pwd = mforms.Utilities.find_or_ask_for_password(title, host, username, reset_password)
            if not accepted:
                return None
        return pwd

    def stop(self):
        if self.dump_thread:
            self.dump_thread.kill()

    def failed(self, message):
        self.progress_tab.did_fail(message)

    def cancelled(self, message):
        self.progress_tab.did_cancel(message)


####################################################################################################
## Import
####################################################################################################

class WbAdminImportTab(WbAdminSchemaListTab):
    def __init__(self, owner, instance_info, progress_tab):
        WbAdminSchemaListTab.__init__(self, owner, instance_info, progress_tab, True)
        self.table_list_model = TableListModel()
        self.export_button.set_text("Start Import")
        self.tables_paths = {}
        self.views_paths = {}

    def folder_path_changed(self):
        self.folder_load_btn.set_enabled(True)
        self.savefolder_path = self.folder_te.get_string_value()


    def refresh_table_list(self):
        def parse_name_from_single_table_dump(path):
            import codecs
            f = codecs.open(path, encoding="utf-8")
            schema = None
            table = None
            is_view = False
            for line in f:
                if line.startswith("-- Host:"):
                    schema = line.partition("Database: ")[-1].strip()
                    if table:
                        break
                elif line.startswith("CREATE TABLE"):
                    table = line.rstrip("\n\r (").partition("CREATE TABLE")[-1].strip()
                    if table[0] == '`':
                        table = table[1:-1]
                    if schema:
                        break
                elif line.startswith("/*!50001 VIEW") or line.startswith("/*!50003 CREATE*/ /*!50020 DEFINER=") or line.startswith("/*!50106 CREATE*/ /*!50117 DEFINER="):
                    is_view = True
                    table = "Views, routines, events etc"
                    if schema:
                        break
            return schema, table, is_view

        self.folder_load_btn.set_enabled(False)
        tables_by_schema = {}
        # (schema, table) -> path
        self.tables_paths = {}
        self.views_paths = {}
        self.schema_list.freeze_refresh()
        self.schema_list.clear_rows()
        try:
            save_to_folder = not self.fileradio.get_active()
            if save_to_folder:
                self.progress_tab.set_start_enabled(False)
                path = self.savefolder_path
                dirList=os.listdir(path)
                for fname in dirList:
                    fullname = os.path.join(path, fname)
                    if os.path.isfile(fullname) and os.path.splitext(fullname)[1] == ".sql":
                        # open the backup file and look for schema and table name in it
                        schema, table, is_view = parse_name_from_single_table_dump(fullname)
                        if not schema or not table:
                            self.progress_tab.print_log_message("%s does not contain schema/table information" % fullname)
                            continue
                        if tables_by_schema.has_key(schema):
                            tables, selection = tables_by_schema[schema]
                            tables.append(table)
                            tables.sort()
                            selection.add(table) # select all by default
                        else:
                            tables_by_schema[schema] = ([table], set([table]))
                        if is_view:
                            self.views_paths[(schema, table)] = fullname
                            self.table_list_model.set_routines_placeholder((schema, table))
                        else:
                            self.tables_paths[(schema, table)] = fullname

                if not tables_by_schema:
                    Utilities.show_message("Open Dump Folder", "There were no dump files in the selected folder.", "OK", "", "")
                else:
                    names = tables_by_schema.keys()
                    names.sort()
                    for schema in names:
                        row = self.schema_list.add_row()
                        self.schema_list.set_bool(row, 0, True)
                        self.schema_list.set_string(row, 1, "db.Schema.16x16.png")
                        self.schema_list.set_string(row, 2, schema)
                
                self.progress_tab.set_start_enabled(True)
            self.schema_list.thaw_refresh()
        except Exception, exc:
            import traceback
            self.schema_list.thaw_refresh()
            traceback.print_exc()
            Utilities.show_error("Error Opening Dump", str(exc), "OK", "", "")
            self.folder_load_btn.set_enabled(True)
            self.export_button.set_enabled(False)
            self.failed(str(exc))
        self.table_list_model.set_tables_by_schema(tables_by_schema)

    def get_path_to_mysql(self):
        # get path to mysql client from options        
        try:
            path = grt.root.wb.options.options["mysqlclient"]
            if path:
                if os.path.exists(path):
                    return path
                if any(os.path.exists(os.path.join(p,path)) for p in os.getenv("PATH").split(os.pathsep)):
                    return path
                return None
        except:
            return None

        if sys.platform == "darwin":
            # if path is not specified, use bundled one
            return mforms.App.get().get_resource_path("mysql")
        elif sys.platform == "win32":
            return mforms.App.get().get_resource_path("mysql.exe")
        else:
            # just pick default
            if any(os.path.exists(os.path.join(p,"mysql")) for p in os.getenv("PATH").split(os.pathsep)):
                return "mysql"
            return None

    def start(self):
        self.progress_tab.set_start_enabled(False)
        self.progress_tab.did_start()
        self.progress_tab.set_status("Import is running ...")

        from_folder = not self.fileradio.get_active()

        operations = []
        if from_folder:
          self.path = self.folder_te.get_string_value()
        else:
          self.path = self.file_te.get_string_value()
        #self.path = self.folder_te.get_string_value() if from_folder else self.file_te.get_string_value()
        
        if from_folder:
            selection = self.table_list_model.get_full_selection()
            # make sure routines, views and stuffs get imported last
            if self.table_list_model.routines_placeholder in selection:
                selection.remove(self.table_list_model.routines_placeholder)
                selection.append(self.table_list_model.routines_placeholder)
            for schema, table in selection:
                logmsg = "Restoring %s (%s)" % (schema, table)
                path = self.tables_paths.get((schema, table))
                # description, object_count, extra_args, objects, pipe_factory
                if path != None: 
                    task = DumpThread.TaskData(logmsg, 1, [], [path], lambda:None)
                    #operations.insert(0,task) 
                    operations.append(task)
                else: 
                    path = self.views_paths.get((schema, table)) 
                    task = DumpThread.TaskData(logmsg, 1, [], [path], lambda:None)
                    if path != None: 
                        operations.append(task) 
        else:
            if not os.path.exists(self.path):
                Utilities.show_message("Dump file not found", u"File %s doesn't exist" % self.path, "OK", "", "")
                self.failed(u"Dump file not found: File %s doesn't exist" % self.path)
                return
            logmsg = "Restoring " + self.path
            # description, object_count, pipe_factory, extra_args, objects
            task = DumpThread.TaskData(logmsg, 1, [], [self.path], lambda:None)
            operations.append(task)
#            operations.append((logmsg, 1, lambda:None, [], [self.path]))


        connection_params = self.instance_info.db_connection_params
        tunnel = ConnectionTunnel(connection_params)

        conn = connection_params.parameterValues


        if connection_params.driver.name == "MysqlNativeSocket":
            host_option = "--protocol="+("pipe" if sys.platform == "win32" else "socket")
            if conn["socket"]:
                port_option = "--socket=" + [conn["socket"]][0]
            else:
                port_option = ""
        else:
            if tunnel.port or conn["port"]:
                port_option = "--port=" + str(tunnel.port or conn["port"])
            else:
                port_option = ""
            if (tunnel.port and ["localhost"] or [conn["hostName"]])[0]:
                host_option = "--host=" + (tunnel.port and ["localhost"] or [conn["hostName"]])[0]
            else:
                host_option = ""
        params = [
        "--password=",
        host_option,
        "--user=" + conn["userName"],
        port_option,
        "--default-character-set=utf8",
        "--comments",
        "<" # the rest of the params will be redirected from stdin
        ]
        params = [item for item in params if item]
        if connection_params.driver.name != "MysqlNativeSocket":
            if tunnel.port:
                 params.insert(1, "--protocol=tcp")
        cmd = self.get_path_to_mysql()
        if cmd == None:
            self.failed("mysql command was not found, please install it or configure it in Preferences -> Administrator")
            return
#        if cmd[0] != '"':
#            cmd = '"' + cmd + '"'
        #cmd += " " + (" ".join(params))
        cmd = subprocess.list2cmdline([cmd] + params)

        password = self.get_mysql_password()
        if password is None:
            self.cancelled("Password Input Cancelled")
            return

        self.dump_thread = DumpThread(cmd, operations, password, self, (self.progress_tab.logging_lock, self.progress_tab.log_queue))
        self.dump_thread.is_import = True
        self.dump_thread.start()
        Utilities.add_timeout(float(0.4), self.update_progress)

    def fail_callback(self):
        pass

    def close_pipe(self):
        pass
    
    def tasks_aborted(self):
        self.cancelled(time.strftime('%X ') + "Aborted by User")
        self.progress_tab.print_log_message("Restored database(s) maybe in an inconsistent state")


    def tasks_completed(self):
        logmsg = time.strftime('%X ') + u"Import of %s has finished" % self.path
        if self.dump_thread.error_count > 0:
            self.progress_tab.set_status("Import Completed With %i Errors" % self.dump_thread.error_count)
            logmsg += " with %i errors" % self.dump_thread.error_count
        else:
            self.progress_tab.set_status("Import Completed")
        self.progress_tab.print_log_message(logmsg)
        self.progress_tab.did_complete()

    ######################### test code

    def setup_test(self):
        print "test_setup"

        db_connection = self.owner.ctrl_be.sql

        try:
            db_connection.execute("DROP DATABASE IF EXISTS 1wb_export_test")
        except Exception, e:
             return "Error executing test setup query(%s)"%(e)
        self.dumpfile = tempfile.NamedTemporaryFile(delete=False)
        f = open(self.dumpfile.name,"w")
        initscript = [
        "CREATE DATABASE  IF NOT EXISTS `1wb_export_test`;",
        "USE `1wb_export_test`;",
        "CREATE  TABLE IF NOT EXISTS `1wb_export_test`.`test_table` ( \
        `id` INT(11) NOT NULL AUTO_INCREMENT ,\
        `predbc` DECIMAL(17,5) NULL DEFAULT NULL ,\
        `picms` DECIMAL(5,2) NULL DEFAULT NULL ,  \
        PRIMARY KEY (`id`) );",
        "INSERT INTO `1wb_export_test`.`test_table` VALUES \
        (1,'33.00000','123.00'),(2,'444.00000','12.00');"
        ]
        f.writelines(initscript)
        f.close()
        return None

    def select_file(self):
        self.folderradio.set_active(False)
        self.fileradio.set_active(True)
        self.set_save_option()
        self.savefile_path = self.dumpfile.name
        self.file_te.set_value(self.savefile_path)
        return None


    def start_restore(self):
            print "Starting Restore"
            self.start()
            return None

    def check_result(self):
        def check_val(result,name,expected_val):
            resval = result.unicodeByName(name)
            expected_val = unicode(expected_val)
            return (resval == expected_val and [None] or ["Wrong data got %s for %s instead of %s"%(resval,name,expected_val)])[0]

        db_connection = self.owner.ctrl_be.sql
        try:
            result = db_connection.exec_query("SELECT * FROM `1wb_export_test`.`test_table`")
            if not result.nextRow():
                return "Restored table is empty"
            res = check_val(result,"id",1)
            if res != None:
                return res
            res = check_val(result,"predbc","33.00000")
            if res != None:
                return res
            res = check_val(result,"picms","123.00")
            if res != None:
                return res
            if not result.nextRow():
                return "Restored doesn't have enough data"
            res = check_val(result,"id",2)
            if res != None:
                return res
            res = check_val(result,"predbc","444.00000")
            if res != None:
                return res
            res = check_val(result,"picms","12.00")
            if res != None:
                return res


        except:
            return "Error executing test data select"
        return None

    def cleanup(self):
        db_connection = self.owner.ctrl_be.sql
        try:
            db_connection.execute("DROP DATABASE IF EXISTS 1wb_export_test")
        except:
            return "Error executing test clean up query"
        if self.dumpfile!= None:
            self.dumpfile.close()
            os.remove(self.dumpfile.name)
        return None

    def test_clicked(self):
        self.test_steps = deque(
        [self.setup_test, self.select_file,
        self.start_restore,
#        lambda:None,lambda:None,lambda:None,
        self.check_result,
        self.cleanup
        ])
        Utilities.add_timeout(float(1.0), self.run_test)
        print "Export Test"

    def run_test(self):
        if not len(self.test_steps):
            print "Test OK"
            return False
        retval = self.test_steps.popleft()()
        if retval != None:
            print "Test failed: ",retval
            return False
        return True


####################################################################################################
## Export
####################################################################################################

class WbAdminExportTab(WbAdminSchemaListTab):

    class ExportTableListModel(TableListModel):
        def __init__(self):
            TableListModel.__init__(self)
            self.views_by_schema = {}
            self.schemasqls = {}
            self.schemas_to_load = {}
            self.schemas = []
            self.load_schema_data = lambda:None

        def reset(self):
            self.tables_by_schema = {}
            self.views_by_schema = {}
            self.schemasqls = {}

        def get_schema_names(self):
            return self.schemas

        def set_schema_data(self, schema, schematables_and_views, viewlist, dbsql):
            self.tables_by_schema[schema] = schematables_and_views, set()
            self.views_by_schema[schema] = set(viewlist)
            self.schemasqls[schema] = dbsql

        def get_schema_sql(self, schema):
            return self.schemasqls[schema]

        def is_view(self, schema, table):
            return table in self.views_by_schema[schema]

        def list_icon_for_table(self, schema, table):
            return "db.View.16x16.png" if self.is_view(schema, table) else "db.Table.16x16.png"

        def set_schema_list(self,schemas_to_load):
            self.schemas = schemas_to_load
            self.schemas_to_load = schemas_to_load

        def get_tables(self, schema):
            if schema in self.schemas_to_load:
#                print "Loading: ",schema,self.load_schema_data(schema)
                schema,schematables,viewlist,dbsql = self.load_schema_data(schema)
                self.set_schema_data(schema,schematables,viewlist,dbsql)
                self.schemas_to_load.remove(schema)
            tables, selection = self.tables_by_schema[schema]
            return tables


        def validate_single_transaction(self, schemas_to_dump):
            return True


    class TableRefreshThread(threading.Thread):
        def __init__(self, owner):
            self.owner = owner
            threading.Thread.__init__(self)

        def run(self):
            self.owner.refresh_table_list_thread()

    def __init__(self, owner, instance_info, progress_tab):
        self.table_list_model = self.ExportTableListModel()
        WbAdminSchemaListTab.__init__(self, owner, instance_info, progress_tab, False)
        self.schemasqls = {}
        self.refresh_canceled = False
                        
        self.savefolder_path = os.path.join(self.get_default_dump_folder(), time.strftime("Dump%Y%m%d"))
        self.savefile_path = self.savefolder_path + ".sql"
        self.basepath = self.savefolder_path
        self.update_paths()
        self.file_te.set_value(self.savefile_path)
        self.folder_te.set_value(self.savefolder_path)
 
        self.table_list_model.load_schema_data = self.load_schema_tables
#        self.filefolder_label.set_text("Save to")
        # run mysqldump --help to get default option values
        self.mysqldump_defaults = self.check_mysqldump_defaults()


    def close(self):
        self.refresh_canceled = True

    def load_schema_tables(self,schema):
        schematables_and_views = []
        viewlist = []
        dbsql = ""
        try:
            self.refresh_state= "Retrieving tables data for schema " + schema
            dbcreate = self.owner.ctrl_be.exec_query("SHOW CREATE DATABASE `"+escape_sql_identifier(schema)+"`")
            tableset = self.owner.ctrl_be.exec_query("SHOW FULL TABLES FROM `"+escape_sql_identifier(schema)+"`")
            dbcreate.nextRow()
            dbsql = dbcreate.unicodeByName("Create Database")
            parts = dbsql.partition("CREATE DATABASE ")
            dbsql = u"%s%s IF NOT EXISTS %s;\nUSE `%s`;\n" % (parts[0], parts[1], parts[2], escape_sql_identifier(schema))
            while tableset.nextRow():
                tabletype = tableset.unicodeByName("Table_type")
                tablename = tableset.unicodeByName("Tables_in_"+schema)
                if tabletype == "VIEW":
                    viewlist.append(tablename)
                schematables_and_views.append(tablename)
            del tableset
        except Exception, exc:
            import traceback
            traceback.print_exc()
            print "Error retrieving table list form schema '",schema,"'"
            self.progress_tab.print_log_message("Error Fetching Table List From %s (%s)" % (schema, str(exc)) )
        return schema,schematables_and_views,viewlist,dbsql


    def refresh_table_list_thread(self):
        self.table_list_model.reset()
        try:
            result = self.owner.ctrl_be.exec_query("SHOW DATABASES")
            schema_names = []
            while result.nextRow():
                value = result.unicodeByName("Database")
                if value == "information_schema":
                    continue
                schema_names.append(value)            
            del result
            self.table_list_model.set_schema_list(schema_names)
            schema_cntr = 1
            if schema_names:
                self.refresh_progress = float(schema_cntr) / len(schema_names)
                for schema in schema_names:
#                    schematables,viewlist,dbsql = self.load_schema_tables(schema)
#                     finally:
                    schema_cntr += 1
                    self.refresh_progress = float(schema_cntr) / len(schema_names)
#                    self.table_list_model.set_schema_data(schema,(schematables, set()),viewlist,dbsql)
            else:
                self.refresh_progress = 1
        except Exception, exc:
            self.print_log_message("Error updating DB: %s" % str(exc) )
#        finally:
        self.refresh_completed = True

    def refresh_table_list(self):
        self.table_list_model.reset()
        ####self.refresh_progressbar.set_value(0)
        
        if not self.owner.ctrl_be.is_sql_connected():
            return

        #self.hintlabel.set_text("Schema list update...")
        self.refresh_state = "Retrieving schema list"
        self.refresh_progress = 0
        self.schema_list.clear_rows()
        self.refresh_button.set_enabled(False)
        self.refresh_thread = self.TableRefreshThread(self)
#        refresh_thread.run()
        self.refresh_completed = False
        self.refresh_canceled = False
        self.refresh_thread.start()
        Utilities.add_timeout(float(0.4), self.update_refresh)

    def update_refresh(self):
        if self.refresh_canceled:
            return False

        self.progress_tab.flush_queued_logs()

        if self.refresh_progress > 1:
            self.refresh_progress = float(1)
        ####self.refresh_progressbar.set_value(self.refresh_progress)
        self.select_summary_label.set_text(self.refresh_state)
        if not self.refresh_completed:
            return True
        ####self.refresh_progressbar.set_value(0)
        names = self.table_list_model.get_schema_names()
        names.sort()
        self.schema_list.freeze_refresh()
        for schema in names:
            r = self.schema_list.add_row()
            self.schema_list.set_string(r, 1, "db.Schema.16x16.png")
            self.schema_list.set_string(r, 2, schema)
            self.schema_list.set_bool(r, 0, 0)
        self.schema_list.thaw_refresh()
        self.refresh_button.set_enabled(True)
        self.select_summary_label.set_text("")
        ###self.hintlabel.set_text("Press [Start Export] to start...")
        return False


    def update_paths(self):
        pathcntr = 1
        while os.path.exists(self.savefolder_path):
            self.savefolder_path = self.basepath + "-" + str(pathcntr)
            pathcntr += 1
        pathcntr = 1
        while os.path.exists(self.savefile_path):
            self.savefile_path = self.basepath + "-" + str(pathcntr) + ".sql"
            pathcntr += 1

  
    def get_path_to_mysqldump(self):
        # get path to mysqldump from options        
        try:
            path = grt.root.wb.options.options["mysqldump"]
            if path:
                if os.path.exists(path):
                    return path
                if any(os.path.exists(os.path.join(p,path)) for p in os.getenv("PATH").split(os.pathsep)):
                    return path
                self.print_log_message("mysqldump path specified in configurations is invalid: %s"%path)
                return None
        except:
            return None

        if sys.platform == "darwin":
            # if path is not specified, use bundled one
            return mforms.App.get().get_resource_path("mysqldump")
        elif sys.platform == "win32":
            return mforms.App.get().get_resource_path("mysqldump.exe")
        else:
            # just pick default
            if any(os.path.exists(os.path.join(p,"mysqldump")) for p in os.getenv("PATH").split(os.pathsep)):
                return "mysqldump"
            return None

    def check_mysqldump_version(self, about_to_run=False):
        path = self.get_path_to_mysqldump()
        if not path:
            self.print_log_message("mysqldump command was not found, please install it or configure it in Edit -> Preferences -> MySQL")
            return False
        output = []
        rc = local_run_cmd('"%s" --version' % path, output_handler= lambda line,l=output: l.append(line))
        output = "\n".join(output)
        msg = None
        error = False
        
        server_version = self.owner.ctrl_be.raw_version
        server_major, server_minor = self.owner.ctrl_be.get_server_version()[:2]
        if rc or not output:
            msg = "Error retrieving version from %s:\n%s (exit %s)"%(path, output, rc)
            error = True
        else:
            s = re.match(".*Distrib ([\d.a-z]+).*", output)
            if not s:
                msg = "Could not parse version number from %s:\n%s"%(path, output)
                error = True
            else:
                version = s.groups()[0]
                major, minor = [int(i) for i in version.split(".")[:2]]
                if major < server_major or (major == server_major and minor < server_minor):
                    msg = "%s is version %s, but the MySQL Server to be dumped has version %s.\nBecause the version of mysqldump is older than the server, some features may not be backed up properly.\nIt is recommended you upgrade your local MySQL client programs, including mysqldump to a version equal to or newer than that of the target server.\nThe path to the dump tool must then be set in Preferences -> Administrator -> Path to mysqldump Tool:"%(path, version, server_version)
        if msg:
          if about_to_run:
              if error:
                  mforms.Utilities.show_error("Error Checking mysqldump Version", msg, "OK", "", "")
                  return False
              else:
                  r = mforms.Utilities.show_warning("mysqldump Version Mismatch", msg, "Continue Anyway", "Cancel", "")
                  return r == mforms.ResultOk
          else:
              self.print_log_message("WARNING") 
              if error:
                  self.print_log_message("Error checking mysqldump version")
                  self.print_log_message(msg)
              else:
                  self.print_log_message(msg)
        
        return True


    def check_mysqldump_defaults(self):
        defaults = {}
        # check mysqldump default values
        path = self.get_path_to_mysqldump()
        if path:
            output = []
            rc = local_run_cmd('"%s" --help' % path, output_handler= lambda line,l=output: l.append(line))
            ok = False
            for line in ("\n".join(output)).split("\n"):
                line = line.strip()
                if line.startswith("-----------") and line.endswith("-----------"):
                    ok = True
                    continue
                if ok:
                    t = line.split()
                    if len(t) == 2:
                        k, v = t
                        if v in ("TRUE", "FALSE"):
                            defaults[k] = v
        return defaults


    def validate_single_transaction(self, starting):
        if self.single_transaction_check.get_active() and self.owner.get_lock_tables() == {'lock-tables': 'TRUE'}:
            r = mforms.Utilities.show_warning("Export to Disk", 
                              "Single transaction with --lock-tables is not supported.\n"
                              "Disable --lock-tables?",
                              "Disable", "Cancel", "")
            if r == mforms.ResultOk:
                self.owner.set_lock_tables(False)
                return True
            else:
                return False
            
        return True


    def single_transaction_clicked(self):
        self.validate_single_transaction(False)

    class ViewDumpData(DumpThread.TaskData):
        def __init__(self,schema,views,make_pipe):
            title = "Dumping " + schema + " views"
            DumpThread.TaskData.__init__(self, title, len(views), [], [schema] + views, make_pipe)

    class TableDumpData(DumpThread.TaskData):
        def __init__(self,schema,table,make_pipe):
            title = "Dumping " + schema
            title += " (%s)" % table
            DumpThread.TaskData.__init__(self,title, 1, [], [schema, table], make_pipe)

    class TableDumpNoData(DumpThread.TaskData):
        def __init__(self,schema,table,make_pipe):
            title = "Dumping " + schema
            title += " (%s)" % table
            DumpThread.TaskData.__init__(self,title, 1, ["--no-data"], [schema, table],make_pipe)

    class ViewsRoutinesEventsDumpData(DumpThread.TaskData):
        def __init__(self, schema, views, args, make_pipe):
            title = "Dumping " + schema + " views and/or routines and/or events"
            if not views:
                extra_args = ["--no-create-info"]
            else:
                extra_args = []
            DumpThread.TaskData.__init__(self,title, len(views), ["--skip-triggers", " --no-data" ," --no-create-db"] + extra_args + args, [schema] + views, make_pipe)

    def dump_to_folder(self, schemaname, tablename):
        self.close_pipe() 
        path = os.path.join(self.path, normalize_filename(schemaname) + "_" + normalize_filename(tablename) + '.sql')
        i = 0
        # check if the path already exists (they could become duplicated because of normalization)
        while os.path.exists(path):
            path = os.path.join(self.path, normalize_filename(schemaname) + "_" + normalize_filename(tablename) + ('%i.sql'%i))
        self.out_pipe = open(path,"w")
        data = self.table_list_model.get_schema_sql(schemaname)
        if type(data) is unicode:
            data = data.encode("utf-8")
        self.out_pipe.write(data)
        self.out_pipe.flush()
        return self.out_pipe

        
    def start(self):
        self.progress_tab.set_start_enabled(False)

        if not self.check_mysqldump_version(True):
            self.progress_tab.set_start_enabled(True)
            return 

        if not self.validate_single_transaction(True):
            self.progress_tab.set_start_enabled(True)
            return 
        single_transaction = self.single_transaction_check.get_active()
        #dump_views = self.dump_view_check.get_active()
        skip_data = self.skip_data_check.get_active()
        dump_routines = self.dump_routines_check.get_active()
        dump_events = self.dump_events_check.get_active()

        save_to_folder = not self.fileradio.get_active()

        if save_to_folder:
          self.path = self.folder_te.get_string_value()
        else:
          self.path = self.file_te.get_string_value()

        # gather objects to dump
        schemas_to_dump = self.table_list_model.get_objects_to_dump(include_empty_schemas=True)
        
        tables_to_ignore = self.table_list_model.get_tables_to_ignore()

        if len(schemas_to_dump) == 0:
            self.progress_tab.print_log_message(time.strftime('%X ') + "Nothing to do, no schemas or tables selected." + "\n")
            self.progress_tab.set_start_enabled(True)
            return
        
        # assemble list of operations/command calls to be performed
        operations = []
        if save_to_folder:
            if not os.path.exists(self.path):
                try:
                    os.makedirs(self.path, mode=0700)
                except:
                    Utilities.show_error('Error', 'Access to "%s" failed' % self.path, "OK", "", "")
                    self.export_button.set_enabled(True)
                    return
            for schema, tables in schemas_to_dump:
                views = []
                for table in tables:
                    if self.table_list_model.is_view(schema, table):
                        views.append(table)
                    else:
                        title = "Dumping " + schema
                        title += " (%s)" % table
                        # description, object_count, pipe_factory, extra_args, objects
                        if skip_data:
                            task = self.TableDumpNoData(schema,table,lambda schema=schema,table=table:self.dump_to_folder(schema, table))
                        else:
                            task = self.TableDumpData(schema,table,lambda schema=schema,table=table:self.dump_to_folder(schema, table))
                        operations.append(task)
                # dump everything non-tables to file for routines
                #if views:
                #    task = self.ViewDumpData(schema, views, lambda schema=schema, table=table:self.dump_to_folder(schema, "routines"))
                #    operations.append(task)
                #if dump_events:
                #    task = self.EventDumpData(schema, lambda schema=schema, table=table:self.dump_to_folder(schema, "routines"))
                #    operations.append(task)
                if views or dump_routines or dump_events:
                    args = []
                    if dump_routines:
                        args.append("--routines")
                    if dump_events:
                        args.append("--events")
                    task = self.ViewsRoutinesEventsDumpData(schema, views, args, lambda schema=schema, table=None:self.dump_to_folder(schema, "routines"))
                    operations.append(task)
        else: # single file
            if not os.path.exists(os.path.dirname(self.path)):
                try:
                    os.makedirs(os.path.dirname(self.path))
                except:
                    Utilities.show_error('Error', 'Access to "%s" failed' % self.path, "OK", "", "")
                    self.export_button.set_enabled(True)
                    return
                    

            # if there is a single schema to dump or single-transaction is off we allow selecting the individual tables, otherwise we need to bulk dump the whole db
            #if (len(schemas_to_dump) != 1 and not single_transaction) or (len(schemas_to_dump) == 1 not self.table_list_model.validate_single_transaction(schemas_to_dump)):
            if len(schemas_to_dump) == 1 or (len(schemas_to_dump) > 1 and (not single_transaction or not self.table_list_model.validate_single_transaction(schemas_to_dump))):
                for schema, tables in schemas_to_dump:
                    title = "Dumping " + schema
                    title += " (%s)" % ", ".join(tables)
                    objects = [schema] + tables                    
                    if single_transaction:
                        params = ["--single-transaction=TRUE"]
                    else:
                        params = []
                    if dump_routines:
                        params.append("--routines")
                    if dump_events:
                        params.append("--events")
                    if skip_data or not tables:
                        params.append("--no-data")
                    if not tables:
                        params.append("--no-create-info=TRUE")
                        params.append("--skip-triggers")
                    # description, object_count, pipe_factory, extra_args, objects
                    task = DumpThread.TaskData(title, len(tables), params, objects, lambda schema=schema:self.dump_to_file([schema]))
                    operations.append(task)
#                    operations.append((title, len(tables), lambda schema=schema:self.dump_to_file([schema]), params, objects))
            else:
                params = []
                schema_names = [s[0] for s in schemas_to_dump]
                count = sum([len(s[1]) for s in schemas_to_dump])
                title = "Dumping " + ", ".join(schema_names)
                if dump_routines:
                    params.append("--routines")
                if dump_events:
                    params.append("--events")
                if skip_data:
                    params.append("--no-data")
                params += ["--ignore-table=%s.%s"%(s,t) for s, t in tables_to_ignore]
                if single_transaction:
                    params = ["--single-transaction=TRUE", "--databases"]
                else:
                    params = ["--databases"]
                # --databases includes CREATE DATABASE info, so it's not needed for dump_to_file()
                # description, object_count, pipe_factory, extra_args, objects
                task = DumpThread.TaskData(title, count, params, schema_names, lambda:self.dump_to_file([]))
                operations.append(task)
#                operations.append((title, count, lambda:self.dump_to_file([]), params, schema_names))
    
        connection_params = self.instance_info.db_connection_params
        tunnel = ConnectionTunnel(connection_params)

        conn = connection_params.parameterValues

        if connection_params.driver.name == "MysqlNativeSocket":
            params = {
            "protocol":"pipe" if sys.platform == "win32" else "socket",
            "socket":([conn["socket"]])[0],
            "default-character-set":"utf8",
            "user":conn["userName"]
            }
            if not params["socket"]:
                del params["socket"]
        else:
            params = {
            "host":(tunnel.port and ["localhost"] or [conn["hostName"]])[0],
            "port":(tunnel.port and [str(tunnel.port)] or [conn["port"]])[0],
            "default-character-set":"utf8",
            "user":conn["userName"]
            }
            if tunnel.port:
                params["protocol"] = "tcp"
            if not params["port"]:
                del params["port"]
            if not params["host"]:
                del params["host"]
        params.update(self.owner.get_export_options(self.mysqldump_defaults))
        cmd = self.get_path_to_mysqldump()
        if cmd == None:
            self.failed("mysqldump command was not found, please install it or configure it in Edit -> Preferences -> MySQL")
            return
        #if cmd[0] != '"':
        #    cmd = '"' + cmd + '"'
        #cmd += " --password="
        args = [cmd, "--password="]
        for paramname, paramvalue in params.items():
            args.append("--"+paramname+((paramvalue != None and ["="+str(paramvalue)] or [""])[0]))
        cmd = subprocess.list2cmdline(args)
        password = self.get_mysql_password()
        if password is None:
            self.cancelled("Password Input Cancelled")
            return
        self.progress_tab.did_start()
        self.progress_tab.set_status("Export is running ...")

        self.dump_thread = DumpThread(cmd, operations, password, self, (self.progress_tab.logging_lock, self.progress_tab.log_queue))
        self.dump_thread.is_import = False
        self.dump_thread.start()
        Utilities.add_timeout(float(0.4), self.update_progress)

    def dump_to_file(self, schemanames):
        if self.out_pipe == None:
            self.out_pipe = open(self.path,"w")
        for schema in schemanames:
            self.out_pipe.write(self.table_list_model.get_schema_sql(schema).encode('utf-8'))
        self.out_pipe.flush()
        return self.out_pipe

    def fail_callback(self):
        fname = self.out_pipe.name
        self.close_pipe()
        os.remove(fname)

    def close_pipe(self):
        if self.out_pipe != None:
            self.out_pipe.close()
            self.out_pipe = None

    def tasks_aborted(self):
        if self.path:
            try:
                os.rename(self.path, self.path+".cancelled")
                self.progress_tab.print_log_message("Partial backup file renamed to %s.cancelled" % self.path)
            except Exception, exc:
                self.progress_tab.print_log_message("Error renaming partial backup file %s: %s" % (self.path, exc))

        self.cancelled(time.strftime('%X ') + "Aborted by User")


    def tasks_completed(self):
        self.update_paths()
        self.file_te.set_value(self.savefile_path)
        self.folder_te.set_value(self.savefolder_path)
        logmsg = time.strftime(u'%X ') + "Export of %s has finished" % self.path.encode('utf-8')
        if self.dump_thread.error_count > 0:
            self.progress_tab.set_status("Export Completed With %i Errors" % self.dump_thread.error_count)
            logmsg += " with %i errors" % self.dump_thread.error_count
        else:
            self.progress_tab.set_status("Export Completed")
            
        self.progress_tab.print_log_message(logmsg)
        self.progress_tab.did_complete()

    ######################### test code

    def setup_test(self):
        print "test_setup"

        db_connection = self.owner.ctrl_be.sql

        try:
            db_connection.execute("DROP DATABASE IF EXISTS 1wb_export_test")
            db_connection.execute("CREATE DATABASE 1wb_export_test")
            db_connection.execute("CREATE  TABLE IF NOT EXISTS `1wb_export_test`.`test_table` ( \
            `id` INT(11) NOT NULL AUTO_INCREMENT ,\
            `predbc` DECIMAL(17,5) NULL DEFAULT NULL ,\
            `picms` DECIMAL(5,2) NULL DEFAULT NULL ,  \
            PRIMARY KEY (`id`) );")
            db_connection.execute("INSERT INTO `1wb_export_test`.`test_table` VALUES \
            (1,'33.00000','123.00'),(2,'444.00000','12.00');")
        except Exception, e:
             return "Error executing test setup query(%s)"%(e)
        self.resfile = tempfile.NamedTemporaryFile(delete=False)
        return None

    def check_refresh(self):
        print "Checking refresh"
        schema_index = None
        for row in range(self.schema_list.count()):
            schemaname = self.schema_list.get_string(row, 2)
            if "1wb_export_test" == schemaname:
               schema_index = row
               break
        if schema_index == None:
            return "No schema found in list"
        self.schema_list.set_bool(schema_index, 0, True)
        self.schema_list.set_selected(schema_index)
        self.schema_selected()
        self.select_all_tables()
        return None

    def select_file(self):
        self.folderradio.set_active(False)
        self.fileradio.set_active(True)
        self.set_save_option()
        self.savefile_path = self.resfile.name
        self.file_te.set_value(self.savefile_path)
        return None


    def start_dump(self):
            print "Starting Dump"
            self.start()
            return None

    def check_result(self):
        f = open(self.resfile.name,"r")
        found_use = False
        found_inserts = False
        for line in f:
            if line == "INSERT INTO `test_table` VALUES (1,'33.00000','123.00'),(2,'444.00000','12.00');\n":
                found_inserts = True
            if line == "INSERT INTO `test_table` VALUES (1,33.00000,123.00),(2,444.00000,12.00);\n":
                found_inserts = True
            if line == "USE `1wb_export_test`;\n":
                found_use = True
        f.close()
        if not found_use:
            return "USE statement missing in output file"
        if not found_inserts:
            return "INSERT statement missing in output file"
        return None

    def cleanup(self):
        db_connection = None
        if self.instance_info.db_connection_params:
          db_connection = MySQLConnection(self.instance_info.db_connection_params)
          error_location = None
          the_error = None
          try:
            db_connection.connect()
          except MySQLError, exc:
            error_location = exc.location
            the_error = str(exc)

          if not db_connection.is_connected:
            return "Could not Connect to MySQL Server at %s %s." % (error_location, the_error)
        else:
            return "No connection information specified in the server instance profile."

        try:
            db_connection.execute("DROP DATABASE IF EXISTS 1wb_export_test")
        except:
             return "Error executing test clean up query"

        if self.resfile != None:
            self.resfile.close()
            os.remove(self.resfile.name)
        return None

    def test_clicked(self):
        self.test_steps = deque(
        [self.setup_test,self.refresh_table_list,
        self.check_refresh, self.select_file,
        self.start_dump,
#        lambda:None,lambda:None,lambda:None,
        self.check_result,
        self.cleanup
        ])
        Utilities.add_timeout(float(1.0), self.run_test)
        print "Export Test"

    def run_test(self):
        if not len(self.test_steps):
            print "Test OK"
            return False
        retval = self.test_steps.popleft()()
        if retval != None:
            print "Test failed: ",retval
            return False
        return True

####################################################################################################
## Options
####################################################################################################

class WbAdminExportOptionsTab(mforms.Box):
    class Check_option_model:
        def __init__(self,optname,checkbox,default):
            self.optname = optname
            self.checkbox = checkbox
            self.default = default

        def get_option(self, defaults):
            is_bool_option = defaults.has_key(self.optname)
            value = self.checkbox.get_active() and "TRUE" or "FALSE"
            if is_bool_option:
                if defaults[self.optname] != value:
                    return {self.optname: value}
                return {}
            else:
                if self.default == "TRUE" and not self.checkbox.get_active():
                    return {"skip-"+self.optname:"TRUE"}
                else:
                    return {self.optname:(self.checkbox.get_active() and ["TRUE"] or ["FALSE"])[0]}

        def set_option(self, value):
            if value in ("TRUE", "FALSE"):
                self.checkbox.set_active(value == "TRUE")
            else:
                self.checkbox.set_active(value)

    class Text_option_model:
        def __init__(self, optname, textentry, default):
            self.optname = optname
            self.entry = textentry
            self.default = default
        
        def get_option(self, defaults):
            return {self.optname:self.entry.get_string_value() or self.default}

        def set_option(self, value):
            self.entry.set_value(value)


    def __init__(self, defaults_from_mysqldump):
        mforms.Box.__init__(self, False)
        self.set_managed()

        self.options = {}
        button_box = newBox(True)
        button_box.set_padding(8)
        button_box.set_spacing(12)
        self.restore_defaults_button = newButton()
        self.restore_defaults_button.set_text('Restore Defaults')
        self.restore_defaults_button.add_clicked_callback(self.restore_default_options)
        button_box.add_end(self.restore_defaults_button, False)
        self.add_end(button_box, False)
        outerbox = newBox(False)
        outerbox.set_padding(8)
        outerbox.set_spacing(12)
        for groupname, options in reversed(wb_admin_export_options.export_options.items()):
            box = newBox(False)
            box.set_padding(8)
            box.set_spacing(8)
            panel = newPanel(mforms.TitledBoxPanel)
            panel.set_title(groupname)
#            print groupname
            for optname, (option, default) in reversed(options.items()):
                # get the default value from mysqldump --help, if we don't have that data, use the stored default
                default = defaults_from_mysqldump.get(optname, default)
                checkbox = newCheckBox()
                checkbox.set_text("%s - %s"% (optname, option))
                checkbox.set_active(default == "TRUE")
                box.add(checkbox, False, True)
                self.options[optname] = self.Check_option_model(optname,checkbox,default)
            if groupname == "Other":
                max_allowed_packet_box = newBox(True)
                self.max_allowed_packet_te = newTextEntry()
                self.max_allowed_packet_te.set_value("1G")
                self.max_allowed_packet_te.set_size(40, -1)
                label = newLabel(" The maximum size of one packet or any generated/intermediate string. ")
                max_allowed_packet_box.add(label,False,False)
                max_allowed_packet_box.add(self.max_allowed_packet_te,False,True)
                max_allowed_packet_box.add(newBox(True),True,True)
                max_allowed_packet_box.add(newBox(True),True,True)
                max_allowed_packet_box.add(newBox(True),True,True)
                box.add(max_allowed_packet_box,False,True)
                self.options['max_allowed_packet'] = self.Text_option_model('max_allowed_packet', self.max_allowed_packet_te, "1G")
            panel.add(box)
            outerbox.add(panel, True, True)
        scrollpan = newScrollPanel(mforms.ScrollPanelNoFlags)
        scrollpan.add(outerbox)
        self.add(scrollpan, True, True)

    def get_lock_tables(self):
        return self.options["lock-tables"].get_option({'lock-tables': 'TRUE'}) # TODO: Check default value!!!

    def set_lock_tables(self, value):
        return self.options["lock-tables"].set_option(value)

    def get_options(self, defaults):
        options = {}
        for optname, getter in self.options.items():
            result = getter.get_option(defaults)
            if result != None:
                options.update(result)
        #options.update({"max_allowed_packet":self.max_allowed_packet_te.get_string_value()})
        return options

    def set_options(self, values):
        for k, v in values.items():
            if self.options.has_key(k):
                self.options[k].set_option(v)

    def restore_default_options(self):
        for option in self.options.values():
            option.set_option(option.default)

####################################################################################################

class WbAdminProgressTab(mforms.Box):
    def __init__(self, owner_tab, is_export):
        mforms.Box.__init__(self, False)
        self.set_managed()
        self.set_spacing(12)
        self.set_padding(8)
        self.owner_tab = owner_tab
        self.operation_tab = None
        self.is_export = is_export

        self.logging_lock = thread.allocate_lock()
        self.log_queue = deque([])

        statusbox = newBox(False)
        statusbox.set_spacing(2)
        self.dump_progressbar = newProgressBar()
        self.statlabel = newLabel("")
        statusbox.set_size(400, -1)
        if is_export:
            self.hintlabel = newLabel("Press [Start Export] to start...")
        else:
            self.hintlabel = newLabel("Press [Start Import] to start...")
        statusbox.add(self.hintlabel, False, False)
        statusbox.add(self.dump_progressbar, False, False)
        statusbox.add(newLabel("Status:"), False, False)
        statusbox.add(self.statlabel, False, False)

        self.progress_log = newTextBox(mforms.VerticalScrollBar)
        self.progress_log.set_read_only(True)

        self.add(statusbox, False, False)
        
        label = newLabel("Log:")
        self.add(label, False, False)
        self.add(self.progress_log, True, True)

        box = newBox(True)
        self.add(box, False, True)
        
        box.set_spacing(8)
        box.set_padding(0)
                
        self.export_button = newButton()
        if is_export:
            self.export_button.set_text("Start Export")
        else:
            self.export_button.set_text("Start Import")
            self.export_button.set_enabled(False)
        box.add_end(self.export_button, False, True)
        self.export_button.add_clicked_callback(self.start)

        self.stop_button = newButton()
        self.stop_button.set_text("Stop")
        self.stop_button.set_enabled(False)
        self.stop_button.add_clicked_callback(self.stop)
        box.add_end(self.stop_button, False, True)


    def set_progress(self, progress, progress_text):
        self.statlabel.set_text(progress_text)
        self.dump_progressbar.set_value(progress)


    def set_start_enabled(self, flag):
        self.export_button.set_enabled(flag)
        self.operation_tab.export_button.set_enabled(flag)


    def set_status(self, text):
        self.hintlabel.set_text(text)
        self.operation_tab.statlabel.set_text(text)


    def flush_queued_logs(self):
        self.logging_lock.acquire()
        while len(self.log_queue) > 0:
            self.progress_log.append_text_and_scroll(self.log_queue.popleft()+"\n", True)
        self.logging_lock.release()


    def print_log_message(self, message):
        if mforms.Utilities.in_main_thread():
            self.progress_log.append_text_and_scroll(message+"\n", True)
        else:
            self.logging_lock.acquire()
            self.log_queue.append(message+"\n")
            self.logging_lock.release()


    def start(self):
        self.operation_tab.start()
    
    def stop(self):
        self.operation_tab.stop()

    def did_start(self):
        self.owner_tab.switch_to_progress()
        self.set_start_enabled(False)
        self.stop_button.set_enabled(True)
        self.set_status("Export running...")

    def did_complete(self):
        self.set_start_enabled(True)
        self.stop_button.set_enabled(False)
        self.print_log_message("\n\n\n")

    def did_fail(self, message):
        self.progress_log.append_text_and_scroll(message+"\n", True)
        self.set_status("Operation Failed")
        self.set_start_enabled(True)
        self.stop_button.set_enabled(False)

    def did_cancel(self, message):
        self.progress_log.append_text_and_scroll(message+"\n", True)
        self.set_status("Operation Cancelled")
        self.dump_progressbar.set_value(0)
        self.set_start_enabled(True)
        self.stop_button.set_enabled(False)


####################################################################################################

class WbAdminExport(mforms.Box):
    ui_created = False

    def __init__(self, instance_info, ctrl_be, main_view):
        mforms.Box.__init__(self, False)
        main_view.ui_profile.apply_style(self, 'page')
        self.ctrl_be = ctrl_be
        self.set_managed()
        self.instance_info = instance_info
        self.main_view = main_view
        self.main_view.add_content_page(self, "DATA EXPORT / RESTORE", "Data Export", "admin_export_win")


    def page_activated(self):
        self.main_view.set_content_label(" Data Export")
        if not self.ui_created:
            self.suspend_layout()
            self.create_ui()
            self.resume_layout()
            self.ui_created = True
            self.export_tab.check_mysqldump_version()
            self.export_tab.refresh_table_list()

        if self.ctrl_be.is_sql_connected():
            self.warning.show(False)
            self.tabview.show(True)
        else:
            self.warning.show(True)
            self.tabview.show(False)


    def switch_to_progress(self):
        self.tabview.set_active_tab(2)


    def create_ui(self):
        self.suspend_layout()

        self.warning = not_running_warning_label()
        self.add(self.warning, False, True)

        self.tabview = newTabView(False)
        self.add(self.tabview, True, True)
        self.tabview.show(False)

        self.progress_tab = WbAdminProgressTab(self, True)
    
        self.export_tab = WbAdminExportTab(self, self.instance_info, self.progress_tab)
        self.tabview.add_page(self.export_tab, "Object Selection")

        self.options_tab = WbAdminExportOptionsTab(self.export_tab.mysqldump_defaults)
        self.tabview.add_page(self.options_tab, "Advanced Options")

        self.tabview.add_page(self.progress_tab, "Export Progress")

        self.resume_layout()
        self.recall_options()

    
    def shutdown(self): # called when admin tab is closed
        self.remember_options()
        if self.ui_created:
            self.export_tab.close()

    def get_lock_tables(self):
        return self.options_tab.get_lock_tables()

    def set_lock_tables(self, value):
        return self.options_tab.set_lock_tables(value)
 
 
    def get_export_options(self, defaults):
        options = self.options_tab.get_options(defaults)
        return options


    def remember_options(self):
        if self.ui_created:
            dic = grt.root.wb.options.options
            dic["wb.admin.export:exportType"] = self.export_tab.folderradio.get_active() and "folder" or "file"
            dic["wb.admin.export:selectedFolder"] = self.export_tab.folder_te.get_string_value()
            dic["wb.admin.export:selectedFile"] = self.export_tab.file_te.get_string_value()
            dic["wb.admin.export:singleTransaction"] = self.export_tab.single_transaction_check.get_active()
            dic["wb.admin.export:dumpRoutines"] = self.export_tab.dump_routines_check.get_active()
            dic["wb.admin.export:dumpEvents"] = self.export_tab.dump_events_check.get_active()
            dic["wb.admin.export:skipData"] = self.export_tab.skip_data_check.get_active()
            for key, value in self.get_export_options({}).items():
                dic["wb.admin.export.option:"+key] = value
            


    def recall_options(self):
        dic = grt.root.wb.options.options
        if dic.has_key("wb.admin.export:exportType"):
            if dic["wb.admin.export:exportType"] == "folder":
                self.export_tab.folderradio.set_active(True)
            else:
                self.export_tab.fileradio.set_active(True)
        self.export_tab.set_save_option()
#        if dic.has_key("wb.admin.export:selectedFolder"):
#            self.export_tab.folder_te.set_value(dic["wb.admin.export:selectedFolder"])
#        if dic.has_key("wb.admin.export:selectedFile"):
#            self.export_tab.file_te.set_value(dic["wb.admin.export:selectedFile"])
        if dic.has_key("wb.admin.export:singleTransaction"):
            self.export_tab.single_transaction_check.set_active(dic["wb.admin.export:singleTransaction"])
        if dic.has_key("wb.admin.export:dumpRoutines"):
            self.export_tab.dump_routines_check.set_active(dic["wb.admin.export:dumpRoutines"])
        if dic.has_key("wb.admin.export:dumpEvents"):
            self.export_tab.dump_events_check.set_active(dic["wb.admin.export:dumpEvents"])
        if dic.has_key("wb.admin.export:skipData"):
            self.export_tab.skip_data_check.set_active(dic["wb.admin.export:skipData"])
        values = {}
        for key in self.get_export_options({}).keys():
            if dic.has_key("wb.admin.export.option:"+key):
                values[key] = dic["wb.admin.export.option:"+key]
        self.options_tab.set_options(values)


####################################################################################################

class WbAdminImport(mforms.Box):
    ui_created = False

    def __init__(self, instance_info, ctrl_be, main_view):
        mforms.Box.__init__(self, False)
        main_view.ui_profile.apply_style(self, 'page')
        self.ctrl_be = ctrl_be
        self.set_managed()
        self.instance_info = instance_info
        self.main_view = main_view
        self.main_view.add_content_page(self, "DATA EXPORT / RESTORE", "Data Import/Restore", "admin_restore_data_win")


    def page_activated(self):
        self.main_view.set_content_label(" Data Import/Restore")
        if not self.ui_created:
            self.suspend_layout()
            self.create_ui()
            self.resume_layout()
            self.ui_created = True

        if self.ctrl_be.is_sql_connected():
            self.warning.show(False)
            self.tabview.show(True)
        else:
            self.warning.show(True)
            self.tabview.show(False)


    def switch_to_progress(self):
        self.tabview.set_active_tab(1)

    def create_ui(self):
        self.suspend_layout()

        self.warning = not_running_warning_label()
        self.add(self.warning, False, True)

        self.tabview = newTabView(False)
        self.add(self.tabview, True, True)
        self.tabview.show(False)

        self.progress_tab = WbAdminProgressTab(self, False)    
        self.import_tab = WbAdminImportTab(self, self.instance_info, self.progress_tab)
        self.tabview.add_page(self.import_tab, "Import from Disk")

        self.tabview.add_page(self.progress_tab, "Import Progress")

        self.resume_layout()



