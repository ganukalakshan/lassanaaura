<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Business Management System')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
  </head>
<body>
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <h1 class="header-title">
                @yield('page-title', 'Dashboard')
            </h1>
            <div class="header-actions">
                <button class="btn btn-secondary">
                    <i class="fas fa-bell"></i>
                </button>
                <button class="btn btn-secondary">
                    <i class="fas fa-user"></i>
                    {{ auth()->user()->name ?? 'User' }}
                </button>
                @auth
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
                @endauth
            </div>
        </header>
        
        <!-- Flash Messages -->
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif
        
        @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 0.5rem 0 0 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        
        <!-- Page Content -->
        @yield('content')
    </main>

    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() { alert.remove(); }, 500);
            });
        }, 5000);
    </script>
    @stack('scripts')
  </body>
  </html>