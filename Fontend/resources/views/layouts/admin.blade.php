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
            --bg-light: #F8F9FA;
            --sidebar-bg: #FFFFFF;
            --card-bg: #FFFFFF;
            --border-color: #E2E8F0;
            --text-main: #1A1D23;
            --text-muted: #64748B;
            --glass-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
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
            width: 260px;
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
            padding: 20px 16px;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
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
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .nav-link i {
            font-size: 1.1rem;
            color: var(--text-muted);
        }

        .nav-link:hover {
            color: var(--primary-color);
            background: #FFF7ED;
        }

        .nav-link.active {
            color: var(--primary-color);
            background: #FFF7ED;
            font-weight: 700;
        }

        .nav-link.active i {
            color: var(--primary-color);
        }

        /* --- MAIN CONTENT --- */
        .main-wrapper {
            flex-grow: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- TOPBAR --- */
        .topbar {
            height: 64px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
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
            background: #F1F5F9;
            border: none;
            color: var(--text-main);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            outline: none;
            cursor: pointer;
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
            font-size: 1.2rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-icon:hover {
            background: #F1F5F9;
            color: var(--text-main);
        }

        .notification-badge {
            position: absolute;
            top: 6px;
            right: 8px;
            background: #EF4444;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 8px;
            border-radius: 10px;
            transition: background 0.2s;
            cursor: pointer;
        }

        .user-profile:hover {
            background: #F1F5F9;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
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

            <!-- SUPER ADMIN ONLY -->
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
                <a href="#" class="nav-link" onclick="alert('Phát triển ở Phase sau!')">
                    <i class="bi bi-bicycle"></i> Thiết bị
                </a>
            @endif

            <div class="small text-uppercase text-dim fw-bold mb-2 ms-2 mt-4"
                style="font-size: 0.7rem; letter-spacing: 1px;">Management</div>
            <a href="#" class="nav-link" onclick="alert('Đang khóa!')">
                <i class="bi bi-wallet2"></i> Tài Chính
            </a>
            <a href="#" class="nav-link" onclick="alert('Cài Đặt...')">
                <i class="bi bi-gear"></i> Cài Đặt
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <div class="branch-selector">
                <select class="shadow-none" onchange="location.href='{{ route('admin.dashboard') }}?branch_id=' + this.value">
                    <option value="">🌐 Toàn Hệ Thống</option>
                    @foreach($branches ?? [] as $b)
                        <option value="{{ $b['id'] }}" {{ (request('branch_id') == $b['id']) ? 'selected' : '' }}>
                            📍 {{ $b['name'] }}
                        </option>
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
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 py-2" style="font-size: 0.9rem;">
                        <li><a class="dropdown-item py-2" href="{{ route('admin.profile') }}"><i class="bi bi-person me-2"></i> Hồ sơ</a></li>
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