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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f7fa;
            overflow: hidden;
        }
        
        .login-wrapper {
            display: flex;
            width: 95%;
            max-width: 1200px;
            height: 700px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 80px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: fadeInScale 0.6s ease;
        }
        
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .login-left {
            flex: 1;
            background: white;
            padding: 60px 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        
        .login-right {
            flex: 1.3;
            background: linear-gradient(135deg, #5b7cdb 0%, #7b94e8 50%, #a8b8f0 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Globe Background Animation */
        .globe-container {
            position: absolute;
            width: 500px;
            height: 500px;
            animation: rotateGlobe 30s linear infinite;
        }
        
        @keyframes rotateGlobe {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .globe {
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.05) 70%);
            border-radius: 50%;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2), inset 0 0 100px rgba(255, 255, 255, 0.1);
        }
        
        .globe::before {
            content: '';
            position: absolute;
            inset: 20px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M100,10 Q120,50 100,90 T100,170" stroke="rgba(255,255,255,0.3)" fill="none" stroke-width="0.5"/><path d="M40,100 Q80,80 120,100 T180,100" stroke="rgba(255,255,255,0.3)" fill="none" stroke-width="0.5"/><circle cx="50" cy="60" r="2" fill="white" opacity="0.6"/><circle cx="150" cy="80" r="2" fill="white" opacity="0.6"/><circle cx="120" cy="140" r="2" fill="white" opacity="0.6"/></svg>');
            background-size: cover;
            border-radius: 50%;
        }
        
        /* Network nodes */
        .network-node {
            position: absolute;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 3s ease-in-out infinite;
        }
        
        .network-node i {
            color: white;
            font-size: 18px;
        }
        
        .node-1 { top: 15%; left: 10%; animation-delay: 0s; }
        .node-2 { top: 20%; right: 15%; animation-delay: 1s; }
        .node-3 { bottom: 25%; left: 15%; animation-delay: 2s; }
        .node-4 { bottom: 20%; right: 10%; animation-delay: 1.5s; }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50% { transform: scale(1.1); opacity: 1; }
        }
        
        .light-effect {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .light-1 { top: -100px; right: -100px; animation-delay: 0s; }
        .light-2 { bottom: -150px; left: -100px; animation-delay: 3s; }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -20px); }
        }
        
        /* Logo and Branding */
        .logo-section {
            text-align: center;
            margin-bottom: 45px;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #5b7cdb 0%, #7b94e8 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(91, 124, 219, 0.3);
        }
        
        .logo i {
            font-size: 30px;
            color: white;
        }
        
        .brand-name {
            font-size: 28px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }
        
        .brand-tagline {
            font-size: 13px;
            color: #718096;
            font-weight: 400;
        }
        
        .login-title {
            font-size: 18px;
            color: #2d3748;
            font-weight: 500;
            margin-bottom: 35px;
            text-align: left;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 8px;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 16px;
            font-size: 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            background: #f7fafc;
            color: #2d3748;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #5b7cdb;
            background: white;
            box-shadow: 0 0 0 3px rgba(91, 124, 219, 0.1);
        }
        
        .form-control::placeholder {
            color: #a0aec0;
        }
        
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            margin-top: 12px;
        }
        
        .remember-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .checkbox-custom {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #5b7cdb;
        }
        
        .remember-label {
            font-size: 13px;
            color: #4a5568;
            cursor: pointer;
            user-select: none;
        }
        
        .forgot-link {
            font-size: 13px;
            color: #5b7cdb;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .forgot-link:hover {
            color: #4a69bb;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            font-size: 15px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, #5b7cdb 0%, #7b94e8 100%);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(91, 124, 219, 0.3);
            letter-spacing: 0.3px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(91, 124, 219, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 30px 0 25px;
            color: #a0aec0;
            font-size: 13px;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }
        
        .divider span {
            padding: 0 15px;
        }
        
        .sso-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #5b7cdb;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .sso-link:hover {
            color: #4a69bb;
        }
        
        .sso-link i {
            font-size: 16px;
        }
        
        /* Alert Styles */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-danger {
            background: #fee;
            color: #c53030;
            border-left: 3px solid #e53e3e;
        }
        
        .alert i {
            font-size: 18px;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
                height: auto;
            }
            
            .login-right {
                height: 200px;
                order: -1;
            }
            
            .login-left {
                padding: 40px 30px;
            }
            
            .globe-container {
                width: 300px;
                height: 300px;
            }
        }
        
        @media (max-width: 576px) {
            .login-wrapper {
                width: 100%;
                border-radius: 0;
            }
            
            .login-left {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left Side - Login Form -->
        <div class="login-left">
            <div class="logo-section">
                <div class="logo">
                    <i class="ri-rocket-2-fill"></i>
                </div>
                <div class="brand-name">Aura ERP</div>
                <div class="brand-tagline">Modern Business Management Suite</div>
            </div>
            
            <h2 class="login-title">PLEASE LOGIN</h2>
            
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
                    <label for="email" class="form-label">Username</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        placeholder="Enter your username"
                        value="{{ old('email') }}"
                        required 
                        autofocus
                    >
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        placeholder="Enter your password"
                        required
                    >
                </div>
                
                <div class="form-options">
                    <div class="remember-group">
                        <input type="checkbox" name="remember" id="remember" class="checkbox-custom">
                        <label for="remember" class="remember-label">Remember Me</label>
                    </div>
                    <a href="#" class="forgot-link">Forgot Password</a>
                </div>
                
                <button type="submit" class="btn-login">LOGIN</button>
                
                <div class="divider">
                    <span>OR</span>
                </div>
                
                <div style="text-align: center;">
                    <a href="#" class="sso-link">
                        <i class="ri-shield-keyhole-line"></i>
                        Single Sign On
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Right Side - Background Graphics -->
        <div class="login-right">
            <div class="light-effect light-1"></div>
            <div class="light-effect light-2"></div>
            
            <div class="globe-container">
                <div class="globe"></div>
            </div>
            
            <div class="network-node node-1">
                <i class="ri-group-fill"></i>
            </div>
            <div class="network-node node-2">
                <i class="ri-global-line"></i>
            </div>
            <div class="network-node node-3">
                <i class="ri-database-2-line"></i>
            </div>
            <div class="network-node node-4">
                <i class="ri-cloud-line"></i>
            </div>
        </div>
    </div>
</body>
</html>
