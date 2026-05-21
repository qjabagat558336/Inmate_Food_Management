<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Inmate Food Management</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1a2340 0%, #2d3f6b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-wrap {
            display: flex;
            max-width: 900px;
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.35);
        }
        /* Left Panel */
        .left-panel {
            background: #1a2340;
            padding: 48px 40px;
            width: 42%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .left-panel .icon { font-size: 64px; margin-bottom: 20px; }
        .left-panel h2 {
            color: #f6ad1d;
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        .left-panel p { color: #a0aec0; font-size: 13px; line-height: 1.7; }
        .left-divider { width: 40px; height: 3px; background: #f6ad1d; border-radius: 2px; margin: 18px auto; }
        .info-list { list-style: none; text-align: left; margin-top: 20px; }
        .info-list li {
            color: #cbd5e0;
            font-size: 13px;
            padding: 6px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .info-list li span { font-size: 16px; }
        /* Right Panel */
        .right-panel {
            background: #fff;
            padding: 48px 40px;
            flex: 1;
        }
        .right-panel h3 {
            font-size: 24px;
            font-weight: 800;
            color: #1a2340;
            margin-bottom: 6px;
        }
        .right-panel .sub {
            font-size: 13px;
            color: #9ca3af;
            margin-bottom: 32px;
        }
        .form-group { margin-bottom: 20px; }
        label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            color: #1a2340;
            outline: none;
            transition: border-color .2s;
            background: #f9fafb;
        }
        input:focus { border-color: #2d3f6b; background: #fff; }
        .error-msg {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
        }
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #6b7280;
            cursor: pointer;
            text-transform: none;
            letter-spacing: 0;
            font-weight: 400;
        }
        .forgot-link {
            font-size: 13px;
            color: #2d3f6b;
            text-decoration: none;
            font-weight: 600;
        }
        .forgot-link:hover { text-decoration: underline; }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #1a2340;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background .2s, transform .15s;
        }
        .btn-login:hover { background: #2d3f6b; transform: translateY(-1px); }
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #9ca3af;
        }
        .register-link a {
            color: #1a2340;
            font-weight: 700;
            text-decoration: none;
        }
        .register-link a:hover { text-decoration: underline; }
        .alert-status {
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            color: #065f46;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        @media (max-width: 640px) {
            .login-wrap { flex-direction: column; }
            .left-panel { width: 100%; padding: 32px 24px; }
            .right-panel { padding: 32px 24px; }
        }
    </style>
</head>
<body>
<div class="login-wrap">
    {{-- Left Panel --}}
    <div class="left-panel">
        <div class="icon">🍽️</div>
        <h2>IFMS</h2>
        <div class="left-divider"></div>
        <p>Inmate Food Management System</p>
        <ul class="info-list">
            <li><span>📅</span> Daily Meal Scheduling</li>
            <li><span>🧺</span> Ingredient Tracking</li>
            <li><span>💰</span> Cost Monitoring</li>
            <li><span>👥</span> Inmate Serving Records</li>
        </ul>
    </div>

    {{-- Right Panel --}}
    <div class="right-panel">
        <h3>Welcome Back 👋</h3>
        <p class="sub">Sign in to access the food management dashboard.</p>

        @if (session('status'))
            <div class="alert-status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}" required autofocus
                       placeholder="Enter your email">
                @error('email')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                       required placeholder="Enter your password">
                @error('password')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember" id="remember_me">
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login">🔐 Sign In</button>

            @if (Route::has('register'))
                <div class="register-link">
                    Don't have an account? <a href="{{ route('register') }}">Register here</a>
                </div>
            @endif
        </form>
    </div>
</div>
</body>
</html>