<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro Admin | @yield('title', 'Dashboard')</title>
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-color: #FF5E00;
            --secondary-color: #E65500;
            --bg-light: #F4F6F9;
            --sidebar-bg: #FFFFFF;
            --card-bg: #FFFFFF;
            --border-color: #E2E8F0;
            --text-main: #1E293B;
            --text-muted: #64748B;
            --glass-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
            margin: 0;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 200px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-brand {
            padding: 18px 16px;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: -0.5px;
        }

        .nav-menu {
            padding: 10px 16px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .nav-item {
            margin-bottom: 4px;
        }

        .nav-link {
            color: var(--text-muted);
            padding: 10px 14px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .nav-link i {
            font-size: 1.15rem;
            color: var(--text-muted);
        }

        .nav-link:hover {
            color: var(--primary-color);
            background: rgba(255, 94, 0, 0.06);
            border-left: 2px solid var(--primary-color);
        }

        .nav-link.active {
            color: var(--primary-color);
            background: rgba(255, 94, 0, 0.08);
            border-left: 2px solid var(--primary-color);
            font-weight: 700;
        }

        .nav-link.active i {
            color: var(--primary-color);
        }

        /* --- MAIN CONTENT --- */
        .main-wrapper {
            flex-grow: 1;
            margin-left: 200px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- TOPBAR --- */
        .topbar {
            height: 56px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .branch-selector select {
            background: #F8FAFC;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 6px 14px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            outline: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        .branch-selector select:focus {
            border-color: var(--primary-color);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-icon {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 1.1rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 4px;
            transition: all 0.2s;
            border: 1px solid var(--border-color);
        }

        .btn-icon:hover {
            background: #F8FAFC;
            color: var(--text-main);
            border-color: #CBD5E1;
        }

        .notification-badge {
            position: absolute;
            top: 6px;
            right: 8px;
            background: var(--primary-color);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            box-shadow: 0 0 6px rgba(255, 94, 0, 0.4);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 12px;
            border-radius: 4px;
            border: 1px solid var(--border-color);
            background: #F8FAFC;
            transition: all 0.2s;
            cursor: pointer;
        }

        .user-profile:hover {
            background: #F1F5F9;
            border-color: #CBD5E1;
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 4px;
            object-fit: cover;
        }

        /* --- CONTENT AREA --- */
        .content-area {
            padding: 24px;
            flex-grow: 1;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
        .dropdown-menu {
            background-color: #FFFFFF !important;
            z-index: 2000 !important;
            border: 1px solid var(--border-color) !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
            border-radius: 4px !important;
        }
        .dropdown-item {
            color: var(--text-main) !important;
            transition: all 0.2s;
            font-size: 0.8rem;
        }
        .dropdown-item:hover {
            background-color: rgba(255, 94, 0, 0.08) !important;
            color: var(--primary-color) !important;
        }

        .dropdown-item:active {
            background-color: var(--primary-color) !important;
            color: white !important;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="/" class="sidebar-brand">
            <i class="bi bi-lightning-charge-fill" style="color: var(--primary-color);"></i>
            <span>GYMPRO</span>
        </a>
        <div class="nav-menu">
            <div class="small text-uppercase text-dim fw-bold mb-2 ms-2"
                style="font-size: 0.7rem; letter-spacing: 1px;">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            <!-- SUPER ADMIN ONLY (System Level) -->
            @if(session('user_role') == 'Super Admin')
                <div class="small text-uppercase text-dim fw-bold mb-2 ms-2 mt-4"
                    style="font-size: 0.7rem; letter-spacing: 1px;">
                    System Admin
                </div>
                <a href="{{ route('admin.branches') }}"
                    class="nav-link {{ request()->routeIs('admin.branches') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> Chi nhánh
                </a>
                <a href="{{ route('admin.managers') }}"
                    class="nav-link {{ request()->routeIs('admin.managers') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i> Quản lý
                </a>
            @endif

            <!-- OPERATIONAL ROLES (Super Admin, Branch Admin, Staff/PT) -->
            @if(in_array(session('user_role'), ['Super Admin', 'Branch Admin', 'Staff/PT']))
                <div class="small text-uppercase text-dim fw-bold mb-2 ms-2 mt-4"
                    style="font-size: 0.7rem; letter-spacing: 1px;">
                    Vận Hành Phòng Tập
                </div>
                <a href="{{ route('admin.equipments') }}"
                    class="nav-link {{ request()->routeIs('admin.equipments*') ? 'active' : '' }}">
                    <i class="bi bi-bicycle"></i> Thiết bị
                </a>
                <a href="{{ route('admin.members') }}"
                    class="nav-link {{ request()->routeIs('admin.members*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Hội viên
                </a>
                <a href="{{ route('admin.packages') }}"
                    class="nav-link {{ request()->routeIs('admin.packages*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> Gói Tập & Doanh Thu
                </a>
            @endif
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <div class="branch-selector">
            <select class="shadow-none" data-url="{{ route('admin.dashboard') }}" onchange="location.href=this.dataset.url + '?branch_id=' + this.value">
                <option value="">🌐 Toàn Hệ Thống</option>
                @foreach($branches ?? [] as $branch)
                    @php
                        $bId = data_get($branch, 'id') ?? data_get($branch, 'Id');
                        $bName = data_get($branch, 'name') ?? data_get($branch, 'Name');
                    @endphp
                    <option value="{{ $bId }}" {{ request('branch_id') == $bId ? 'selected' : '' }}>📍 {{ $bName }}</option>
                @endforeach
            </select>
            </div>

            <div class="topbar-actions">
                <button class="btn-icon">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge"></span>
                </button>
        <div class="user-profile dropdown">
                    <div class="d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                        @php
                            $avatarUrl = session('user_avatar') ?? ('https://ui-avatars.com/api/?name=' . urlencode(session('user_name')) . '&background=FF5E00&color=fff');
                            if (str_starts_with($avatarUrl, '/') && !str_starts_with($avatarUrl, '//')) {
                                $avatarUrl = config('services.backend.url_base') . $avatarUrl;
                            }
                        @endphp
                        <img src="{{ $avatarUrl }}" alt="User" class="user-avatar">
                        <div class="d-none d-md-block">
                            <div class="fw-bold" style="font-size: 0.8rem;">{{ session('user_name') }}</div>
                            <div class="text-dim" style="font-size: 0.7rem;">{{ session('user_role') }}</div>
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 py-2" style="font-size: 0.9rem; min-width: 180px;">
                        <li><a class="dropdown-item py-2" href="{{ route('admin.profile') }}"><i class="bi bi-person me-2"></i> Hồ sơ cá nhân</a></li>
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <li><a class="dropdown-item text-danger py-2" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>