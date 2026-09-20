<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carbon Footprint Tracker - Login & Register</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html, body {
            width: 100%;
            height: 100%;
        }

        body {
            background: radial-gradient(circle at top left, rgba(87, 221, 144, 0.2), transparent 40%),
                        radial-gradient(circle at bottom right, rgba(52, 211, 153, 0.15), transparent 30%),
                        linear-gradient(135deg, #f8fafc 0%, #cbd5e1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
        }

        .container-auth {
            width: 100%;
            max-width: 950px;
            padding: 20px;
        }

        .auth-card {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 550px;
        }

        @media (max-width: 768px) {
            .auth-card {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .brand-section {
                display: none !important;
            }
        }

        /* LEFT SIDE - BRAND */
        .brand-section {
            background: linear-gradient(135deg, rgba(209, 250, 229, 0.5), rgba(240, 253, 244, 0.5));
            border-right: 1px solid #cbd5e1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .brand-logo {
            font-size: 48px;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .brand-title {
            font-size: 28px;
            font-weight: 700;
            color: #0f4f2e;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .brand-subtitle {
            font-size: 14px;
            color: #475569;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .brand-icons {
            display: flex;
            gap: 15px;
            justify-content: center;
            font-size: 32px;
            flex-wrap: wrap;
        }

        .brand-icons span {
            opacity: 0.8;
            transition: transform 0.3s ease;
        }

        .brand-icons span:hover {
            transform: scale(1.2) rotate(10deg);
        }

        /* RIGHT SIDE - FORMS */
        .form-section {
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .tabs-container {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 0;
        }

        .tab-btn {
            flex: 1;
            padding: 12px 20px;
            background: transparent;
            border: none;
            color: #64748b;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            border-bottom: 3px solid transparent;
            margin-bottom: -1px;
        }

        .tab-btn.active {
            color: #10b981;
            border-bottom-color: #10b981;
        }

        .tab-btn:hover {
            color: #1e293b;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 12px 16px;
            border-radius: 12px;
            color: #1e293b;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            background: #ffffff;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
            color: #1e293b;
            outline: none;
        }

        .form-check {
            margin-bottom: 20px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-check-input:checked {
            background: #10b981;
            border-color: #10b981;
        }

        .form-check-label {
            color: #475569;
            font-size: 13px;
            margin-left: 8px;
            cursor: pointer;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.2);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .form-text {
            font-size: 12px;
            color: #64748b;
            margin-top: 8px;
        }

        .toggle-form {
            color: #10b981;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .toggle-form:hover {
            color: #059669;
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 12px 14px;
            color: #ef4444;
            font-size: 13px;
            margin-bottom: 15px;
            display: none;
        }

        .error-message.show {
            display: block;
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

        .success-message {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 12px 14px;
            color: #16a34a;
            font-size: 13px;
            margin-bottom: 15px;
            display: none;
        }

        .success-message.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            font-size: 12px;
            color: #64748b;
        }

        .divider::before,
        .divider::after {
            content: '';
            display: inline-block;
            width: 35%;
            height: 1px;
            background: #cbd5e1;
            vertical-align: middle;
        }

        .divider::before {
            margin-right: 10px;
        }

        .divider::after {
            margin-left: 10px;
        }

        .form-tabs {
            display: none;
        }

        .form-tabs.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .footer-text {
            text-align: center;
            font-size: 12px;
            color: #64748b;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .footer-text a {
            color: #10b981;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-text a:hover {
            color: #059669;
        }

        @media (max-width: 576px) {
            .form-section {
                padding: 40px 25px;
            }

            .brand-section {
                padding: 40px 25px;
            }

            .brand-title {
                font-size: 24px;
            }

            .brand-subtitle {
                font-size: 12px;
            }

            .tabs-container {
                margin-bottom: 25px;
            }

            .auth-card {
                min-height: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container-auth">
        <div class="auth-card">
            <!-- LEFT SIDE - BRAND -->
            <div class="brand-section">
                <div class="brand-logo">🌿</div>
                <h1 class="brand-title">Carbon Footprint Tracker</h1>
                <p class="brand-subtitle">Track your emissions and build a greener future</p>
                <div class="brand-icons">
                    <span>🌍</span>
                    <span>🌱</span>
                    <span>⚡</span>
                    <span>🚗</span>
                    <span>💧</span>
                </div>
            </div>

            <!-- RIGHT SIDE - FORMS -->
            <div class="form-section">
                <!-- TABS -->
                <div class="tabs-container">
    <button class="tab-btn active" data-tab="login" onclick="switchTab('login', this)">
        <i class="bi bi-box-arrow-in-right me-2"></i>Login
    </button>

    <button class="tab-btn" data-tab="register" onclick="switchTab('register', this)">
        <i class="bi bi-person-plus me-2"></i>Register
    </button>
</div>

                <!-- LOGIN FORM -->
                <div id="login-tab" class="form-tabs active">
                    <div class="error-message" id="login-error"></div>
                    <div class="success-message" id="login-success"></div>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="you@example.com" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="error-message show">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="••••••••" required>
                            @error('password')
                                <div class="error-message show">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                        </button>

                        <div class="form-text">
                            Don't have an account? <span class="toggle-form" onclick="switchTab('register')">Create one</span>
                        </div>
                    </form>
                </div>

                <!-- REGISTER FORM -->
                <div id="register-tab" class="form-tabs">
                    <div class="error-message" id="register-error"></div>
                    <div class="success-message" id="register-success"></div>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="John Doe" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="error-message show">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="register-email">Email Address</label>
                            <input type="email" id="register-email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="you@example.com" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="error-message show">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="register-password">Password</label>
                            <input type="password" id="register-password" name="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="••••••••" required>
                            @error('password')
                                <div class="error-message show">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                                placeholder="••••••••" required>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="bi bi-person-plus me-2"></i>Create Account
                        </button>

                        <div class="form-text">
                            Already have an account? <span class="toggle-form" onclick="switchTab('login')">Sign in</span>
                        </div>
                    </form>
                </div>

                <!-- FOOTER -->
                <div class="footer-text">
    © 2026 Carbon Tracker | MCA Project
    @auth
        | <a href="{{ route('dashboard') }}">Dashboard</a>
    @endauth
</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function switchTab(tab, button = null) {
            // Hide all tabs
            document.querySelectorAll('.form-tabs').forEach(el => {
                el.classList.remove('active');
            });

            // Deactivate all buttons
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('active');
            });

            // Show selected tab
            const tabElement = document.getElementById(tab + '-tab');
            if (tabElement) {
                tabElement.classList.add('active');
            }

            // Activate selected button
            if (!button) {
                button = document.querySelector(`.tab-btn[data-tab="${tab}"]`);
            }
            if (button) {
                button.classList.add('active');
            }
        }

        // Handle Laravel validation errors
        document.addEventListener('DOMContentLoaded', function() {
            const loginError = document.getElementById('login-error');
            const registerError = document.getElementById('register-error');
            const loginForm = document.querySelector('#login-tab form');
            const registerForm = document.querySelector('#register-tab form');

            // Check for Laravel errors and show appropriate tab
            const url = new URLSearchParams(window.location.search);
            
            @if ($errors->any())
                // Determine which tab to show based on errors
                const errorMessages = {!! json_encode($errors->all()) !!};
                if (errorMessages.length > 0) {
                    const hasNameError = errorMessages.some(msg => msg.toLowerCase().includes('name'));
                    const hasPasswordConfirmError = errorMessages.some(msg => msg.toLowerCase().includes('confirmation'));
                    
                    if (hasNameError || hasPasswordConfirmError) {
                        switchTab('register');
                    }
                }
            @endif
        });
    </script>
</body>
</html>