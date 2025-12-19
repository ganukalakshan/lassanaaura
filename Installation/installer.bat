@echo off
:: Laravel Application Installer Launcher
:: This batch file launches the Python installer

echo ====================================
echo  Laravel Application Installer
echo ====================================
echo.

:: Check if Python is installed
python --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Python is not installed or not in PATH
    echo.
    echo Please install Python from: https://www.python.org/downloads/
    echo Make sure to check "Add Python to PATH" during installation
    pause
    exit /b 1
)

:: Check if tkinter is available
python -c "import tkinter" >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Tkinter is not available
    echo.
    echo Tkinter comes with Python by default.
    echo Please reinstall Python with Tk/Tcl support.
    pause
    exit /b 1
)

echo Starting installer...
echo.

:: Run the installer
python "%~dp0installer.py"

if %errorlevel% neq 0 (
    echo.
    echo ERROR: Installer failed to run
    pause
)
