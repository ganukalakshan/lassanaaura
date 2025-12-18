<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In - Aura ERP</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- RemixIcon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            animation: float 6s ease-in-out infinite;
        }
        
        body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -150px;
            left: -150px;
            animation: float 8s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 1;
        }
        
        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 50px 40px 40px;
            text-align: center;
            position: relative;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
            background: white;
            border-radius: 50% 50% 0 0;
        }
        
        .logo-icon {
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .logo-icon i {
            font-size: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .login-header h1 {
            color: white;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }
        
        .login-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            position: relative;
            z-index: 1;
        }
        
        .login-body {
            padding: 50px 40px 40px;
        }
        
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            animation: shake 0.5s ease;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        .alert i {
            font-size: 20px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 10px;
        }
        
        .form-label i {
            color: #667eea;
            font-size: 18px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .form-control {
            width: 100%;
            padding: 15px 20px;
            font-size: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            background: #f8fafc;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 14px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            cursor: pointer;
        }
        
        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }
        
        .btn-primary {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn-primary i {
            font-size: 20px;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #f1f5f9;
        }
        
        .login-footer p {
            color: #64748b;
            font-size: 13px;
        }
        
        .version-badge {
            display: inline-block;
            margin-top: 15px;
            padding: 6px 12px;
            background: #f1f5f9;
            color: #667eea;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-icon">
                    <i class="ri-sparkling-2-fill"></i>
                </div>
                <h1>✨ Aura ERP</h1>
                <p>Modern Business Management Suite</p>
            </div>
            
            <div class="login-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <i class="ri-error-warning-fill"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-danger">
                    <i class="ri-error-warning-fill"></i>
                    {{ session('error') }}
                </div>
                @endif
                
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="ri-mail-line"></i>
                            <span>Email Address</span>
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control" 
                                placeholder="admin@example.com"
                                value="{{ old('email') }}"
                                required 
                                autofocus
                            >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="ri-lock-password-line"></i>
                            <span>Password</span>
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control" 
                                placeholder="Enter your password"
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="btn-primary">
                        <i class="ri-login-box-line"></i>
                        <span>Sign In</span>
                    </button>
                    
                    <div class="login-footer">
                        <p>© {{ date('Y') }} Aura ERP. All rights reserved.</p>
                        <span class="version-badge">v1.0.0</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-primary);
        }
        

            background: var(--danger-light);
            color: #C62828;
            border-left: 4px solid var(--danger);
        }
        
        .divider {
            text-align: center;
            margin: 1.5rem 0;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }
        
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .back-link a {
            color: var(--primary-purple-dark);
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-gem"></i>
            </div>
            <h1>✨ Aura ERP</h1>
            <p>Sign in to access your dashboard</p>

                </a>
            </div>
        </div>
    </div>
</body>
</html>
