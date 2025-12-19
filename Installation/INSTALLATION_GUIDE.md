# Installation Guide

## Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL database
- Laragon (or similar local development environment)

## Installation Methods

### Option 1: Python Installer (Recommended)

1. **Navigate to the Installation folder:**
   ```bash
   cd "c:\laragon\www\New folder\Installation"
   ```

2. **Run the installer:**
   ```bash
   python installer.py
   ```

3. **Follow the GUI steps:**
   - Enter your MySQL database credentials
   - Click "⚡ Install Now"
   - Wait for the installation to complete
   - Click "🚀 Launch System"

### Option 2: Web-Based Installer

1. **Start your web server** (Laravel development server):
   ```bash
   cd "c:\laragon\www\New folder\lassnaaura"
   php artisan serve
   ```

2. **Open your browser:**
   ```
   http://localhost:8000
   ```

3. **You'll be automatically redirected to:** `http://localhost:8000/install`

4. **Configure your database:**
   - Database Host: `127.0.0.1`
   - Database Port: `3306`
   - Database Name: `lassnaaura`
   - Username: `root`
   - Password: (leave empty if no password)

5. **Click "⚡ Install Now"** and wait for completion

### Option 3: Manual Installation

1. **Navigate to project directory:**
   ```bash
   cd "c:\laragon\www\New folder\lassnaaura"
   ```

2. **Install Composer dependencies:**
   ```bash
   composer install
   ```

3. **Copy .env file** (already configured for MySQL)

4. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

5. **Create MySQL database:**
   ```sql
   CREATE DATABASE lassnaaura;
   ```

6. **Run migrations:**
   ```bash
   php artisan migrate
   ```

7. **Seed database:**
   ```bash
   php artisan db:seed
   ```

8. **Install NPM packages:**
   ```bash
   npm install
   ```

9. **Build assets:**
   ```bash
   npm run dev
   ```

10. **Start the application:**
    ```bash
    php artisan serve
    ```

## Installation Flow

The installer will execute the following steps automatically:

1. ✅ **Step 1/6:** Check/Create .env file
2. ✅ **Step 2/6:** Install Composer dependencies
3. ✅ **Step 3/6:** Generate application key
4. ✅ **Step 4/6:** Install NPM packages
5. ✅ **Step 5/6:** Run database migrations
6. ✅ **Step 6/6:** Seed database with initial data

## Post-Installation

After successful installation:

1. **Access the application:**
   - URL: `http://localhost:8000`
   - Default login credentials will be shown in the seeder output

2. **Development servers:**
   - Laravel: `php artisan serve` (http://localhost:8000)
   - Vite: `npm run dev` (for hot-reloading)

## Troubleshooting

### Database Connection Failed
- Ensure MySQL is running in Laragon
- Verify database credentials in `.env`
- Make sure the database exists: `CREATE DATABASE lassnaaura;`

### Composer/NPM Errors
- Clear cache: `composer clear-cache`
- Delete vendor folder and run `composer install` again
- Delete node_modules and run `npm install` again

### Permission Errors
- Ensure storage and cache folders are writable:
  ```bash
  chmod -R 775 storage bootstrap/cache
  ```

### Already Installed Error
- Delete `storage/installed` file to reinstall
- Or use the "🔄 Reinstall" option in Python installer

## Features Included

✨ Modern installer UI with progress tracking
🗄️ MySQL database configuration
📦 Automatic dependency installation
🔑 Auto-generated application key
🌱 Database seeding with sample data
🚀 One-click launch system

## Support

For issues or questions, check the Laravel documentation at https://laravel.com/docs
