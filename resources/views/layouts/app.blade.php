<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inmate Food Management') — BJMP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:     #0B1D33;
            --navy-mid: #142947;
            --navy-lt:  #1E3A5F;
            --gold:     #C8952A;
            --gold-lt:  #E4AD42;
            --cream:    #F5F0E8;
            --cream-dk: #EDE6D6;
            --steel:    #8BA4BF;
            --danger:   #C0392B;
            --success:  #1A7A4A;
            --text:     #1C2B3A;
            --muted:    #6B8299;
            --sidebar-w: 240px;
        }

        html, body { height: 100%; font-family: 'DM Sans', sans-serif; background: var(--cream); color: var(--text); }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed; inset: 0 auto 0 0;
            width: var(--sidebar-w);
            background: var(--navy);
            display: flex; flex-direction: column;
            z-index: 100;
            border-right: 3px solid var(--gold);
        }
        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(200,149,42,.25);
        }
        .sidebar-brand .emblem {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 13px; letter-spacing: 3px;
            color: var(--gold); display: block; margin-bottom: 2px;
        }
        .sidebar-brand h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 22px; letter-spacing: 1px;
            color: #fff; line-height: 1.1;
        }
        .sidebar-brand p { font-size: 11px; color: var(--steel); margin-top: 4px; letter-spacing: .5px; }

        .sidebar-nav { flex: 1; padding: 20px 0; }
        .nav-label {
            font-family: 'DM Mono', monospace;
            font-size: 10px; letter-spacing: 2px; text-transform: uppercase;
            color: var(--steel); padding: 0 24px 8px; margin-top: 12px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 24px; color: var(--steel);
            text-decoration: none; font-size: 14px; font-weight: 500;
            transition: all .2s; position: relative;
        }
        .nav-item:hover { color: #fff; background: rgba(255,255,255,.05); }
        .nav-item.active {
            color: var(--gold);
            background: rgba(200,149,42,.1);
        }
        .nav-item.active::before {
            content: ''; position: absolute; left: 0; top: 50%;
            transform: translateY(-50%); width: 3px; height: 60%;
            background: var(--gold); border-radius: 0 2px 2px 0;
        }
        .nav-item i { width: 18px; text-align: center; font-size: 15px; }

        .sidebar-footer {
            padding: 20px 24px;
            border-top: 1px solid rgba(200,149,42,.15);
            font-size: 12px; color: var(--steel);
        }
        .sidebar-footer span { display: block; font-family: 'DM Mono', monospace; font-size: 10px; letter-spacing: 1px; }

        /* ── MAIN ── */
        .main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }

        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--cream-dk);
            padding: 16px 36px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }
        .topbar-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 26px; letter-spacing: 1px; color: var(--navy);
        }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-date {
            font-family: 'DM Mono', monospace;
            font-size: 12px; color: var(--muted);
            background: var(--cream); padding: 6px 12px;
            border-radius: 6px; border: 1px solid var(--cream-dk);
        }
        .topbar-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--navy); color: var(--gold);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px;
            border: 2px solid var(--gold);
        }

        .content { flex: 1; padding: 36px; }

        /* ── ALERTS ── */
        .alert {
            padding: 14px 18px; border-radius: 8px; margin-bottom: 24px;
            font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px;
        }
        .alert-success { background: #d4edda; color: #155724; border-left: 4px solid var(--success); }
        .alert-danger  { background: #f8d7da; color: #721c24; border-left: 4px solid var(--danger); }

        /* ── CARDS ── */
        .card {
            background: #fff; border-radius: 12px;
            border: 1px solid var(--cream-dk);
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
            overflow: hidden;
        }
        .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--cream-dk);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-header h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 20px; letter-spacing: .5px; color: var(--navy);
        }
        .card-body { padding: 24px; }

        /* ── STAT CARDS ── */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 32px; }
        .stat-card {
            background: #fff; border-radius: 12px;
            border: 1px solid var(--cream-dk);
            padding: 24px; position: relative; overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.1); }
        .stat-card::after {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        }
        .stat-card.gold::after  { background: var(--gold); }
        .stat-card.navy::after  { background: var(--navy); }
        .stat-card.steel::after { background: var(--steel); }

        .stat-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; margin-bottom: 16px;
        }
        .stat-icon.gold  { background: rgba(200,149,42,.12); color: var(--gold); }
        .stat-icon.navy  { background: rgba(11,29,51,.1);    color: var(--navy); }
        .stat-icon.steel { background: rgba(139,164,191,.15); color: var(--steel); }

        .stat-value { font-family: 'Bebas Neue', sans-serif; font-size: 42px; line-height: 1; color: var(--navy); }
        .stat-label { font-size: 13px; color: var(--muted); margin-top: 4px; font-weight: 500; }

        /* ── TABLE ── */
        table { width: 100%; border-collapse: collapse; }
        thead th {
            background: var(--navy); color: var(--cream);
            padding: 12px 16px; font-size: 12px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 1px; text-align: left;
        }
        thead th:first-child { border-radius: 8px 0 0 0; }
        thead th:last-child  { border-radius: 0 8px 0 0; }
        tbody tr { border-bottom: 1px solid var(--cream-dk); transition: background .15s; }
        tbody tr:hover { background: var(--cream); }
        tbody td { padding: 12px 16px; font-size: 14px; }
        tbody tr:last-child { border-bottom: none; }

        /* ── BADGE ── */
        .badge {
            display: inline-block; padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600; letter-spacing: .5px;
        }
        .badge-gold  { background: rgba(200,149,42,.15); color: #9a7020; }
        .badge-navy  { background: rgba(11,29,51,.1);    color: var(--navy); }
        .badge-steel { background: rgba(139,164,191,.2); color: #4a6b88; }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: 7px; font-size: 14px; font-weight: 500;
            cursor: pointer; border: none; text-decoration: none; transition: all .2s;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-primary   { background: var(--navy); color: var(--gold); }
        .btn-primary:hover { background: var(--navy-lt); }
        .btn-gold      { background: var(--gold); color: #fff; }
        .btn-gold:hover { background: var(--gold-lt); }
        .btn-danger    { background: var(--danger); color: #fff; }
        .btn-danger:hover { opacity: .85; }
        .btn-outline   { background: transparent; color: var(--navy); border: 1.5px solid var(--navy); }
        .btn-outline:hover { background: var(--navy); color: #fff; }
        .btn-sm        { padding: 5px 12px; font-size: 12px; }
        .btn-icon      { padding: 7px 10px; }

        /* ── FORMS ── */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 6px; letter-spacing: .3px; }
        .form-control {
            width: 100%; padding: 10px 14px;
            border: 1.5px solid var(--cream-dk); border-radius: 7px;
            font-size: 14px; font-family: 'DM Sans', sans-serif; color: var(--text);
            background: #fff; transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .form-control:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(200,149,42,.12); }
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
        .form-hint { font-size: 12px; color: var(--muted); margin-top: 4px; }
        .invalid-feedback { font-size: 12px; color: var(--danger); margin-top: 4px; }
        .is-invalid { border-color: var(--danger) !important; }

        /* ── SCHEDULE GRID ── */
        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 12px; margin-top: 8px;
        }
        .schedule-day {
            background: var(--cream); border-radius: 10px;
            border: 1.5px solid var(--cream-dk);
            overflow: hidden; min-height: 130px;
        }
        .schedule-day-header {
            background: var(--navy); color: var(--gold);
            padding: 8px 10px; text-align: center;
            font-family: 'Bebas Neue', sans-serif; font-size: 15px; letter-spacing: 1px;
        }
        .schedule-day-body { padding: 8px; }
        .schedule-meal-item {
            background: #fff; border-radius: 6px; padding: 6px 8px;
            margin-bottom: 6px; border-left: 3px solid var(--gold);
            font-size: 12px;
        }
        .schedule-meal-item strong { display: block; color: var(--navy); font-size: 12px; }
        .schedule-meal-item span  { color: var(--muted); font-size: 11px; }
        .schedule-meal-actions { display: flex; gap: 4px; margin-top: 4px; }
        .schedule-empty { text-align: center; color: var(--muted); font-size: 12px; padding: 18px 8px; }

        /* ── INGREDIENT GROUPS ── */
        .ingredient-group {
            background: #ffffff; border-radius: 10px;
            border: 1px solid var(--cream-dk); margin-bottom: 16px;
            overflow: hidden;
        }
        .ingredient-group-header {
            background: var(--navy); color: var(--cream);
            padding: 12px 18px; display: flex; align-items: center; gap: 10px;
        }
        .ingredient-group-header h4 { font-family: 'Bebas Neue', sans-serif; font-size: 18px; letter-spacing: .5px; }
        .ingredient-group-body { padding: 0; }
        .ingredient-row {
            display: grid; grid-template-columns: 1fr auto auto;
            align-items: center; padding: 10px 18px;
            border-bottom: 1px solid var(--cream-dk); gap: 16px;
        }
        .ingredient-row:last-child { border-bottom: none; }
        .ingredient-name { font-size: 14px; font-weight: 500; }
        .ingredient-price {
            font-family: 'DM Mono', monospace; font-size: 13px;
            color: var(--success); font-weight: 600;
        }

        /* ── MISC ── */
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; }
        .page-header h2 { font-family: 'Bebas Neue', sans-serif; font-size: 32px; letter-spacing: .5px; color: var(--navy); }
        .section-title { font-family: 'Bebas Neue', sans-serif; font-size: 20px; letter-spacing: .5px; color: var(--navy); margin-bottom: 14px; }
        .text-muted { color: var(--muted); }
        .mt-4 { margin-top: 16px; }
        .mt-6 { margin-top: 24px; }
        .mt-8 { margin-top: 32px; }
        .d-flex { display: flex; }
        .gap-2 { gap: 8px; }
        .align-center { align-items: center; }

        /* action icon btns */
        .action-btn {
            width: 30px; height: 30px; border-radius: 6px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 13px; border: none; cursor: pointer; transition: all .15s;
            text-decoration: none;
        }
        .action-btn.edit   { background: rgba(11,29,51,.1);  color: var(--navy); }
        .action-btn.edit:hover   { background: var(--navy);  color: #fff; }
        .action-btn.delete { background: rgba(192,57,43,.1); color: var(--danger); }
        .action-btn.delete:hover { background: var(--danger); color: #fff; }

        /* modal */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.5); z-index: 999;
            align-items: center; justify-content: center;
        }
        .modal-overlay.open { display: flex; }
        .modal-box {
            background: #fff; border-radius: 14px; width: 480px; max-width: 95vw;
            box-shadow: 0 20px 60px rgba(0,0,0,.25); overflow: hidden;
        }
        .modal-header {
            background: var(--navy); color: var(--gold);
            padding: 18px 24px; display: flex; align-items: center; justify-content: space-between;
        }
        .modal-header h4 { font-family: 'Bebas Neue', sans-serif; font-size: 20px; letter-spacing: .5px; }
        .modal-close { background: none; border: none; color: var(--steel); font-size: 20px; cursor: pointer; }
        .modal-close:hover { color: #fff; }
        .modal-body { padding: 24px; }
        .modal-footer { padding: 16px 24px; border-top: 1px solid var(--cream-dk); display: flex; justify-content: flex-end; gap: 10px; }

        @media (max-width: 1200px) {
            .schedule-grid { grid-template-columns: repeat(4, 1fr); }
        }
        @media (max-width: 900px) {
            .sidebar { width: 64px; }
            .sidebar-brand h1, .sidebar-brand p, .sidebar-brand .emblem,
            .nav-item span, .nav-label { display: none; }
            .main { margin-left: 64px; }
            .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; }
        }
    </style>
    
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <span class="emblem">⚖ BJMP</span>
        <h1>Inmate Food<br>Management</h1>
        <p>Bureau of Jail Mgmt</p>
    </div>
    <nav class="sidebar-nav">
        <p class="nav-label">Main</p>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> <span>Dashboard</span>
        </a>
        <a href="{{ route('meals.create') }}" class="nav-item {{ request()->routeIs('meals.create') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> <span>Add Meal</span>
        </a>
        <a href="{{ route('meals.index') }}" class="nav-item {{ request()->routeIs('meals.index') ? 'active' : '' }}">
            <i class="fas fa-utensils"></i> <span>Meal Records</span>
        </a>
        <a href="{{ route('ingredients.index') }}" class="nav-item {{ request()->routeIs('ingredients.index') ? 'active' : '' }}">
            <i class="fas fa-carrot"></i> <span>Ingredients</span>
        </a>
        <p class="nav-label">Account</p>
        <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i> <span>Profile</span>
        </a>

        {{-- Logout — uses GET as defined in routes/web.php --}}
        <a href="{{ route('logout') }}" class="nav-item"
           onmouseover="this.style.color='#e74c3c'; this.style.background='rgba(192,57,43,0.1)'"
           onmouseout="this.style.color=''; this.style.background=''">
            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <span>v1.0.0 · IFMS</span>
        Secure System
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <div class="topbar-title">@yield('title', 'Dashboard')</div>
        <div class="topbar-right">
            <div class="topbar-date" id="live-date"></div>
            <div class="topbar-avatar">AD</div>
        </div>
    </header>

    <main class="content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

<script>
function updateDate() {
    const now = new Date();
    document.getElementById('live-date').textContent =
        now.toLocaleDateString('en-PH', { weekday:'short', year:'numeric', month:'short', day:'numeric' }) +
        ' · ' + now.toLocaleTimeString('en-PH', { hour:'2-digit', minute:'2-digit' });
}
updateDate(); setInterval(updateDate, 10000);

function confirmDelete(form) {
    if (confirm('Are you sure you want to delete this record? This action cannot be undone.')) {
        form.submit();
    }
}
</script>
@stack('scripts')
</body>
</html>