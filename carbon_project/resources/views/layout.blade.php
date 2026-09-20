<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carbon Footprint System</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * { font-family: 'Inter', sans-serif; }

        body {
            margin: 0;
            min-height: 100vh;
            background: #eef2f6;
            background-image: radial-gradient(circle at top right, rgba(16,185,129,0.08), transparent 45%),
                               radial-gradient(circle at bottom left, rgba(245,158,11,0.06), transparent 40%);
            color: #1e293b;
        }

        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            background: linear-gradient(135deg, #059669, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-user {
            color: #64748b;
            font-size: 0.85rem;
        }

        .btn-nav-primary {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            padding: 7px 16px;
            transition: all 0.2s;
        }

        .btn-nav-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16,185,129,0.3);
            color: white;
        }

        .btn-nav-secondary {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #334155;
            border-radius: 10px;
            font-weight: 600;
            padding: 7px 16px;
            transition: all 0.2s;
        }

        .btn-nav-secondary:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .btn-nav-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 10px;
            font-weight: 600;
            padding: 7px 16px;
            transition: all 0.2s;
        }

        .btn-nav-danger:hover {
            background: #ef4444;
            border-color: #ef4444;
            color: white;
        }

        .main-content {
            padding: 30px 20px;
        }

        .glass-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(15,23,42,0.05);
        }

        .metric-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #10b981;
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .metric-card:nth-child(1) { border-left-color: #f43f5e; }
        .metric-card:nth-child(2) { border-left-color: #fb923c; }
        .metric-card:nth-child(3) { border-left-color: #facc15; }
        .metric-card:nth-child(4) { border-left-color: #f43f5e; }
        .metric-card:nth-child(5) { border-left-color: #34d399; }

        .metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(15,23,42,0.09);
        }

        .metric-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .metric-value {
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1;
        }

        .custom-table { color: #334155; }

        .custom-table thead th {
            background: linear-gradient(135deg, #ecfdf5, #f0fdf4);
            color: #059669;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
            padding: 14px 12px;
        }

        .custom-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.15s;
        }

        .custom-table tbody tr:hover { background: #f0fdf4; }

        .custom-table tbody td {
            border: none;
            padding: 14px 12px;
            vertical-align: middle;
        }

        .badge-high {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #dc2626;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-medium {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #b45309;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-low {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #047857;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .form-label {
            color: #475569;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control, .form-select {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #1e293b;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            background: #ffffff;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16,185,129,0.15);
            color: #1e293b;
        }

        .form-control::placeholder { color: #94a3b8; }

        textarea.form-control { resize: none; }

        .btn-submit {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            color: white;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            transition: all 0.2s;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 24px rgba(16,185,129,0.3);
            color: white;
        }

        .btn-edit {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #d97706;
            border-radius: 8px;
            padding: 5px 14px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-edit:hover { background: #fbbf24; color: white; }

        .btn-delete {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 8px;
            padding: 5px 14px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-delete:hover { background: #ef4444; color: white; }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #059669, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Auth background */
        .auth-bg {
            position: relative;
            background: url('https://images.unsplash.com/photo-1448375240586-882707db888b?w=1920&q=80') center center / cover no-repeat;
            overflow: hidden;
        }

        .auth-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(240, 249, 240, 0.55);
            pointer-events: none;
        }

        .auth-bg > .container {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg px-4 py-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">🌿 Carbon Tracker</a>
        <div class="d-flex gap-2 align-items-center">
            @auth
                <span class="nav-user">👤 {{ auth()->user()->name }}</span>
                <a href="/dashboard" class="btn btn-nav-secondary btn-sm">Dashboard</a>
                <a href="/add" class="btn btn-nav-primary btn-sm"><i class="bi bi-plus-lg"></i> Add</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-nav-danger btn-sm">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<div class="main-content container-fluid px-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>