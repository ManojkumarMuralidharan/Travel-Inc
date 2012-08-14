# Copyright (c) 2007, 2010, Oracle and/or its affiliates. All rights reserved.
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

import platform
import socket
import threading
import time
import subprocess
from mforms import App
from db_utils import QueryError, MySQLError
from wb_common import dprint_ex
import wb_admin_ssh
from wb_server_management import wbaOS

try:
 import _subprocess
except ImportError:
 pass


#===============================================================================
class DataSource(object):

  def __init__(self, name, mon_be, widget):
    self.widget   = None
    self.label_cb = None # method to create description
    self.calc_cb  = None
    self.name    = name
    self.mon_be  = mon_be
    self.ctrl_be = mon_be.get_ctrl_be()
    if widget is not None:
      self.widget   = widget[0]
      self.label_cb = widget[1]
      self.calc_cb  = widget[2]

  def poll(self):
    pass

#===============================================================================
class ShellDataSource(DataSource):
  cmds = None

  def __init__(self, name, cmds, mon_be, widget):
    DataSource.__init__(self, name, mon_be, widget)
    self.cmds = cmds

  def poll(self):
    results = []
    result = self.ctrl_be.execute_filtered_command(self.cmds)
    if result[1] == 0:
      result = result[0].strip(" \r\t\n,:.")
      if result != "":
        try:
          result = float(result.replace(',','.'))
        except ValueError, e:
          print "Error! Shell source ", self.cmds, "returned wrong value. Expected int or float but got", result
          result = 0
        if self.widget is not None:
          if self.calc_cb is not None:
            result = self.calc_cb(result)
          self.widget.set_value(result)
          if self.label_cb is not None:
            lbl = self.label_cb(result)
            self.ctrl_be.uitask(self.widget.set_description, lbl)


#===============================================================================
class Source(object):
  def __init__(self, name, ctrl_be, widget, variables, calc):
    self.name      = name
    self.ctrl_be   = ctrl_be
    self.widget    = widget[0]
    self.label_cb  = widget[1]
    self.variables = variables
    self.calc      = calc
    self.vars_set  = 0
    self.values    = [0] * len(variables)
    self.vars_len = len(variables)

  def set_var(self, i, value):
    self.values[i] = value
    self.vars_set += 1

  def calculate(self):
    result = None
    if self.vars_len <= self.vars_set:
      self.vars_set = 0
      args = tuple(self.values)
      if self.calc is not None:
        result = self.calc(args)
      else:
        result = args[0]

      if result is not None and self.widget is not None:
        try:
          result = float(result)
        except ValueError, e:
          print("Error! Calculation returned returned wrong value. Expected int or float but got", result)
          result = 0.0
        self.widget.set_value(result)
        if self.label_cb is not None:
          lbl = self.label_cb(result)
          self.ctrl_be.uitask(self.widget.set_description, lbl)

#===============================================================================
class SqlDataSource(DataSource):
  stopped = 0
  started = 1
  skip_poll = 2
  polling   = 3

  def __init__(self, sql, mon_be):
    DataSource.__init__(self, "sql_source", mon_be, None)
    self.sql = sql
    self.mon_be = mon_be
    self.sources = {}
    self.rev_sources = {}
    self.dbconn = None
    self.ctrl_be.add_me_for_event("server_started", self)
    self.ctrl_be.add_me_for_event("server_stopped", self)
    self.ctrl_be.add_me_for_event("shutdown", self)
    self.poll_control = self.stopped
    dprint_ex(3, "SqlDataSource created. poll_control =", self.poll_control)

  def server_started_event(self):
    self.poll_control = self.started
    if self.dbconn:
      self.dbconn.disconnect()
      self.dbconn = None
    self.dbconn = self.ctrl_be.get_new_sql_connection(True)
    self.poll_control = self.polling
    dprint_ex(3, "SqlDataSource server started. poll_control =", self.poll_control)

  def server_stopped_event(self):
    self.poll_control = self.skip_poll
    if self.dbconn:
      self.dbconn.disconnect()
    self.dbconn = None
    self.poll_control = self.stopped
    dprint_ex(3, "SqlDataSource server stopped. poll_control =", self.poll_control)
  
  def shutdown_event(self):
    self.poll_control = self.skip_poll
    if self.dbconn:
      self.dbconn.disconnect()
    self.dbconn = None
    self.poll_control = self.stopped
    dprint_ex(3, "SqlDataSource shutdown. poll_control =", self.poll_control)

  def add_source(self, name, definition, widget):
    # Source is a dict which contains names of status variables, formula to calc
    # result, min and max values. Formula is a method(lambda) which gets params as
    # specified in the list of status_variables. For example:
    # add_source({'query' : ('Key_reads', 'Key_read_reqs'), 'calc' : lambda x: x[0] - Key_reads, x[1] - Key_read_reqs})
    status_variables = definition['query']
    # We need to store data we need, like names of status variables, calc function, and temporary data from status_variables
    # As data from show status is not parsed as a whole but row by row, we have to gather all status variables which are involved
    # in calc before calling calc.
    src = Source(name, self.mon_be.get_ctrl_be(), widget, status_variables, definition['calc'])
    self.sources[name] = src

    # Add reverse index of all status variables. Each status variable name may refer several
    # calc formulas, and each formula may have several variables. This rev index helps to find formulas 
    # where status variable is used. Each entry in this reverse index contain reference to source tuple (see
    # above, where source tuple is added to self.sources) and also the entry has index of variable in formula
    for i, status_variable_name in enumerate(src.variables):
      rev_src = None
      if status_variable_name in self.rev_sources:  
        rev_src = self.rev_sources[status_variable_name]
      else:
        rev_src = []
        self.rev_sources[status_variable_name] = rev_src
      rev_src.append((src, i))

    if 'min' in definition and 'max' in definition:
      widget[0].set_value_range(definition['min'], definition['max'])

  def poll(self):
    dprint_ex(5, "SqlDataSource poll. poll_control =", self.poll_control)
    if self.poll_control == self.polling and self.dbconn:
      result = None
      try:
        result = self.dbconn.executeQuery(self.sql) #ctrl_be from DataSource
      except QueryError, e:
        result = None
        if e.is_connection_error():
          self.dbconn.disconnect()
          if e.is_error_recoverable():
            self.dbconn = self.ctrl_be.get_new_sql_connection(False)

      if result is not None:
        while result.nextRow():
          name = result.stringByName("Variable_name")
          if name in self.rev_sources:
            rev_src = self.rev_sources[name]
            value = float(result.stringByName("Value"))
            # rev_src contains list of sources and index of current variable in the sources
            for (src, i) in rev_src:
              src.set_var(i, value)
              res = src.calculate()

#===============================================================================
class WBAWinRemoteStats(object):
  #-----------------------------------------------------------------------------
  def __init__(self, ctrl_be, server_profile, running, cpu_widget, mem_widget):
    self.ctrl_be = ctrl_be
    self.ssh = None
    self.cpu = 0
    self.mem = 0
    self.mtx = threading.Lock()
    self.running = running
    self.cpu_widget = cpu_widget
    self.mem_widget = mem_widget
    self.settings = server_profile
    self.remote_admin_enabled = self.settings.uses_ssh

    if not self.remote_admin_enabled:
      return

    self.ctrl_be.add_me_for_event("shutdown", self)

    #upload script. Get local name, open ftp session and upload to the directory
    # where mysql.ini is.
    self.script = None

    self.ssh   = ctrl_be.open_ssh_session_for_monitoring()

    (dirpath, code) = self.ssh.exec_cmd("cmd /C echo %USERPROFILE%") # %APPDATA% is n/a for LocalService
                                                                     # which is a user sshd can be run
    dirpath = dirpath.strip(" \r\t\n")

    if code == 0 and dirpath is not None and dirpath != "%USERPROFILE%":
      script_path = App.get().get_resource_path("mysql_system_status_rmt.vbs")
      filename = "\"" + dirpath + "\\mysql_system_status_rmt.vbs\""
      dprint_ex(1, "script local path is ", script_path, ". Will be uploaded to", filename)
      if script_path is not None and script_path != "":
        #print "Uploading file to ", filename
        try:
          f = open(script_path)
          self.ssh.exec_cmd("cmd /C echo. > " + filename)
          maxsize = 1800
          cmd = ""
          for line in f:
            line = line.strip("\r\n")
            tline = line.strip(" \t")
            if len(tline) > 0:
              if tline[0] != "'":
                if len(cmd) > maxsize:
                  self.ssh.exec_cmd("cmd /C " + cmd.strip(" &"))
                  self.ssh.exec_cmd("cmd /C echo " + line + " >> " + filename)
                  cmd = ""
                else:
                  cmd += "echo " + line + " >> " + filename
                  cmd += " && "

          if len(cmd) > 0:
            self.ssh.exec_cmd("cmd /C " + cmd.strip(" &"))
            cmd = ""

          self.script = "cscript //NoLogo " + filename + " /DoStdIn"
          #run ssh in a thread

          dprint_ex(2, "About to run", self.script)

          self.chan = None
          self.out = ""

          self.read_thread = threading.Thread(target=self.ssh.exec_cmd, args=(self.script, 0, None, self.reader, 1, self.save_channel))
          self.read_thread.setDaemon(True)
          self.read_thread.start()
        except IOError, e:
          self.ssh.close()
          self.ssh = None
          raise e
    else:
      print "Can't find a place to upload script dirpath='%s'"%dirpath


  #-----------------------------------------------------------------------------
  def shutdown_event(self):
    if self.ssh:
      self.running[0] = False
      try:
        if self.read_thread:
          self.read_thread.join()
      except:
        pass
      self.ssh.close()
      self.ssh = None

  #-----------------------------------------------------------------------------
  def save_channel(self, chan):
    self.chan = chan

  #-----------------------------------------------------------------------------
  def poll(self):
    value = self.get_mem()
    if value is not None:
      self.mem_widget[0].set_value(value)
      self.ctrl_be.uitask(self.mem_widget[0].set_description, "Mem: " + str(int(value)) + "%")

    value = self.get_cpu()
    if value is not None:
      self.cpu_widget[0].set_value(value / 100)
      self.ctrl_be.uitask(self.cpu_widget[0].set_description, "CPU: " + str(int(value)) + "%")

  #-----------------------------------------------------------------------------
  def parse_cpu(self, text):
    text = text.strip(" \r\t\n")
    value = 0.0
    try:
      value = float(text)
    except ValueError:
      value = 0.0

    try:
      self.mtx.acquire()
      self.cpu = value
    finally:
      self.mtx.release()

  #-----------------------------------------------------------------------------
  def parse_mem(self, text):
    text = text.strip(" \r\t\n")
    value = None
    try:
      value = float(text)
    except ValueError:
      value = None

    if value is not None:
      self.mtx.acquire()
      try:
        self.mem = value
      finally:
        self.mtx.release()
    dprint_ex(4, "Got mem stat value from remote script -", value)

  #-----------------------------------------------------------------------------
  def reader(self, ssh_session):
    what = None
    out = ""
    timeouts = 12
    while self.running[0]: # running is passed in list via "refernce"
      try:
        ch = ssh_session.recv(1)
        timeouts = 12
        if ch == "C":
          what = self.parse_cpu
        elif ch == "M":
          what = self.parse_mem
        elif ch == "\r" or ch == "\n":
          if what is not None:
            what(out)
          what = None
          out = ""
        elif ch in "0123456789. ":
          out += ch
        elif ch == ",":
          out += "."
        else:
          what = None
          out = ""
      except socket.timeout:
        timeouts -= 1
        if timeouts <= 0:
          ssh_session.close()
          raise Exception("Can't read from remote Windows script")

    dprint_ex(1, "Leaving monitor thread which polls remote windows")

  #-----------------------------------------------------------------------------
  def get_cpu(self):
    ret = ""
    self.mtx.acquire()
    ret = self.cpu
    self.mtx.release()

    return ret

  #-----------------------------------------------------------------------------
  def get_mem(self):
    ret = ""
    self.mtx.acquire()
    ret = self.mem
    self.mtx.release()

    return ret


#===============================================================================
# Should have been derived from DataSource, but that is meaningless
# This class starts thread which reads data from cscript in Windows
# Also the class mimics DataSource. 
class WBAWinLocalStats(object): 
  def __init__(self, ctrl_be, server_profile, running, cpu_widget, mem_widget):
    self.mtx = threading.Lock()
    self.cpu = 0
    self.mem = 0
    self.running = running
    self.cpu_widget = cpu_widget
    self.mem_widget = mem_widget
    self.ctrl_be = ctrl_be

    script_path = App.get().get_resource_path("mysql_system_status.vbs")
    self.read_thread = threading.Thread(target=self.read_from_script)
    self.read_thread.setDaemon(True)
    self.ctrl_be.add_me_for_event("shutdown", self)

    su = subprocess.STARTUPINFO()
    su.dwFlags |= _subprocess.STARTF_USESHOWWINDOW
    su.wShowWindow = _subprocess.SW_HIDE

    self.ch = subprocess.Popen("cscript //NoLogo " + script_path + " /DoStdIn", stdin = subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.STDOUT, startupinfo=su)

    self.read_thread.start()

  #-----------------------------------------------------------------------------
  def shutdown_event(self):
    if self.ch:
      try:
        self.ch.stdin.write("exit\r\n")
        self.ch.stdin.flush()
      except:
        pass

  #-----------------------------------------------------------------------------
  def poll(self):
    if self.running[0] is False:
      self.ch.stdin.write("exit\r\n")
      self.ch.stdin.flush()
      return

    self.ch.stdin.write("cpu\r\n")
    self.ch.stdin.flush()

    self.ch.stdin.write("mem\r\n")
    self.ch.stdin.flush()

    value = self.get_mem()
    try:
      value = float(value)
    except ValueError:
      dprint_ex(3, "Can not convert mem value", value, " to float")
      value = None

    if value is not None:
      self.mem_widget[0].set_value(value)
      self.ctrl_be.uitask(self.mem_widget[0].set_description, "Mem: " + str(int(value)) + "%")

    value = self.get_cpu()
    try:
      value = float(value)
    except ValueError:
      value = None
    if value is not None:
      self.cpu_widget[0].set_value(value/100)
      self.ctrl_be.uitask(self.cpu_widget[0].set_description ,"CPU: " + str(int(value)) + "%")

  #-----------------------------------------------------------------------------
  def read_from_script(self):
    line = ""
    while self.running[0]:
      c = self.ch.stdout.read(1)
      if c == ",":
        c = "."
      if c == "":
        break
      line += c
      if c == "\n":
        line = line.strip(" \r\t\n%")
        if len(line) == 0:
          print "Read empty string from script" # TODO: Probably need another way of informing. TBD
        else:
          if line[0] == 'C':
            self.mtx.acquire()
            self.cpu = line[2:]
            self.mtx.release()
          elif line[0] == 'M':
            self.mtx.acquire()
            self.mem = line[2:]
            self.mtx.release()
          line = ""
          dprint_ex(4, "WinLocalStats: line-", line, ", cpu-", self.cpu, ", mem", self.mem)

  #-----------------------------------------------------------------------------
  def get_cpu(self):
    ret = ""
    self.mtx.acquire()
    ret = self.cpu
    self.mtx.release()

    return ret

  #-----------------------------------------------------------------------------
  def get_mem(self):
    ret = ""
    self.mtx.acquire()
    ret = self.mem
    self.mtx.release()

    return ret


#===============================================================================
class WMIStats(object):
  def __init__(self, ctrl_be, server_profile, cpu_widget, mem_widget):
    if not hasattr(ctrl_be.server_control, 'wmi'):
      raise Exception("Current profile has no WMI enabled") # TODO Should be better message

    self.ctrl_be = ctrl_be
    self.server_profile = server_profile
    self.cpu_widget = cpu_widget
    self.mem_widget = mem_widget
    self.cpu_mon_id = None
    self.total_mem  = None

    self.wmi = ctrl_be.server_control.wmi

  def query(self, session, attr, query):
    value = None
    res = self.wmi.wmiQuery(session, query)
    if len(res) > 0:
      if hasattr(res[0], attr):
        value = getattr(res[0], attr)
        try:
          value = int(value)
        except:
          print "Wmi query: can't cast '%s' to int" % str(value)
          value = 1
      else:
        print "Wmi query: expected '%s' result attribute, got:" % attr
        print res
        value = 1
    return value

  def poll(self):
    wmi_session = self.ctrl_be.server_control.wmi_session_id_for_current_thread
    # Calc CPU
    value = self.query(wmi_session, 'PercentProcessorTime', "SELECT PercentProcessorTime FROM Win32_PerfFormattedData_PerfOS_Processor WHERE Name = '_Total'")
    if value is not None:
      self.cpu_widget[0].set_value(value/100.0)
      self.ctrl_be.uitask(self.cpu_widget[0].set_description ,"CPU: " + str(int(value)) + "%")
    # Calc Memory
    if self.total_mem is None:
      self.total_mem = float(self.query(wmi_session, 'TotalVisibleMemorySize', "Select TotalVisibleMemorySize FROM Win32_OperatingSystem"))

    value = self.query(wmi_session, 'AvailableKBytes', "Select AvailableKBytes FROM Win32_PerfFormattedData_PerfOS_Memory")
    if value is not None:
      mem_perc = round(100 - ((value/self.total_mem) * 100), 1)
      self.mem_widget[0].set_value(mem_perc)
      self.ctrl_be.uitask(self.mem_widget[0].set_description ,"Mem: " + str(int(mem_perc)) + "%")

#===============================================================================
class WBAdminMonitorBE(object):
  def __init__(self, interval, server_profile, ctrl_be, widgets, sql):
    self.ctrl_be   = ctrl_be
    self.sources     = [] # List of sources
    self.running     = [True]
    self.commands    = {}
    self.poll_thread = None
    self.interval  = interval

    self.ctrl_be.add_me_for_event("server_started", self)
    self.ctrl_be.add_me_for_event("server_stopped", self)

    if server_profile.target_os != wbaOS.windows:
      if server_profile.is_local or server_profile.remote_admin_enabled:
        # First read all script commands that were specified for the given instance.
        script = server_profile.sys_script
        lines = script.split("\n")
        for line in lines:
          line = line.strip(" \r\t\n")
          idx = line.find("=")
          if idx > 0:
            name = line[:idx].strip(" \t")
            cmds = line[idx+1:].strip(" \t")
            self.commands[name] = cmds

            widget = None
            if name in widgets:
              widget = widgets[name]

            cmd = ShellDataSource(name, cmds, self, widget)

            self.sources.append(cmd)
      else:
        print "WBAMonBE: Data sources were not added. Profile set to non-local or remote admin is disabled."
    else:
      if server_profile.is_local: # or server_profile.uses_wmi: # Force WMI for local boxes
        self.wmimon = WMIStats(ctrl_be, server_profile, widgets['get_cpu_info'], widgets['get_mem_info'])
        self.sources.append(self.wmimon)
        #Next, if we are reading from Windows targets replace sources to use a special script.
        # Create special source for windows. This stats will open a script that will output values of mem
        # and cpu usage upon request. The data obtained from the script is passed directly to widgets
        #stats = WBAWinLocalStats(ctrl_be, server_profile, self.running, widgets['get_cpu_info'], widgets['get_mem_info'])
        #self.sources.append(stats)
      else:
        if server_profile.remote_admin_enabled and server_profile.connect_method == 'ssh':
          stats = WBAWinRemoteStats(ctrl_be, server_profile, self.running, widgets['get_cpu_info'], widgets['get_mem_info'])
          self.sources.append(stats)

    sql_sources = SqlDataSource('show global status', self)
    for name, query in sql.iteritems():
      widget = None
      if name in widgets:
        widget = widgets[name]
      sql_sources.add_source(name, query, widget)

    self.sources.append(sql_sources)

    self.poll_thread = None

  def __del__(self):
    self.running[0] = False
    try:
      self.poll_thread.join()
    except:
      pass
    self.sources = []

  def run(self, name): 
    result = None

    if name in self.commands:
      result, rc = self.ctrl_be.execute_filtered_command(self.commands[name])
    else:
      pass # Try to fallback

    return result

  def get_ctrl_be(self):
    return self.ctrl_be

  def server_started_event(self):
    dprint_ex(4, "Enter")
    self.running[0] = True
    self.poll_thread = threading.Thread(target = self.poll_sources)
    self.poll_thread.start()
    dprint_ex(4, "Leave")

  def server_stopped_event(self):
    dprint_ex(4, "Enter")
    self.running[0] = False
    self.poll_thread = None
    dprint_ex(4, "Leave")

  def poll_sources(self):
    while self.running[0] and self.ctrl_be.running:
      #sleep here
      for cmd in self.sources:
        cmd.poll()
      time.sleep(self.interval)
    dprint_ex(1, "exiting monitor thread...")
