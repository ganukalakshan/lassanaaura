<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - LassanaAura</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/theme.css', 'resources/css/app.css'])
    <style>
        body {
            background: linear-gradient(135deg, #FFFFFF 0%, #FFE8ED 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .login-container {
            max-width: 450px;
            width: 100%;
            background: var(--white);
            border-radius: 24px;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--primary-pink-darker) 100%);
            padding: 3rem 2rem;
            text-align: center;
            color: var(--white);
        }
        
        .login-logo {
            width: 70px;
            height: 70px;
            background: var(--white);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary-pink-darker);
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            font-size: 0.9375rem;
            opacity: 0.9;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-primary);
        }
        
        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            font-size: 0.9375rem;
            border: 2px solid var(--gray);
            border-radius: 12px;
            background: var(--white);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 3px var(--primary-pink-lighter);
        }
        
        .btn {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--primary-pink-darker) 100%);
            color: var(--white);
            box-shadow: 0 4px 6px rgba(255, 182, 193, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(255, 182, 193, 0.4);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .alert-danger {
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
            color: var(--primary-pink-darker);
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
                <i class="fas fa-chart-line"></i>
            </div>
            <h1>LassanaAura</h1>
            <p>Sign in to access your dashboard</p>
        </div>
        
        <div class="login-body">
            @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
            @endif
            
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Email Address
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control" 
                           placeholder="Enter your email"
                           value="{{ old('email') }}"
                           required 
                           autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control" 
                           placeholder="Enter your password"
                           required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </div>
            </form>
            
            <div class="back-link">
                <a href="{{ route('home') }}">
                    <i class="fas fa-arrow-left"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
