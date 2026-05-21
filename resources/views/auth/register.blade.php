<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Inmate Food Management</title>
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
        .register-wrap {
            background: #fff;
            border-radius: 20px;
            padding: 48px 44px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .header { text-align: center; margin-bottom: 32px; }
        .header .icon { font-size: 48px; margin-bottom: 12px; }
        .header h2 {
            font-size: 26px;
            font-weight: 800;
            color: #1a2340;
            margin-bottom: 6px;
        }
        .header p { font-size: 13px; color: #9ca3af; }
        .form-group { margin-bottom: 18px; }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
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
        .btn-register {
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
            margin-top: 8px;
        }
        .btn-register:hover { background: #2d3f6b; transform: translateY(-1px); }
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #9ca3af;
        }
        .login-link a {
            color: #1a2340;
            font-weight: 700;
            text-decoration: none;
        }
        .login-link a:hover { text-decoration: underline; }
        .divider {
            border: none;
            border-top: 1px solid #f1f5f9;
            margin: 24px 0;
        }
        @media (max-width: 480px) {
            .register-wrap { padding: 32px 24px; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="register-wrap">
    <div class="header">
        <div class="icon">📝</div>
        <h2>Create Account</h2>
        <p>Register to access the Inmate Food Management System</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name"
                   value="{{ old('name') }}" required autofocus
                   placeholder="Enter your full name">
            @error('name')
                <div class="error-msg">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}" required
                   placeholder="Enter your email">
            @error('email')
                <div class="error-msg">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                       required placeholder="Create password">
                @error('password')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation"
                       name="password_confirmation" required
                       placeholder="Repeat password">
            </div>
        </div>

        <hr class="divider">

        <button type="submit" class="btn-register">✅ Create Account</button>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Sign in here</a>
        </div>
    </form>
</div>
</body>
</html>