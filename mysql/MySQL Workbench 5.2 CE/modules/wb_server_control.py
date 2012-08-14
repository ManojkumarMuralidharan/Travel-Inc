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

import threading
from threading import currentThread
import sys
import os

import grt

import mforms

from wb_server_management import wbaOS
from wb_common import OperationCancelledError, InvalidPasswordError, dprint_ex

import re
import socket

#-------------------------------------------------------------------------------
def get_local_ip_list():
    cmd    = "/bin/sh -c ifconfig"
    regexp = "inet addr:([0-9a-f:\.]+)"

    if hasattr(sys, 'getwindowsversion'):
        cmd    = 'ipconfig'
        regexp = "IPv4.*: +([0-9a-f:\.]+)"
    elif 'darwin' in sys.platform:
        regexp = "inet ([0-9a-f\.:]+) netmask"

    out = None
    try:
      out = os.popen(cmd)
    except Exception, e:
      # We do not care if execution failed, the list will just be empty
      #print e
      out = None
    except:
      print "Unknown exception while running '%s'"%cmd

    try:
      ret = []
      if out:
          result = out.read()
          m = re.findall(regexp, result)

          for ip in m:
              try:
                  t_ip = socket.gethostbyname(ip)
                  ret.append(ip)
              except socket.gaierror,e:
                  print ip, str(e)
    except Exception, e:
      # We do not care if execution failed, the list will just be empty
      #print e
      ret = []
    except:
      print "Unknown exception while running '%s'"%cmd
      ret = []

    return ret

local_ip_list = get_local_ip_list()

#===============================================================================
class ServerProfile(object):
    def __init__(self, instance_profile, force_remote_admin_off=False):
        self.disable_remote_admin = force_remote_admin_off
        self.__settings = instance_profile
        self.expanded_config_file_path = None
    
    def get_settings_object(self):
        return self.__settings
    
    def _int_server_info(self, name, default_value=0):
        # always returns an int, a None value will be replaced with default_value
        try:
            value = self.__settings.serverInfo[name]
        except KeyError, exc:
            value = default_value
        if type(value) is not int:
            try:
                value= int(value)
            except:
                value= default_value
        if value is None:
            return default_value
        return value
    
    def _int_login_info(self, name, default_value=0):
        # always returns an int, a None value will be replaced with default_value
        try:
            value = self.__settings.loginInfo[name]
        except KeyError, exc:
            value = default_value
        if type(value) is not int:
            try:
                value= int(value)
            except:
                value= default_value
        if value is None:
            return default_value
        return value

    def _str_server_info(self, name, default_value=""):
        # always returns an str or unicode, a None value will be replaced with default_value
        try:
            value= self.__settings.serverInfo[name]
        except KeyError, exc:
            value = default_value
        if value is None:
            value= default_value
        elif type(value) is not str and type(value) is not unicode:
            value= str(value)
        return value

    def _str_login_info(self, name, default_value=""):
        # always returns an str or unicode, a None value will be replaced with default_value
        try:
            value= self.__settings.loginInfo[name]
        except KeyError, exc:
            value = default_value
        if value is None:
            value= default_value
        elif type(value) is not str and type(value) is not unicode:
            value= str(value)
        return value

    @property
    def name(self):
        return self.__settings.name

    @property
    def db_connection_params(self):
        return self.__settings.connection

    @property
    def host_os(self):
      if hasattr(sys, 'getwindowsversion'):
        return wbaOS.windows
      elif ('inux' in sys.platform):
        return wbaOS.linux
      elif ('arwin' in sys.platform):
        return wbaOS.darwin
      return wbaOS.unknown

    # Must return smth from wbaOS
    @property
    def target_os(self):
      # This call must return either value from profile for remote server
      # If remote server is not set, which means local server, then returned value
      # must be equal to self.host_os
      ret = wbaOS.unknown
      
      try:
        system = self.__settings.serverInfo['sys.system']
      except:
        system = None
      if system is not None and type(system) is str or type(system) is unicode:
        system = system.strip(" \r\t\n").lower()
        if system == 'windows':
          ret = wbaOS.windows
        elif system in ('linux', 'freebsd', 'opensolaris'):
          ret = wbaOS.linux
        elif ('macos' in system):
          ret = wbaOS.darwin
      else:
        ret = self.host_os
      
      return ret

    @property
    def host_is_windows(self):
        return self.host_os == wbaOS.windows
    
    @property
    def target_is_windows(self):
        return self.target_os == wbaOS.windows


    @property
    def remote_admin_enabled(self):
        return (self.uses_ssh or (not self.is_local and self.uses_wmi)) and not self.disable_remote_admin
    
    @property
    def admin_enabled(self):
        return self.is_local or self.remote_admin_enabled
        
    @property
    def is_local(self):
        local_addrs = ["localhost", "", "0", "127.0.0.1"] + local_ip_list
        if self.uses_wmi:
            return self.wmi_hostname in local_addrs
        elif self.uses_ssh:
            return self.ssh_hostname in local_addrs
        else:
            if self.db_connection_params:
                params = self.db_connection_params.parameterValues
                if params:
                    if self.db_connection_params.driver:
                        if self.db_connection_params.driver.name == "MysqlNative":
                            return params["hostName"] in local_addrs
                        elif self.db_connection_params.driver.name == "MysqlNativeSocket":
                            return True
                        elif self.db_connection_params.driver.name == "MysqlNativeSSH":
                            return False
                    else:
                        from wb_common import NoDriverInConnection
                        raise NoDriverInConnection, """Workbench has not found a driver for the connection
that is being used by this server instance.
Please edit your connection settings and try again."""
            return False


    @property
    def connect_method(self):
      # choices are ['local', 'ssh', 'wmi', 'none'] 
      # 'none' is for remote server ip with "No Remote Management" selected
      ret = None
      if self.uses_wmi:
        ret = 'wmi'
      elif self.uses_ssh:
        ret = 'ssh'
      else:
        if self.is_local:
          ret = 'local'
        else:
          ret = 'none'
      return ret


    @property
    def uses_ssh(self):
        return self._int_server_info("remoteAdmin")

    # If WMI admin was selected as mgmt mean (can be for local or remote)
    @property
    def uses_wmi(self):
        return self._int_server_info("windowsAdmin")

    @property
    def ssh_username(self):
        return self._str_login_info("ssh.userName")

    @property
    def ssh_hostname(self):
        return self._str_login_info("ssh.hostName")

    @property
    def ssh_port(self):
        return self._int_login_info("ssh.port", 22)

    @property
    def ssh_usekey(self):
        return self._int_login_info("ssh.useKey")

    @property
    def ssh_key(self):
        return self._str_login_info("ssh.key")
    
    @property
    def wmi_hostname(self):
        return self._str_login_info("wmi.hostName")
    
    @property
    def wmi_username(self):
        return self._str_login_info("wmi.userName")

    @property
    def wmi_service_name(self):
        return self._str_server_info("sys.mysqld.service_name")
        
    @property
    def start_server_cmd(self):
        return self._str_server_info("sys.mysqld.start")
    
    @property
    def stop_server_cmd(self):
        return self._str_server_info("sys.mysqld.stop")
        
    @property
    def check_server_status_cmd(self):
        return self._str_server_info("sys.mysqld.status")
        
    @property
    def use_sudo(self):
        return self._int_server_info("sys.usesudo")

    @property
    def sudo_prefix(self):
        return self._str_server_info("sys.sudo", "sudo") or "sudo"

    @property
    def use_sudo_for_status(self):
        return self._int_server_info("sys.usesudostatus")
        
    
    @property
    def config_file_path(self):
        """ path to configuration file (eg my.cnf)
        may contain path variables that need to be expanded, such as %ProgramPath%
        """
        if self.expanded_config_file_path:
            return self.expanded_config_file_path
        return self._str_server_info('sys.config.path', '').strip(" \r\t\n\b")


    @property
    def config_file_section(self):
        return self._str_server_info('sys.config.section', '').strip(" \r\t\n\b")

    @property
    def sys_script(self):
        return self._str_server_info('sys.script', '')

    #-------------------------------------------------------
    def server_version(self):
        return self._str_server_info("serverVersion", None)

    def set_server_version(self, version):
        self.__settings.serverInfo["serverVersion"] = version
        
    server_version = property(server_version, set_server_version)
        
    #-------------------------------------------------------     
    def log_output(self):
        return self._str_server_info("logOutput")

    def set_log_output(self, output):
        self.__settings.serverInfo['logOutput'] = output
        
    log_output = property(log_output, set_log_output)
        
    #-------------------------------------------------------     
    def general_log_enabled(self):
        return self._int_server_info("generalLogEnabled")

    def set_general_log_enabled(self, value):
        self.__settings.serverInfo['generalLogEnabled'] = value
        
    general_log_enabled = property(general_log_enabled, set_general_log_enabled)
        
    #-------------------------------------------------------     
    def slow_log_enabled(self):
        return self._int_server_info("slowLogEnabled")

    def set_slow_log_enabled(self, value):
        self.__settings.serverInfo['slowLogEnabled'] = value
        
    slow_log_enabled = property(slow_log_enabled, set_slow_log_enabled)

    #-------------------------------------------------------
    def general_log_file_path(self):
        return self._str_server_info("generalLogFilePath")
    
    def set_general_log_file_path(self, path):
        self.__settings.serverInfo['generalLogFilePath'] = path
        
    general_log_file_path = property(general_log_file_path, set_general_log_file_path)
        
    #-------------------------------------------------------
    def slow_log_file_path(self):
        return self._str_server_info("slowLogFilePath")
    
    def set_slow_log_file_path(self, path):
        self.__settings.serverInfo['slowLogFilePath'] = path
        
    slow_log_file_path = property(slow_log_file_path, set_slow_log_file_path)
    
    #-------------------------------------------------------
    def error_log_file_path(self):
        return self._str_server_info("errorLogFilePath")
    
    def set_error_log_file_path(self, path):
        self.__settings.serverInfo['errorLogFilePath'] = path
    
    error_log_file_path = property(error_log_file_path, set_error_log_file_path)


class PasswordHandler(object):
    def __init__(self, server_profile):
        self.server_profile = server_profile
        self.pwd_store = {}
    
    def get_password_parameters(self, service_type):
        # known service types: remoteshell, ssh, sshkey, file, service.startstop, service.status
        # these are mapped to
        # known password types: ssh, sshkey, sudo, UAC, wmi
        # which are then mapped to (title, service, account) or "UAC" or None

        profile = self.server_profile

        password_type = None
        if service_type == "file":
            if profile.target_is_windows:
                # in windows, auth is handled by UAC which is done externally
                password_type = "UAC"
            else:
                password_type = "sudo"
        elif service_type == "service.startstop":
            if profile.target_is_windows:
                password_type = "wmi"
            else:
                if profile.use_sudo:
                    password_type = "sudo"
                else:
                    password_type = None
        elif service_type == "service.status":
            if profile.target_is_windows:
                password_type = None
            else:
                if profile.use_sudo_for_status:
                    password_type = "sudo"
                else:
                    password_type = None
        elif service_type == "remoteshell":
            if profile.uses_ssh:
                if profile.ssh_usekey:
                    password_type = "sshkey"
                else:
                    password_type = "ssh"
        elif service_type == "ssh":
            password_type = "ssh"
        elif service_type == "sshkey":
            password_type = "sshkey"
        else:
            raise Exception("Unknown password type: %s" % service_type)


        # sudo pwd may be either user's password, or root password. It depends on sudo setup
        if password_type == "sudo":
            sudo_type = "sudo"
            # if su is to be used instead of sudo, then we need the root password instead of login user
            if profile.sudo_prefix and "sudo" not in profile.sudo_prefix:
                sudo_type = "root"

            if profile.uses_ssh:
                if sudo_type == "sudo":
                    account = profile.ssh_username
                else:
                    account = "root"
                title = "%s Password Required"%sudo_type
                service = "%s@%s"%(sudo_type, profile.ssh_hostname)
            else:
                if sudo_type == "sudo":
                    import pwd
                    # os.getlogin() raises errno 25 if WB is started from ubuntu menu, so never use it
                    #account = os.getlogin()
                    try:
                        account = pwd.getpwuid(os.getuid())[0]
                        if not account:
                            account = "sudo"
                    except:
                        account = "sudo"
                else:
                    account = "root"
                title = "%s Password Required"% sudo_type
                service = "%s@localhost" % sudo_type

            return (title, service, account)

        elif password_type == "wmi":
            return ("WMI Password Required", "wmi@%s" % profile.wmi_hostname, profile.wmi_username)

        elif password_type == "UAC":
            return "UAC"
        
        elif password_type == "ssh":
            return ("SSH Login Password Required", "ssh@%s" % profile.ssh_hostname, profile.ssh_username)
        
        elif password_type == "sshkey":
            return ("SSH Private Key Password Required", "ssh_keyfile@%s" % profile.ssh_key, profile.ssh_username)
        
        else:
            return None
        
    # call this if a InvalidPasswordError is caught
    def reset_password_for(self, service_type):
        if self.pwd_store.has_key(service_type):
            # None means the stored password was bad
            self.pwd_store[service_type] = None

    def get_password_for(self, service_type): # Raises OperationCancelledError if user cancels pwd dlg. 
        force_reset = False
        if self.pwd_store.has_key(service_type):
            if self.pwd_store[service_type] is None:
                force_reset = True
            else:
                return self.pwd_store[service_type]

        details = self.get_password_parameters(service_type)
        if not details: # No password needed for this service_type
            return None
        
        # special case for UAC used in windows
        if details == "UAC":
            return "UAC"

        title, service, account = details

        dprint_ex(2, "request password for %s => %s, %s, %s" % (service_type, title, service, account))

        accepted, password = mforms.Utilities.find_or_ask_for_password(title, service, account, force_reset)
        if accepted:
            if not password:
                password = ""
            self.pwd_store[service_type] = password
            return password
        else:
            raise OperationCancelledError("Password input cancelled")


class ServerControlBase(object):
    def __init__(self, serverProfile, helper, password_delegate):
        self.profile = serverProfile
        self.helper = helper
        self.password_delegate = password_delegate
        self.output_buffer = []
        # default handler will just add the output to a list to be flushed later
        self.output_handler = lambda line, output_buffer= self.output_buffer: output_buffer.append(line)

    def set_output_handler(self, handler): # must be called by consumer of output (ie, the start/stop Tab in WB)
        self.output_handler = handler
        if self.output_buffer:
            for line in self.output_buffer:
                self.output_handler(line)
        self.output_buffer = None

    def info(self, text):
        self.output_handler(text)

    def close(self):
        # do cleanup, free up resources etc
        pass

    def start(self, password): # overriden by concrete subclasses
        "Starts the server using the method specified in the instance profile"
        assert 0

    def start_async(self, finish_callback): # callback(status) where status can be success, bad_password or an error message
        try:
            # ask subclass to provide password
            password = self.get_password()
        except OperationCancelledError, exc:
            return False
        thread = threading.Thread(target=self.worker_thread, args=(self.start, password, finish_callback))
        thread.run()
        return True
    
    def worker_thread(self, action, password, finish_callback):
        try:
            action(password)
            finish_callback("success")
        except InvalidPasswordError, err:
            finish_callback("bad_password")
        except Exception, err:
            import traceback
            traceback.print_exc()
            finish_callback(err)


    def stop(self, password): # overriden by concrete subclasses, must be non-interactive
        assert 0
    
    def stop_async(self, finish_callback):
        try:
            password = self.get_password()
        except OperationCancelledError, exc:
            return False
        thread = threading.Thread(target=self.worker_thread, args=(self.stop, password, finish_callback))
        thread.run()
        return True

    def get_status(self, verbose=0): # overriden by concrete subclasses
        return 0


class ServerControlShell(ServerControlBase):
    def __init__(self, profile, helper, password_delegate):
        """ Can also throw OperationCancelledError"""
        ServerControlBase.__init__(self, profile, helper, password_delegate)

        # Ask for password here, as this class is instantiated from the main thread
        # The other methods may be instantiated from other threads, which will not work 
        # with the password dialogs
        
        # Ensure sudo password for status checks is cached. For other sudo uses,
        # the password should be requested when the action is started from the UI (ie, in the code called 
        # by the Start/Stop button in Server startup tab)
        if self.profile.use_sudo_for_status:
            password_delegate.get_password_for("service.status")

        self.prepare_filter = None
        self.apply_filter = None


    def set_filter_functions(self, prepare_f, apply_f):
        self.prepare_filter = prepare_f
        self.apply_filter = apply_f


    def get_password(self):
        return self.password_delegate.get_password_for("service.startstop")


    def start(self, password):
        """ Can also throw InvalidPasswordError"""
        self.info("Starting server...") # TODO: This does not come to info output
        try:
            r = self.helper.execute_command(self.profile.start_server_cmd, 
                                    as_admin=self.profile.use_sudo, 
                                    admin_password=password,
                                    output_handler=lambda s:self.info("Start server: %s"%(s if ((type(s) is str) or (type(s) is unicode)) else "").replace(password, "")))
        except InvalidPasswordError, exc:
            # forget password, so that next time it will be requested
            self.password_delegate.reset_password_for("service.startstop")
            raise exc
            
        if r:
            return True
        return False


    def stop(self, password):
        """ Can also throw InvalidPasswordError"""
        self.info("Stopping server...")
        try:
            def strip_pwd(output):
                if output is not None and (type(output) is str or type(output) is unicode):
                    if password is not None and password != "":
                        output = output.replace(password, "")
                else:
                    output = ""
                self.info("Stop server: %s"%str(output))

            r = self.helper.execute_command(self.profile.stop_server_cmd, 
                                    as_admin=self.profile.use_sudo, 
                                    admin_password=password,
                                    output_handler=strip_pwd)
        except InvalidPasswordError, exc:
            # forget password, so that next time it will be requested
            self.password_delegate.reset_password_for("service.startstop")
            raise exc

        if r:
            return True
        return False


    def get_status(self, verbose=1, password=None):
        """ Can also throw InvalidPasswordError"""
        if verbose > 1:
            output = lambda s:self.info("Check server: %s"%s)
        else:
            output = None

        password = None
        #unused user_gave_new_password = False

        script = self.profile.check_server_status_cmd

        if verbose > 1:
            self.info("Checking server status...")
            if self.profile.use_sudo_for_status:
                self.info("Executing: %s (using sudo)" % script)
                if not password:
                    self.info("Note: no sudo password supplied")
            else:
                self.info("Executing: %s" % script)

        if self.prepare_filter:
            raw_script, filters = self.prepare_filter(script)
        else:
            raw_script = script

        lines = []
        def collect_output(line, l=lines, dump=output):
            l.append(line)
            if dump:
                dump(line)
        try:
            result = self.helper.execute_command(raw_script, 
                                    as_admin=self.profile.use_sudo_for_status, 
                                    admin_password=password, 
                                    output_handler=collect_output)
        except InvalidPasswordError, exc:
            self.info("Invalid password")
            raise exc

        if self.apply_filter and filters:
            filters_text, filters_code = self.apply_filter("\n".join(lines), filters)

            if filters_code is not None:
                if result is not None:
                    result = int(result) or filters_code
                else:
                    result = filters_code
        else:
            #output_text = "\n".join(lines)
            pass
        
    
        if verbose > 1:
            self.info("Server check returned %s" % result)

        status = "unknown"
        if result == 0:
            if verbose:
                self.info("Checked server status: Server is running.")    
            status = "running"
        elif result == 1:
            if verbose:
                self.info("Checked server status: Server is stopped.")
            status = "stopped"
    
        return status


class ServerControlWMI(ServerControlBase):
    def __init__(self, profile, helper, password_delegate):
        ServerControlBase.__init__(self, profile, helper, password_delegate)
        self.wmi = grt.modules.Workbench
        self.wmi_session_ids = {}
        self.shell = None
        if self.profile.is_local:
            user = ""
            server = ""
            password = ""
            self.check_and_fix_profile_for_local_windows(profile)
            self.shell = ServerControlShell(profile, helper, password_delegate)
            # Forse usage of as_admin for local windows
            self.info("Workbench will use cmd shell commands to start/stop this instance")
        else:
            user = self.profile.wmi_username
            server = self.profile.wmi_hostname
            password = self.get_password()
        try:
            sess = self.wmi.wmiOpenSession(server, user, password or "")
            self.wmi_session_ids[currentThread()] = sess
        except Exception, exc:
            import traceback
            traceback.print_exc()
            raise RuntimeError("Could not initialize WMI interface: %s"%exc)
        if self.wmi_session_id_for_current_thread <= 0:
            raise RuntimeError("Could not initialize WMI interface")


    def check_and_fix_profile_for_local_windows(self, profile):
        settings = profile.get_settings_object()
        serverInfo = settings.serverInfo

        serverInfo["sys.usesudo"] = 1 # Force this in any case
        # Check commands
        service = profile.wmi_service_name
        #  return self._str_server_info("sys.mysqld.service_name")
        if service == "":
            service = serverInfo["sys.mysqld.service_name"] = "MySQL"
            self.info("MySQL service was empty. Set to 'MySQL'. Check this in 'Manage Server Instances' from 'Home'.")

        if profile.start_server_cmd == "" or (service not in profile.start_server_cmd):
            serverInfo["sys.mysqld.start"] = "sc start " + service
            print "WMIShell: start command set to '%s'"%profile.start_server_cmd

        if profile.stop_server_cmd == "" or (service not in profile.stop_server_cmd):
            serverInfo["sys.mysqld.stop"] = "sc stop " + service
            print "WMIShell: stop command set to '%s'"%profile.stop_server_cmd

        if profile.check_server_status_cmd == "" or (service not in profile.check_server_status_cmd):
            serverInfo["sys.mysqld.status"] = "sc query %s | wba_filter(RUNNING)"%service
            print "WMIShell: status command set to '%s'"%profile.check_server_status_cmd

    def set_filter_functions(self, prepare_f, apply_f):
        if self.profile.is_local and self.shell:
          print "WMIShell: Set filters for local windows cli"
          self.shell.prepare_filter = prepare_f
          self.shell.apply_filter = apply_f

    def get_password(self):
        if self.profile.is_local:
            return ""
        return self.password_delegate.get_password_for("service.startstop")

    # WMI sessions are thread specific. To make things easier, we create one for
    # each thread that uses it
    @property
    def wmi_session_id_for_current_thread(self):
        thr = currentThread()
        s = self.wmi_session_ids.get(thr)
        if s is not None:
            return s
        password = self.get_password()

        if self.profile.is_local:
            sess = self.wmi.wmiOpenSession('', '', '')
        else:
            sess = self.wmi.wmiOpenSession(self.profile.wmi_hostname, self.profile.wmi_username, password or "")

        if sess:
            self.wmi_session_ids[thr] = sess

        return sess

    def close(self):
        for s in self.wmi_session_ids.values():
            self.wmi.wmiCloseSession(s)
        self.wmi_session_ids = {}
        ServerControlBase.close() # not certain if the call is needed.

    def start(self, password):
        self.info("Starting server...");
        if self.shell:
            return self.shell.start(password)
        else:
            # Profile may hold the actual command passed
            service = self.profile.wmi_service_name
            action = "start"
            self.info("Starting service '%s' through WMI..." % service)
            result = self.wmi.wmiServiceControl(self.wmi_session_id_for_current_thread, service, action)
            self.info("Service start result: %s" % result)
            if result.startswith("error"):
                raise RuntimeError("Error stopping service %s through WMI\n%s" % (service, result))
            return not result.startswith("error")


    def stop(self, password):
        if self.shell:
            return self.shell.stop(password)
        else:
            service = self.profile.wmi_service_name
            action = "stop"
            self.info("Stopping service '%s' through WMI..." % service)
            result = self.wmi.wmiServiceControl(self.wmi_session_id_for_current_thread, service, action)
            self.info("Service stop result: %s" % result)
            if result.startswith("error"):
                raise RuntimeError("Error stopping service %s through WMI\n%s" % (service, result))
            return not result.startswith("error")

    def get_status(self, verbose=1, password=None):
        "Returned value is one of running, stopping, starting, stopped, unknown"
        service = self.profile.wmi_service_name
        action = "status"
        if verbose > 1:
            self.info("Checking service status of instance %s..." % service)
        result = self.wmi.wmiServiceControl(self.wmi_session_id_for_current_thread, service, action)
        if verbose:
            self.info("Status check of service '%s' returned %s" % (service, result))
        # translate status to something more displayable
        if result == "stop pending":
            result = "stopping"
        elif result == "start pending":
            result = "starting"

        return result







