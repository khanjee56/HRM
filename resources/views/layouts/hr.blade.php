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

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #1a1a2e;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid #ffffff20;
        }

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
            border-left: 3px solid #0f3460;
        }

        .sidebar-menu a i { width: 20px; margin-right: 10px; }
        .sidebar-section { padding: 10px 20px 5px; color: #666; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
        .sidebar-divider { border-color: #ffffff20; margin: 10px 20px; }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* ===== TOP BAR ===== */
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
        .topbar .user-info { color: #666; font-size: 14px; }

        /* Hamburger button - hidden on desktop */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: #333;
            cursor: pointer;
            margin-right: 15px;
        }

        /* ===== CONTENT AREA ===== */
        .content-area { padding: 25px; }

        /* Stat Cards */
        .stat-card { border: none; border-radius: 10px; padding: 20px; color: white; }

        /* ===== OVERLAY (mobile) ===== */
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

        /* ===== MOBILE STYLES ===== */
        @media (max-width: 768px) {

            /* Hide sidebar by default on mobile */
            .sidebar {
                transform: translateX(-260px);
            }

            /* Show sidebar when active */
            .sidebar.active {
                transform: translateX(0);
            }

            /* Show overlay when sidebar active */
            .sidebar-overlay.active {
                display: block;
            }

            /* Main content takes full width */
            .main-content {
                margin-left: 0 !important;
            }

            /* Show hamburger button */
            .sidebar-toggle {
                display: block;
            }

            /* Smaller content padding */
            .content-area {
                padding: 15px;
            }

            /* Make tables scrollable */
            .table-responsive-mobile {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            /* Stack cards on mobile */
            .stat-card {
                margin-bottom: 15px;
            }

            /* Smaller topbar */
            .topbar {
                padding: 12px 15px;
            }

            .topbar h5 {
                font-size: 14px;
            }

            .user-info {
                font-size: 12px !important;
            }
        }

        /* ===== TABLET STYLES ===== */
        @media (max-width: 1024px) and (min-width: 769px) {
            .sidebar { width: 220px; }
            .main-content { margin-left: 220px; }
        }
    </style>
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h4>👔 HRM System</h4>
        <p>{{ auth()->user()->role == 'superadmin' ? 'Super Admin' : 'HR Manager' }}</p>
    </div>

    <div class="sidebar-menu">
        <span class="sidebar-section">Main</span>
        <a href="/hr/dashboard" class="{{ request()->is('hr/dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>

        <hr class="sidebar-divider">
        <span class="sidebar-section">Organization</span>

        <a href="/hr/departments" class="{{ request()->is('hr/departments*') ? 'active' : '' }}">
            <i class="fas fa-building"></i> Departments
        </a>

        <a href="/hr/designations" class="{{ request()->is('hr/designations*') ? 'active' : '' }}">
            <i class="fas fa-briefcase"></i> Designations
        </a>

        <hr class="sidebar-divider">
        <span class="sidebar-section">Employees</span>

        <a href="/hr/employees" class="{{ request()->is('hr/employees*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> All Employees
        </a>

        <a href="/hr/employees/create" class="{{ request()->is('hr/employees/create') ? 'active' : '' }}">
            <i class="fas fa-user-plus"></i> Add Employee
        </a>

        <hr class="sidebar-divider">
        <span class="sidebar-section">Attendance & Leave</span>

        <a href="/hr/attendance" class="{{ request()->is('hr/attendance*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i> Attendance
        </a>

        <a href="/hr/leaves" class="{{ request()->is('hr/leaves*') ? 'active' : '' }}">
            <i class="fas fa-umbrella-beach"></i> Leave Requests
        </a>

        <a href="/hr/leave-types" class="{{ request()->is('hr/leave-types*') ? 'active' : '' }}">
            <i class="fas fa-list"></i> Leave Types
        </a>

        <hr class="sidebar-divider">
        <span class="sidebar-section">Payroll</span>

        <a href="/hr/payroll" class="{{ request()->is('hr/payroll*') ? 'active' : '' }}">
            <i class="fas fa-money-bill-wave"></i> Payroll
        </a>

        <a href="/hr/salaries" class="{{ request()->is('hr/salaries*') ? 'active' : '' }}">
            <i class="fas fa-dollar-sign"></i> Salary Structure
        </a>

        <hr class="sidebar-divider">
        <span class="sidebar-section">Reports</span>

        <a href="/hr/reports" class="{{ request()->is('hr/reports*') ? 'active' : '' }}">
            <i class="fas fa-file-excel"></i> Reports & Exports
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

<!-- Main Content -->
<div class="main-content" id="mainContent">

    <!-- Top Bar -->
    <div class="topbar">
        <div class="d-flex align-items-center">
            <!-- Hamburger Button (mobile only) -->
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h5>@yield('page-title', 'Dashboard')</h5>
        </div>
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <!-- Content -->
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

    // Close sidebar when clicking a link on mobile
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