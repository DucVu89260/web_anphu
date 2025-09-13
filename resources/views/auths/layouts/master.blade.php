<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Web Admin') }}</title>

    <!-- Bootstrap 4 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style_all.css') }}">
    
    <!-- Social Media Component CSS -->
    <link rel="stylesheet" href="{{ asset('css/social-media.css') }}">

    @stack('styles')
    <style>
        /* Auth Styles - Keeping Original Color Scheme */
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-dark) 100%);
            min-height: 100vh;
            margin: 0;
        }

        .bg-auth {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
        }

        .bg-auth::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23C9B037" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            pointer-events: none;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(3, 10, 54, 0.2);
            border: 2px solid var(--color-secondary);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
            position: relative;
        }

        .auth-header {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-dark) 100%);
            color: var(--color-white);
            padding: 1.5rem 2rem;
            text-align: center;
            position: relative;
            border-bottom: 3px solid var(--color-secondary);
        }

        .auth-header::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--color-secondary);
            border-radius: 0;
        }

        .auth-header h4 {
            margin: 0;
            font-weight: bold;
            font-size: 1.4rem;
            color: var(--color-white);
        }

        .auth-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
            font-size: 0.875rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s ease;
            background: var(--color-white);
            font-family: 'Segoe UI', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-secondary);
            box-shadow: 0 0 0 3px rgba(201, 176, 55, 0.2);
            transform: translateY(-1px);
        }

        .btn-auth {
            width: 100%;
            padding: 0.875rem 1rem;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-dark) 100%);
            border: 2px solid var(--color-secondary);
            border-radius: 8px;
            color: var(--color-white);
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            font-family: 'Segoe UI', sans-serif;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(3, 10, 54, 0.3);
            border-color: var(--color-secondary);
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        .btn-auth::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(201, 176, 55, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-auth:hover::before {
            left: 100%;
        }

        .auth-footer {
            padding: 1rem 2rem;
            text-align: center;
            background: var(--color-gray);
            border-top: 2px solid var(--color-secondary);
            color: var(--color-text);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .auth-link {
            color: var(--color-secondary);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s ease;
        }

        .auth-link:hover {
            color: var(--color-primary);
            text-decoration: none;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        .alert-success {
            background: #f0fdf4;
            color: #16a34a;
            border-left: 4px solid #16a34a;
        }

        /* Animation */
        .auth-card {
            animation: slideUp 0.6s ease-out;
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

        /* Topbar Fixes */
        .anphu-logo {
            height: 60px;
            max-width: 100%;
            object-fit: contain;
        }

        .logo-link {
            display: inline-block;
            text-decoration: none;
        }

        .social-links {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.25rem;
            flex-wrap: wrap;
        }

        .social-links .btn {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .auth-header {
                padding: 1.5rem 1rem 1rem;
            }
            
            .auth-body {
                padding: 1.5rem;
            }
            
            .auth-footer {
                padding: 1rem;
            }

            .anphu-logo {
                height: 35px;
            }

            .social-links {
                justify-content: center;
                margin: 0.5rem 0;
            }
        }
    </style>
</head>
<body>
    @include('auths.layouts.top_bar')

    <div class="bg-auth">
        <div class="auth-card">
            <!-- header -->
            <div class="auth-header">
                <h4>{{ $title ?? config('app.name') }}</h4>
            </div>
     
            <!-- body -->
            <div class="auth-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>

            <!-- footer -->
            <div class="auth-footer">
                ©2025 {{ company()->company_brand }}
            </div>
        </div>
    </div>
</body>

<!-- Bootstrap 4 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</html>
