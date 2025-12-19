<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Application Installer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideProgress {
            from { width: 0%; }
            to { width: 100%; }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .progress-animate {
            animation: slideProgress 0.5s ease-out forwards;
        }

        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            transform: scale(1.01);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 flex items-center justify-center p-4">
    <div class="w-full max-w-2xl">
        <!-- Main Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden fade-in">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-10 text-center">
                <div class="w-20 h-20 bg-white rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Application Installer</h1>
                <p class="text-blue-100">Configure your database to get started</p>
            </div>

            <!-- Form Container -->
            <div class="px-8 py-8">
                <form id="installerForm" class="space-y-6">
                    @csrf

                    <!-- Database Host -->
                    <div class="space-y-2">
                        <label for="db_host" class="flex items-center text-sm font-semibold text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                            </svg>
                            Database Host
                        </label>
                        <input type="text" id="db_host" name="db_host" value="127.0.0.1" 
                            class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="127.0.0.1" required>
                        <p class="text-xs text-gray-500 ml-1">The hostname of your MySQL server</p>
                    </div>

                    <!-- Database Port -->
                    <div class="space-y-2">
                        <label for="db_port" class="flex items-center text-sm font-semibold text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Database Port
                        </label>
                        <input type="number" id="db_port" name="db_port" value="3306" 
                            class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="3306" required>
                        <p class="text-xs text-gray-500 ml-1">Usually 3306 for MySQL</p>
                    </div>

                    <!-- Database Name -->
                    <div class="space-y-2">
                        <label for="db_name" class="flex items-center text-sm font-semibold text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                            Database Name
                        </label>
                        <input type="text" id="db_name" name="db_name" value="auraERP" 
                            class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="auraERP" required>
                        <p class="text-xs text-gray-500 ml-1">Will be created automatically if doesn't exist</p>
                    </div>

                    <!-- Database Username -->
                    <div class="space-y-2">
                        <label for="db_username" class="flex items-center text-sm font-semibold text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Database Username
                        </label>
                        <input type="text" id="db_username" name="db_username" value="root" 
                            class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="root" required>
                        <p class="text-xs text-gray-500 ml-1">MySQL user with database privileges</p>
                    </div>

                    <!-- Database Password -->
                    <div class="space-y-2">
                        <label for="db_password" class="flex items-center text-sm font-semibold text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Database Password
                        </label>
                        <input type="password" id="db_password" name="db_password" 
                            class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="Leave empty if no password">
                        <p class="text-xs text-gray-500 ml-1">Optional: Leave empty for no password</p>
                    </div>

                    <!-- Progress Bar -->
                    <div id="progressContainer" class="hidden mt-8">
                        <div class="mb-3">
                            <div class="flex justify-between items-center mb-2">
                                <span id="progressText" class="text-sm font-medium text-gray-700">Preparing installation...</span>
                                <span id="progressPercent" class="text-sm font-medium text-blue-600">0%</span>
                            </div>
                            <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden shadow-inner">
                                <div id="progressBar" class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500" style="width: 0%"></div>
                            </div>
                        </div>
                        <div id="statusMessages" class="bg-gray-50 rounded-xl p-4 max-h-40 overflow-y-auto border border-gray-200">
                            <p class="text-xs text-gray-600 font-mono"></p>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 pt-4">
                        <button type="button" id="cancelBtn" 
                            class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl btn-hover hover:border-gray-400 hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit" id="installBtn" 
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl btn-hover hover:from-blue-700 hover:to-indigo-700 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed transition">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Install Now
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-gray-600 text-sm">
            <p>© {{ date('Y') }} - Powered by Laravel</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('installerForm');
            const installBtn = document.getElementById('installBtn');
            const progressContainer = document.getElementById('progressContainer');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');
            const progressPercent = document.getElementById('progressPercent');
            const statusMessages = document.getElementById('statusMessages');

            const steps = [
                { progress: 20, message: 'Testing database connection...' },
                { progress: 40, message: 'Updating configuration files...' },
                { progress: 60, message: 'Running database migrations...' },
                { progress: 80, message: 'Seeding initial data...' },
                { progress: 100, message: 'Installation complete!' }
            ];

            let currentStep = 0;

            function updateProgress(step) {
                const stepData = steps[step];
                progressBar.style.width = stepData.progress + '%';
                progressPercent.textContent = stepData.progress + '%';
                progressText.textContent = stepData.message;
                
                const timestamp = new Date().toLocaleTimeString();
                statusMessages.innerHTML += `<p class="text-xs text-gray-600 font-mono mb-1">[${timestamp}] ${stepData.message}</p>`;
                statusMessages.scrollTop = statusMessages.scrollHeight;
            }

            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                installBtn.disabled = true;
                installBtn.innerHTML = `
                    <span class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Installing...
                    </span>
                `;
                
                progressContainer.classList.remove('hidden');
                statusMessages.innerHTML = '';
                currentStep = 0;

                const formData = new FormData(form);
                
                // Simulate progress steps
                const progressInterval = setInterval(() => {
                    if (currentStep < 4) {
                        updateProgress(currentStep);
                        currentStep++;
                    }
                }, 800);

                try {
                    const response = await fetch('{{ route("installer.install") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const data = await response.json();
                    clearInterval(progressInterval);

                    if (data.success) {
                        updateProgress(4);
                        progressText.textContent = 'Installation complete! Redirecting...';
                        statusMessages.innerHTML += `<p class="text-xs text-green-600 font-mono font-bold mt-2">✓ System ready! Launching...</p>`;
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1500);
                    } else {
                        throw new Error(data.message || 'Installation failed');
                    }
                } catch (error) {
                    clearInterval(progressInterval);
                    progressBar.classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-indigo-600');
                    progressBar.classList.add('bg-red-500');
                    progressText.textContent = 'Installation failed!';
                    statusMessages.innerHTML += `<p class="text-xs text-red-600 font-mono font-bold mt-2">ERROR: ${error.message}</p>`;
                    
                    installBtn.disabled = false;
                    installBtn.innerHTML = `
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Retry Installation
                        </span>
                    `;
                }
            });

            document.getElementById('cancelBtn').addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel the installation?')) {
                    window.location.href = '/';
                }
            });
        });
    </script>
</body>
</html>
