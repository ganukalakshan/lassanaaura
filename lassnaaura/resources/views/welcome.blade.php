<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Business Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-pink: #FFB6C1;
            --primary-pink-light: #FFD4DB;
            --primary-pink-lighter: #FFE8ED;
            --primary-pink-dark: #FF9AAA;
            --primary-pink-darker: #FF7D8F;
            --white: #FFFFFF;
            --text-primary: #333333;
            --text-secondary: #666666;
            --shadow-lg: 0 10px 15px rgba(255, 182, 193, 0.2), 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px rgba(255, 182, 193, 0.25), 0 10px 10px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--white) 0%, var(--primary-pink-lighter) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .welcome-container {
            max-width: 800px;
            width: 100%;
            background: var(--white);
            border-radius: 24px;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
        }
        
        .welcome-header {
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--primary-pink-darker) 100%);
            padding: 4rem 3rem;
            text-align: center;
            color: var(--white);
        }
        
        .logo-icon {
            width: 80px;
            height: 80px;
            background: var(--white);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--primary-pink-darker);
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .welcome-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }
        
        .welcome-header p {
            font-size: 1.125rem;
            opacity: 0.95;
            font-weight: 400;
        }
        
        .welcome-body {
            padding: 3rem;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .feature-item {
            text-align: center;
            padding: 1.5rem;
            background: linear-gradient(135deg, var(--white) 0%, var(--primary-pink-lighter) 100%);
            border-radius: 16px;
            border: 2px solid var(--primary-pink-light);
        }
        
        .feature-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-pink) 0%, var(--primary-pink-darker) 100%);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--white);
            margin-bottom: 1rem;
        }
        
        .feature-item h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
        
        .feature-item p {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
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
        
        .btn-secondary {
            background: var(--white);
            color: var(--primary-pink-darker);
            border: 2px solid var(--primary-pink);
        }
        
        .btn-secondary:hover {
            background: var(--primary-pink-lighter);
        }
        
        @media (max-width: 768px) {
            .welcome-header h1 {
                font-size: 2rem;
            }
            
            .welcome-body {
                padding: 2rem;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-header">
            <div class="logo-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <h1>Business Management System</h1>
            <p>Complete ERP solution for your business needs</p>
        </div>
        
        <div class="welcome-body">
            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>CRM</h3>
                    <p>Customer relationship management</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h3>Invoicing</h3>
                    <p>Create & track invoices</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <h3>Inventory</h3>
                    <p>Stock management system</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Reports</h3>
                    <p>Business analytics & insights</p>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In to Dashboard
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-info-circle"></i>
                    Learn More
                </a>
            </div>
        </div>
    </div>
</body>
</html>
