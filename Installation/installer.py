import tkinter as tk
from tkinter import ttk, messagebox, StringVar
import subprocess
import os
import threading
import sys
from pathlib import Path

class LaravelInstaller:
    def __init__(self, root):
        self.root = root
        self.root.title("Laravel Application Installer")
        self.root.geometry("600x500")
        self.root.resizable(False, False)
        
        # Get the project path (parent of Installation folder)
        self.installation_dir = Path(__file__).parent.absolute()
        self.project_path = self.installation_dir.parent / "lassnaaura"
        
        # Setup UI
        self.setup_ui()
        
        # Check if already installed
        self.check_installation_status()
    
    def setup_ui(self):
        # Configure root background
        self.root.configure(bg="#f8fafc")
        
        # Header with gradient effect simulation
        header_frame = tk.Frame(self.root, bg="#3b82f6", height=140)
        header_frame.pack(fill=tk.X)
        header_frame.pack_propagate(False)
        
        # Logo/Icon placeholder (using emoji/symbol)
        logo_frame = tk.Frame(header_frame, bg="white", width=80, height=80)
        logo_frame.place(relx=0.5, rely=0.3, anchor=tk.CENTER)
        logo_label = tk.Label(
            logo_frame,
            text="⚡",
            font=("Segoe UI Emoji", 40),
            bg="white",
            fg="#3b82f6"
        )
        logo_label.pack(expand=True)
        
        # Title
        title_label = tk.Label(
            header_frame,
            text="Application Installer",
            font=("Segoe UI", 20, "bold"),
            bg="#3b82f6",
            fg="white"
        )
        title_label.place(relx=0.5, rely=0.68, anchor=tk.CENTER)
        
        # Subtitle
        subtitle_label = tk.Label(
            header_frame,
            text="Configure your database to get started",
            font=("Segoe UI", 9),
            bg="#3b82f6",
            fg="#dbeafe"
        )
        subtitle_label.place(relx=0.5, rely=0.85, anchor=tk.CENTER)
        
        # Main container with padding
        container = tk.Frame(self.root, bg="#f8fafc")
        container.pack(fill=tk.BOTH, expand=True, padx=20, pady=20)
        
        # Card-like main frame
        main_frame = tk.Frame(container, bg="white", relief=tk.FLAT, bd=0)
        main_frame.pack(fill=tk.BOTH, expand=True)
        
        # Add shadow effect (simulated with border)
        shadow_frame = tk.Frame(container, bg="#e2e8f0", relief=tk.FLAT)
        shadow_frame.place(in_=main_frame, x=3, y=3, relwidth=1, relheight=1)
        main_frame.lift()
        
        # Inner padding frame
        content_frame = tk.Frame(main_frame, bg="white", padx=35, pady=25)
        content_frame.pack(fill=tk.BOTH, expand=True)
        
        # Status label with icon
        status_container = tk.Frame(content_frame, bg="white")
        status_container.pack(pady=(0, 15))
        
        self.status_icon = tk.Label(
            status_container,
            text="⏳",
            font=("Segoe UI Emoji", 14),
            bg="white"
        )
        self.status_icon.pack(side=tk.LEFT, padx=(0, 8))
        
        self.status_label = tk.Label(
            status_container,
            text="Checking installation status...",
            font=("Segoe UI", 10),
            bg="white",
            fg="#64748b",
            wraplength=450,
            justify=tk.LEFT
        )
        self.status_label.pack(side=tk.LEFT)
        
        # Database configuration frame (hidden by default)
        self.db_frame = tk.LabelFrame(
            content_frame,
            text=" 🗄️ MySQL Database Configuration ",
            font=("Segoe UI", 10, "bold"),
            bg="white",
            fg="#1e293b",
            padx=25,
            pady=20,
            relief=tk.FLAT,
            borderwidth=2
        )
        
        # Database Host
        self.create_input_field(self.db_frame, 0, "🖥️ Database Host:", "127.0.0.1", "db_host")
        
        # Database Port
        self.create_input_field(self.db_frame, 1, "🔌 Database Port:", "3306", "db_port")
        
        # Database Name
        self.create_input_field(self.db_frame, 2, "💾 Database Name:", "auraERP", "db_name_field")
        self.db_name = self.db_name_field
        
        # Database Username
        self.create_input_field(self.db_frame, 3, "👤 Database Username:", "root", "db_user")
        
        # Database Password
        tk.Label(
            self.db_frame,
            text="🔒 Database Password:",
            font=("Segoe UI", 9, "bold"),
            bg="white",
            fg="#475569",
            anchor=tk.W
        ).grid(row=4, column=0, sticky=tk.W, pady=(8, 2), padx=(0, 10))
        
        self.db_pass = tk.Entry(
            self.db_frame,
            show="●",
            width=32,
            font=("Segoe UI", 10),
            relief=tk.FLAT,
            bg="#f1f5f9",
            fg="#1e293b",
            insertbackground="#3b82f6",
            bd=0,
            highlightthickness=2,
            highlightbackground="#e2e8f0",
            highlightcolor="#3b82f6"
        )
        self.db_pass.grid(row=4, column=1, pady=(8, 2), ipady=6)
        
        tk.Label(
            self.db_frame,
            text="Optional: Leave empty for no password",
            font=("Segoe UI", 8),
            bg="white",
            fg="#94a3b8"
        ).grid(row=5, column=1, sticky=tk.W, pady=(2, 8))
        
        # Setup progress, log, and buttons
        self.setup_progress_and_buttons(content_frame)
    
    def create_input_field(self, parent, row, label_text, default_value, attr_name):
        """Create a styled input field with label and helper text"""
        # Label with icon
        tk.Label(
            parent,
            text=label_text,
            font=("Segoe UI", 9, "bold"),
            bg="white",
            fg="#475569",
            anchor=tk.W
        ).grid(row=row*2, column=0, sticky=tk.W, pady=(8, 2), padx=(0, 10))
        
        # Entry field
        entry = tk.Entry(
            parent,
            width=32,
            font=("Segoe UI", 10),
            relief=tk.FLAT,
            bg="#f1f5f9",
            fg="#1e293b",
            insertbackground="#3b82f6",
            bd=0,
            highlightthickness=2,
            highlightbackground="#e2e8f0",
            highlightcolor="#3b82f6"
        )
        entry.grid(row=row*2, column=1, pady=(8, 2), ipady=6)
        entry.insert(0, default_value)
        setattr(self, attr_name, entry)
        
        # Helper text
        helper_texts = {
            0: "The hostname of your MySQL server",
            1: "Usually 3306 for MySQL",
            2: "Will be created automatically if doesn't exist",
            3: "MySQL user with database privileges"
        }
        
        tk.Label(
            parent,
            text=helper_texts.get(row, ""),
            font=("Segoe UI", 8),
            bg="white",
            fg="#94a3b8"
        ).grid(row=row*2+1, column=1, sticky=tk.W, pady=(2, 8))
    
    def setup_progress_and_buttons(self, content_frame):
        """Setup progress bar, log area, and buttons"""
        # Progress section
        self.progress_frame = tk.Frame(content_frame, bg="white")
        self.progress_frame.pack(fill=tk.X, pady=(15, 10))
        
        # Progress header
        progress_header = tk.Frame(self.progress_frame, bg="white")
        progress_header.pack(fill=tk.X, pady=(0, 8))
        
        self.progress_label = tk.Label(
            progress_header,
            text="",
            font=("Segoe UI", 9, "bold"),
            bg="white",
            fg="#475569",
            anchor=tk.W
        )
        self.progress_label.pack(side=tk.LEFT)
        
        self.progress_percent = tk.Label(
            progress_header,
            text="",
            font=("Segoe UI", 9, "bold"),
            bg="white",
            fg="#3b82f6",
            anchor=tk.E
        )
        self.progress_percent.pack(side=tk.RIGHT)
        
        # Custom styled progress bar
        progress_bg = tk.Frame(self.progress_frame, bg="#e2e8f0", height=12, relief=tk.FLAT)
        progress_bg.pack(fill=tk.X)
        
        self.progress = ttk.Progressbar(
            self.progress_frame,
            mode='determinate',
            length=500,
            style="Custom.Horizontal.TProgressbar"
        )
        self.progress.pack(fill=tk.X)
        
        # Configure progress bar style
        style = ttk.Style()
        style.theme_use('default')
        style.configure(
            "Custom.Horizontal.TProgressbar",
            thickness=12,
            troughcolor='#e2e8f0',
            background='#3b82f6',
            borderwidth=0,
            relief=tk.FLAT
        )
        
        # Log text area
        self.log_frame = tk.LabelFrame(
            content_frame,
            text=" 📋 Installation Log ",
            font=("Segoe UI", 9, "bold"),
            bg="white",
            fg="#1e293b",
            padx=15,
            pady=15,
            relief=tk.FLAT,
            borderwidth=2
        )
        
        log_container = tk.Frame(self.log_frame, bg="#0f172a", relief=tk.FLAT)
        log_container.pack(fill=tk.BOTH, expand=True)
        
        self.log_text = tk.Text(
            log_container,
            height=10,
            width=60,
            font=("Consolas", 9),
            bg="#0f172a",
            fg="#94a3b8",
            insertbackground="#3b82f6",
            relief=tk.FLAT,
            bd=0,
            padx=10,
            pady=8,
            wrap=tk.WORD
        )
        scrollbar = tk.Scrollbar(log_container, command=self.log_text.yview, bg="#1e293b")
        self.log_text.config(yscrollcommand=scrollbar.set)
        
        self.log_text.pack(side=tk.LEFT, fill=tk.BOTH, expand=True)
        scrollbar.pack(side=tk.RIGHT, fill=tk.Y)
        
        # Configure text tags for colored output
        self.log_text.tag_configure("success", foreground="#10b981")
        self.log_text.tag_configure("error", foreground="#ef4444")
        self.log_text.tag_configure("warning", foreground="#f59e0b")
        self.log_text.tag_configure("info", foreground="#3b82f6")
        
        # Buttons frame
        self.button_frame = tk.Frame(content_frame, bg="white")
        self.button_frame.pack(pady=(20, 0), fill=tk.X)
        
        # Button container for centering
        btn_container = tk.Frame(self.button_frame, bg="white")
        btn_container.pack()
        
        # Exit button (secondary style)
        self.exit_button = tk.Button(
            btn_container,
            text="Cancel",
            command=self.root.quit,
            bg="white",
            fg="#64748b",
            font=("Segoe UI", 10, "bold"),
            padx=30,
            pady=12,
            cursor="hand2",
            relief=tk.FLAT,
            borderwidth=2,
            highlightthickness=2,
            highlightbackground="#cbd5e1",
            highlightcolor="#94a3b8",
            activebackground="#f1f5f9",
            activeforeground="#475569"
        )
        self.exit_button.pack(side=tk.LEFT, padx=6)
        
        # Install button (primary style)
        self.install_button = tk.Button(
            btn_container,
            text="⚡ Install Now",
            command=self.start_installation,
            bg="#3b82f6",
            fg="white",
            font=("Segoe UI", 10, "bold"),
            padx=35,
            pady=12,
            cursor="hand2",
            relief=tk.FLAT,
            borderwidth=0,
            activebackground="#2563eb",
            activeforeground="white"
        )
        self.install_button.pack(side=tk.LEFT, padx=6)
        
        # Launch button (success style)
        self.launch_button = tk.Button(
            btn_container,
            text="🚀 Launch System",
            command=self.launch_system,
            bg="#10b981",
            fg="white",
            font=("Segoe UI", 10, "bold"),
            padx=30,
            pady=12,
            cursor="hand2",
            relief=tk.FLAT,
            borderwidth=0,
            state=tk.DISABLED,
            disabledforeground="#a0a0a0",
            activebackground="#059669",
            activeforeground="white"
        )
        self.launch_button.pack(side=tk.LEFT, padx=6)
        
        # Footer
        footer = tk.Label(
            self.root,
            text=f"© {2025} - Powered by Laravel",
            font=("Segoe UI", 8),
            bg="#f8fafc",
            fg="#94a3b8"
        )
        footer.pack(pady=(10, 15))
    
    def check_installation_status(self):
        env_exists = (self.project_path / ".env").exists()
        vendor_exists = (self.project_path / "vendor").exists()
        node_modules_exists = (self.project_path / "node_modules").exists()
        
        if env_exists and vendor_exists and node_modules_exists:
            self.status_icon.config(text="✅")
            self.status_label.config(
                text="System is already installed and ready to use!",
                fg="#10b981",
                font=("Segoe UI", 10, "bold")
            )
            self.install_button.config(text="🔄 Reinstall", bg="#f59e0b")
            self.launch_button.config(state=tk.NORMAL)
            self.log("System already installed. You can launch or reinstall.", "success")
        else:
            self.status_icon.config(text="ℹ️")
            self.status_label.config(
                text="System needs to be installed. Configure database and click 'Install Now'",
                fg="#f59e0b",
                font=("Segoe UI", 10, "bold")
            )
            self.db_frame.pack(fill=tk.X, pady=(0, 15))
            if not env_exists:
                self.log("✗ .env file not found", "warning")
            if not vendor_exists:
                self.log("✗ Composer dependencies not installed", "warning")
            if not node_modules_exists:
                self.log("✗ NPM packages not installed", "warning")
    
    def log(self, message, tag=None):
        """Log message with optional color tag"""
        # Determine tag based on message content if not specified
        if tag is None:
            if "✓" in message or "SUCCESS" in message.upper() or "COMPLETE" in message.upper():
                tag = "success"
            elif "✗" in message or "ERROR" in message.upper() or "FAILED" in message.upper():
                tag = "error"
            elif "WARNING" in message.upper() or "⚠" in message:
                tag = "warning"
            elif ">" in message or "Step" in message:
                tag = "info"
        
        self.log_text.insert(tk.END, f"{message}\n", tag)
        self.log_text.see(tk.END)
        self.root.update()
    
    def update_progress(self, value, message):
        self.progress['value'] = value
        self.progress_label.config(text=message)
        self.progress_percent.config(text=f"{int(value)}%")
        self.root.update()
    
    def run_command(self, command, cwd=None, shell=True):
        """Run command and capture output"""
        try:
            if cwd is None:
                cwd = str(self.project_path)
            
            self.log(f"\n> Running: {command}")
            
            process = subprocess.Popen(
                command,
                shell=shell,
                cwd=cwd,
                stdout=subprocess.PIPE,
                stderr=subprocess.PIPE,
                text=True,
                bufsize=1,
                universal_newlines=True
            )
            
            # Read output in real-time
            for line in process.stdout:
                self.log(line.strip())
            
            # Wait for process to complete
            process.wait()
            
            # Check for errors
            if process.returncode != 0:
                error_output = process.stderr.read()
                self.log(f"ERROR: {error_output}")
                return False
            
            return True
        except Exception as e:
            self.log(f"ERROR: {str(e)}")
            return False
    
    def create_env_file(self):
        """Create .env file with user-provided database credentials - MySQL pre-configured"""
        env_path = self.project_path / ".env"
        
        # Always create fresh .env with MySQL configured (no comments)
        env_content = f"""APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST={self.db_host.get()}
DB_PORT={self.db_port.get()}
DB_DATABASE={self.db_name.get()}
DB_USERNAME={self.db_user.get()}
DB_PASSWORD={self.db_pass.get()}

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${{APP_NAME}}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${{APP_NAME}}"
"""
        
        # Write .env file directly with MySQL configured
        with open(env_path, 'w') as f:
            f.write(env_content)
        
        self.log("✓ .env file created with MySQL configuration")
        return True
    
    def installation_process(self):
        """Main installation process"""
        try:
            self.install_button.config(state=tk.DISABLED)
            self.launch_button.config(state=tk.DISABLED)
            
            # Step 1: Check/Create .env file
            self.update_progress(10, "Step 1/6: Checking .env file...")
            env_path = self.project_path / ".env"
            if not env_path.exists():
                self.log("Creating .env file...")
                if not self.create_env_file():
                    raise Exception("Failed to create .env file")
            else:
                self.log("✓ .env file already exists")
            
            # Step 2: Composer install
            self.update_progress(20, "Step 2/6: Installing Composer dependencies...")
            if not (self.project_path / "vendor").exists():
                if not self.run_command("composer install --no-interaction"):
                    raise Exception("Composer install failed")
                self.log("✓ Composer dependencies installed")
            else:
                self.log("✓ Composer dependencies already installed")
            
            # Step 3: Generate APP_KEY
            self.update_progress(40, "Step 3/6: Generating application key...")
            self.run_command("php artisan key:generate --force")
            self.log("✓ Application key generated")
            
            # Step 4: NPM install
            self.update_progress(55, "Step 4/6: Installing NPM packages...")
            if not (self.project_path / "node_modules").exists():
                if not self.run_command("npm install"):
                    raise Exception("NPM install failed")
                self.log("✓ NPM packages installed")
            else:
                self.log("✓ NPM packages already installed")
            
            # Step 5: Run migrations
            self.update_progress(75, "Step 5/6: Running database migrations...")
            # First create database
            self.log("Creating database if not exists...")
            create_db_cmd = f'mysql -h{self.db_host.get()} -u{self.db_user.get()} {"-p" + self.db_pass.get() if self.db_pass.get() else ""} -e "CREATE DATABASE IF NOT EXISTS {self.db_name.get()} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"'
            self.run_command(create_db_cmd)
            self.log("✓ Database ready")
            
            if not self.run_command("php artisan migrate --force"):
                raise Exception("Database migration failed")
            self.log("✓ Database migrations completed")
            
            # Step 6: Seed database
            self.update_progress(90, "Step 6/6: Seeding database...")
            if not self.run_command("php artisan db:seed --force"):
                raise Exception("Database seeding failed")
            self.log("✓ Database seeded successfully")
            
            # Complete
            self.update_progress(100, "Installation Complete!")
            self.log("\n" + "="*50)
            self.log("✓ SETUP COMPLETE – Launching system...")
            self.log("="*50)
            
            self.status_icon.config(text="✅")
            self.status_label.config(
                text="Installation complete! Launching system...",
                fg="#10b981",
                font=("Segoe UI", 10, "bold")
            )
            
            # Auto-launch system
            self.root.after(1500, self.auto_launch_system)
            
        except Exception as e:
            self.log(f"\n✗ Installation failed: {str(e)}")
            messagebox.showerror("Installation Failed", f"Installation failed:\n{str(e)}")
            self.install_button.config(state=tk.NORMAL)
    
    def start_installation(self):
        """Start installation in a separate thread"""
        # Validate database inputs
        if not self.db_name.get() or not self.db_user.get():
            messagebox.showwarning(
                "Missing Information",
                "Please fill in database name and username."
            )
            return
        
        # Confirm installation
        if not messagebox.askyesno(
            "Confirm Installation",
            f"This will install the Laravel application with:\n\n"
            f"Database: {self.db_name.get()}\n"
            f"Username: {self.db_user.get()}\n\n"
            f"Continue?"
        ):
            return
        
        # Run installation in background thread
        self.log_frame.pack(fill=tk.BOTH, expand=True, pady=10)
        installation_thread = threading.Thread(target=self.installation_process)
        installation_thread.daemon = True
        installation_thread.start()
    
    def launch_system(self):
        """Launch the Laravel system"""
        try:
            self.log("\n" + "="*50)
            self.log("Launching system...")
            self.log("="*50)
            
            # Start Laravel server in a new window
            self.log("Starting Laravel development server...")
            server_cmd = f'start cmd /k "cd /d {self.project_path} && php artisan serve"'
            subprocess.Popen(server_cmd, shell=True)
            
            # Start NPM dev in a new window
            self.log("Starting NPM development server...")
            npm_cmd = f'start cmd /k "cd /d {self.project_path} && npm run dev"'
            subprocess.Popen(npm_cmd, shell=True)
            
            self.log("\n✓ System launched successfully!")
            self.log("Laravel server: http://localhost:8000")
            self.log("Vite dev server: Running in separate window")
            
            messagebox.showinfo(
                "System Launched",
                "Laravel application is now running!\n\n"
                "Laravel: http://localhost:8000\n"
                "Vite: Running in separate terminal\n\n"
                "Close the terminal windows to stop the servers."
            )
            
        except Exception as e:
            self.log(f"✗ Failed to launch system: {str(e)}")
            messagebox.showerror("Launch Failed", f"Failed to launch system:\n{str(e)}")
    
    def auto_launch_system(self):
        """Automatically launch the system after installation"""
        try:
            self.log("\n" + "="*50)
            self.log("Auto-launching system...")
            self.log("="*50)
            
            # Start Laravel server in a new window
            self.log("Starting Laravel development server...")
            server_cmd = f'start cmd /k "cd /d {self.project_path} && php artisan serve"'
            subprocess.Popen(server_cmd, shell=True)
            
            # Start NPM dev in a new window
            self.log("Starting NPM development server...")
            npm_cmd = f'start cmd /k "cd /d {self.project_path} && npm run dev"'
            subprocess.Popen(npm_cmd, shell=True)
            
            self.log("\n✓ System launched successfully!")
            self.log("Laravel server: http://localhost:8000")
            self.log("Vite dev server: Running in separate window")
            
            self.status_label.config(text="System is running! Access at http://localhost:8000")
            
            messagebox.showinfo(
                "System Launched",
                "Laravel application is now running!\n\n"
                "Laravel: http://localhost:8000\n"
                "Vite: Running in separate terminal\n\n"
                "You can close this installer.\n"
                "Close the terminal windows to stop the servers."
            )
            
        except Exception as e:
            self.log(f"✗ Failed to auto-launch system: {str(e)}")
            self.launch_button.config(state=tk.NORMAL)

def main():
    root = tk.Tk()
    app = LaravelInstaller(root)
    root.mainloop()

if __name__ == "__main__":
    main()
