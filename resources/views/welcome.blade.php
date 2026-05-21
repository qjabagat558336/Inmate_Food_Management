<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inmate Food Management System</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1a2340 0%, #2d3f6b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .welcome-card {
            background: #fff;
            border-radius: 20px;
            padding: 56px 48px;
            text-align: center;
            max-width: 520px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .logo-icon {
            font-size: 64px;
            margin-bottom: 16px;
        }
        .system-badge {
            display: inline-block;
            background: #f0f4ff;
            color: #2d3f6b;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 20px;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 30px;
            font-weight: 800;
            color: #1a2340;
            margin-bottom: 12px;
            line-height: 1.2;
        }
        .subtitle {
            font-size: 15px;
            color: #6b7280;
            margin-bottom: 36px;
            line-height: 1.6;
        }
        .btn-group {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 36px;
        }
        .btn {
            padding: 13px 32px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform .2s, box-shadow .2s;
            border: none;
            cursor: pointer;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
        .btn-primary {
            background: #1a2340;
            color: #fff;
        }
        .btn-outline {
            background: #fff;
            color: #1a2340;
            border: 2px solid #1a2340;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            border-top: 1px solid #f1f5f9;
            padding-top: 28px;
        }
        .feature-item {
            text-align: center;
        }
        .feature-icon { font-size: 28px; margin-bottom: 6px; }
        .feature-label {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }
        .divider hr { flex: 1; border: none; border-top: 1px solid #e5e7eb; }
        .divider span { font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
<div class="welcome-card">
    <div class="logo-icon">🍽️</div>
    <div class="system-badge">Correctional Facility</div>
    <h1>Inmate Food Management System</h1>
    <p class="subtitle">
        Efficiently manage daily meal schedules, track ingredient costs,
        and monitor food expenses for inmates.
    </p>

    <div class="btn-group">
        @if (Route::has('login'))
            <a href="{{ route('login') }}" class="btn btn-primary">🔐 Login to System</a>
        @endif
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-outline">📝 Register</a>
        @endif
    </div>

    <div class="divider">
        <hr><span>System Features</span><hr>
    </div>

    <div class="features">
        <div class="feature-item">
            <div class="feature-icon">📅</div>
            <div class="feature-label">Meal Schedule</div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">🧺</div>
            <div class="feature-label">Ingredients</div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">💰</div>
            <div class="feature-label">Cost Tracking</div>
        </div>
    </div>
</div>
</body>
</html>