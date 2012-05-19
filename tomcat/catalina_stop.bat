@echo off
::::::::::::::::::::::::::::::::::::
::  Set JAVA_HOME and   ::
::::::::::::::::::::::::::::::::::::


echo.
echo [XAMPP]: Searching JDK HOME with reg query ...
set KeyName=HKEY_LOCAL_MACHINE\SOFTWARE\JavaSoft\Java Development Kit

reg query "%KeyName%" /s
if %ERRORLEVEL% == 1 (
  echo . [XAMPP]: Cannot find current JDK installation! 
  echo . [XAMPP]: Cannot set JAVA_HOME. Aborting ...
  goto :END
)

set "CURRENT_DIR=%cd%"
set "CATALINA_HOME=%CURRENT_DIR%"

set Cmd=reg query "%KeyName%" /s
for /f "tokens=2*" %%i in ('%Cmd% ^| find "JavaHome"') do set JAVA_HOME=%%j

echo.
echo [XAMPP]: Seems fine!
echo [XAMPP]: Using %JAVA_HOME%
echo.
echo %CATALINA_HOME%

%CATALINA_HOME%\bin\catalina.bat stop


:END
echo done.
pause
