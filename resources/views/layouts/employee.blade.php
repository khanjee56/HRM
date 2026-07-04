<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRM System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { margin: 0; background: #f4f6f9; }

        .sidebar {
            width: 260px;
            height: 100vh;
            background: #0f3460;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-brand { padding: 20px; border-bottom: 1px solid #ffffff20; }
        .sidebar-brand h4 { color: white; margin: 0; font-weight: bold; }
        .sidebar-brand p { color: #aaa; margin: 0; font-size: 12px; }

        .sidebar-menu { padding: 15px 0; }

        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: #ccc;
            text-decoration: none;
            transition: 0.2s;
            font-size: 14px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #16213e;
            color: white;
            border-left: 3px solid #e94560;
        }

        .sidebar-menu a i { width: 20px; margin-right: 10px; }
        .sidebar-section { padding: 10px 20px 5px; color: #666; font-size: 11px; text-transform: uppercase; }
        .sidebar-divider { border-color: #ffffff20; margin: 10px 20px; }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .topbar {
            background: white;
            padding: 15px 25px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar h5 { margin: 0; color: #333; }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: #333;
            cursor: pointer;
            margin-right: 15px;
        }

        .content-area { padding: 25px; }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-260px); }
            .sidebar.active { transform: translateX(0); }
            .sidebar-overlay.active { display: block; }
            .main-content { margin-left: 0 !important; }
            .sidebar-toggle { display: block; }
            .content-area { padding: 15px; }
            .topbar { padding: 12px 15px; }
            .topbar h5 { font-size: 14px; }
        }

        @media (max-width: 1024px) and (min-width: 769px) {
            .sidebar { width: 220px; }
            .main-content { margin-left: 220px; }
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h4>👔 HRM System</h4>
        <p>{{ auth()->user()->name }}</p>
    </div>

    <div class="sidebar-menu">
        <span class="sidebar-section">Main</span>
        <a href="/employee/dashboard" class="{{ request()->is('employee/dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> My Dashboard
        </a>

        <hr class="sidebar-divider">
        <span class="sidebar-section">My Info</span>

        <a href="/employee/profile" class="{{ request()->is('employee/profile*') ? 'active' : '' }}">
            <i class="fas fa-user"></i> My Profile
        </a>

        <hr class="sidebar-divider">
        <span class="sidebar-section">Attendance & Leave</span>

        <a href="/employee/attendance" class="{{ request()->is('employee/attendance*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i> My Attendance
        </a>

        <a href="/employee/leaves" class="{{ request()->is('employee/leaves*') ? 'active' : '' }}">
            <i class="fas fa-umbrella-beach"></i> My Leaves
        </a>

        <a href="/employee/leaves/apply" class="{{ request()->is('employee/leaves/apply') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> Apply Leave
        </a>

        <hr class="sidebar-divider">
        <span class="sidebar-section">Payroll</span>

        <a href="/employee/payslips" class="{{ request()->is('employee/payslips*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice-dollar"></i> My Payslips
        </a>

        <hr class="sidebar-divider">

        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn w-100 text-start"
                    style="color:#ccc; padding:12px 20px; background:none; border:none;">
                <i class="fas fa-sign-out-alt" style="width:20px; margin-right:10px;"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="main-content" id="mainContent">
    <div class="topbar">
        <div class="d-flex align-items-center">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h5>@yield('page-title', 'Dashboard')</h5>
        </div>
        <div style="color:#666; font-size:14px;">
            <i class="fas fa-user-circle"></i>
            <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    document.querySelectorAll('.sidebar-menu a').forEach(link => {
        link.addEventListener('click', () => {
            if(window.innerWidth <= 768) {
                toggleSidebar();
            }
        });
    });
</script>

@stack('scripts')

</body>
</html>