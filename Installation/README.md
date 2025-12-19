# Laravel Application Installer

This is a desktop-style installer for the Laravel + NPM project with a graphical user interface.

## Features

- ✅ GUI window with loading/progress bar
- ✅ Automatic .env file creation with user input for database credentials
- ✅ Runs all necessary commands automatically:
  - `composer install`
  - `npm install`
  - `php artisan key:generate`
  - `php artisan migrate`
  - `php artisan db:seed`
- ✅ Real-time progress updates in the GUI
- ✅ Smart detection: skips installation if already installed
- ✅ Launch system functionality (starts Laravel server + Vite dev server)
- ✅ Installation logs visible in the GUI
- ✅ Windows compatible

## Requirements

- **Python 3.x** (with Tkinter - comes by default with Python)
- **Composer** (installed and in PATH)
- **Node.js & NPM** (installed and in PATH)
- **PHP** (installed and in PATH)
- **MySQL/MariaDB** (running on your system)

## How to Use

### First Time Installation

1. **Double-click** `installer.bat` to launch the installer
   - Alternatively, run: `python installer.py`

2. The installer window will open and check installation status

3. If not installed, you'll see database configuration fields:
   - Enter your **Database Name** (default: lassnaaura_db)
   - Enter your **Database Username** (default: root)
   - Enter your **Database Password**

4. Click **"Start Installation"** button

5. The installer will automatically:
   - Create `.env` file with your database credentials
   - Install Composer dependencies
   - Generate application key
   - Install NPM packages
   - Run database migrations
   - Seed the database

6. Watch the progress bar and installation logs

7. When complete, you'll see: **"Setup Complete – You can now run the system"**

8. Click **"Launch System"** to start the application

### Subsequent Runs

When you run the installer again:

- It detects that the system is already installed
- Shows "✓ System is already installed and ready to use!"
- **"Launch System"** button is enabled
- Click it to start Laravel server + Vite dev server
- You can also click **"Reinstall"** to run the full installation again

## What "Launch System" Does

When you click "Launch System":

1. Opens a new terminal window running: `php artisan serve`
   - Laravel application runs at: http://localhost:8000

2. Opens another terminal window running: `npm run dev`
   - Vite development server for assets

3. Both servers run in separate windows
   - Close the terminal windows to stop the servers

## Manual Installation (Without GUI)

If you prefer to install manually:

```bash
cd c:\laragon\www\lassnaaura

# Create .env file
copy .env.example .env

# Edit .env and set your database credentials

# Install dependencies
composer install
npm install

# Generate key and setup database
php artisan key:generate
php artisan migrate
php artisan db:seed

# Run the application
php artisan serve
# In another terminal:
npm run dev
```

## Troubleshooting

### "Python is not installed or not in PATH"
- Install Python from: https://www.python.org/downloads/
- Make sure to check "Add Python to PATH" during installation

### "Composer install failed"
- Make sure Composer is installed: https://getcomposer.org/
- Check that `composer` command works in terminal

### "NPM install failed"
- Install Node.js from: https://nodejs.org/
- Check that `npm` command works in terminal

### "Database migration failed"
- Make sure MySQL/MariaDB is running
- Verify database credentials are correct
- Ensure the database exists or the user has permission to create it

### Installer won't start
- Run from terminal to see errors: `python installer.py`
- Check all requirements are installed

## Project Structure

```
Installation/
├── installer.py       # Main Python installer script with GUI
├── installer.bat      # Windows launcher (double-click this)
└── README.md          # This file
```

## Technical Details

- **Language**: Python 3.x
- **GUI Framework**: Tkinter (built-in with Python)
- **Target Project**: Laravel + NPM (lassnaaura)
- **Platform**: Windows (can be adapted for Mac/Linux)

## License

This installer is part of the Laravel project and follows the same license.
