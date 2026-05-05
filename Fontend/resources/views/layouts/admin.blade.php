<!DOCTYPE html>
<html lang="vi" data-bs-theme="dark">

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
            --bg-dark: #0F0F1A;
            --sidebar-bg: #1A1A2E;
            --card-bg: rgba(255, 255, 255, 0.03);
            --border-color: rgba(255, 255, 255, 0.1);
            --text-main: #FFFFFF;
            --text-muted: #A0A0B0;
            --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-dark);
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
            padding: 24px;
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .nav-menu {
            padding: 20px 15px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            color: var(--text-muted);
            padding: 12px 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
        }

        .nav-link i {
            font-size: 1.2rem;
            transition: transform 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: white;
            background: rgba(255, 94, 0, 0.1);
        }

        .nav-link.active {
            background: var(--primary-color);
            box-shadow: 0 4px 15px rgba(255, 94, 0, 0.3);
        }

        .nav-link:hover i {
            transform: scale(1.1);
            color: var(--primary-color);
        }

        .nav-link.active i {
            color: white;
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
            height: 70px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .branch-selector select {
            background: var(--sidebar-bg);
            border: 1px solid var(--border-color);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-family: 'Outfit';
            outline: none;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-icon {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 1.3rem;
            position: relative;
            transition: color 0.3s;
        }

        .btn-icon:hover {
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -4px;
            background: #FF3366;
            color: white;
            font-size: 0.6rem;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 50%;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        /* --- CONTENT AREA --- */
        .content-area {
            padding: 30px;
            flex-grow: 1;
        }

        /* --- UI COMPONENTS --- */
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 24px;
            box-shadow: var(--glass-shadow);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.4);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <i class="bi bi-lightning-charge-fill text-primary" style="color: var(--primary-color) !important;"></i>
            GYMPRO
        </a>
        <div class="nav-menu">
            <div class="small text-uppercase text-muted fw-bold mb-2 ms-2"
                style="font-size: 0.75rem; letter-spacing: 1px;">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            @if(session('user_role') !== 'Super Admin')
                <a href="#" class="nav-link" onclick="alert('Tính năng Hội Viên đang được phát triển ở Phase tiếp theo!')">
                    <i class="bi bi-people"></i> Hội Viên
                </a>
                <a href="#" class="nav-link" onclick="alert('Tính năng Lịch Tập đang được phát triển!')">
                    <i class="bi bi-calendar2-week"></i> Lịch Tập
                </a>
            @endif

            @if(session('user_role') !== 'Super Admin')
                <div class="small text-uppercase text-muted fw-bold mb-2 ms-2 mt-4"
                    style="font-size: 0.75rem; letter-spacing: 1px;">Smart AI</div>
                <a href="#" class="nav-link" onclick="alert('Tính năng Phân Tích AI đang được phát triển!')">
                    <i class="bi bi-robot"></i> Phân Tích AI
                </a>
                <a href="#" class="nav-link d-flex justify-content-between align-items-center"
                    onclick="alert('Đang tải danh sách Cảnh báo Y tế...')">
                    <span><i class="bi bi-heart-pulse"></i> Cảnh Báo Y Tế</span>
                    <span class="badge bg-danger rounded-pill">3</span>
                </a>
            @endif

            <!-- SUPER ADMIN ONLY -->
            @if(session('user_role') == 'Super Admin')
                <div class="small text-uppercase fw-bold mb-2 ms-2 mt-4"
                    style="font-size: 0.75rem; letter-spacing: 1px; color: #ffc107;">
                    <i class="bi bi-star-fill me-1"></i> Super Admin Tối Cao
                </div>
                <a href="{{ route('admin.branches') }}"
                    class="nav-link {{ request()->routeIs('admin.branches') ? 'active' : '' }}"
                    style="{{ request()->routeIs('admin.branches') ? 'color: #1A1A2E; background: #ffc107;' : 'color: rgba(255,193,7,0.8);' }}"
                    onmouseover="if(!this.classList.contains('active')) this.style.color='#ffc107'"
                    onmouseout="if(!this.classList.contains('active')) this.style.color='rgba(255,193,7,0.8)'">
                    <i class="bi bi-building"></i> Quản lý Chi nhánh
                </a>
                <a href="{{ route('admin.managers') }}"
                    class="nav-link {{ request()->routeIs('admin.managers') ? 'active' : '' }}"
                    style="{{ request()->routeIs('admin.managers') ? 'color: #1A1A2E; background: #ffc107;' : 'color: rgba(255,193,7,0.8);' }}"
                    onmouseover="if(!this.classList.contains('active')) this.style.color='#ffc107'"
                    onmouseout="if(!this.classList.contains('active')) this.style.color='rgba(255,193,7,0.8)'">
                    <i class="bi bi-person-badge"></i> Quản lý Nhân sự
                </a>
                <a href="#" class="nav-link" style="color: rgba(255,193,7,0.8);"
                    onclick="alert('Quản lý danh mục máy móc mẫu (Equipment Catalog)')"
                    onmouseover="this.style.color='#ffc107'" onmouseout="this.style.color='rgba(255,193,7,0.8)'">
                    <i class="bi bi-bicycle"></i> Danh mục Thiết bị
                </a>
                <a href="#" class="nav-link" style="color: rgba(255,193,7,0.8);"
                    onclick="alert('Cấu hình hệ thống toàn cục (Global Config)')" onmouseover="this.style.color='#ffc107'"
                    onmouseout="this.style.color='rgba(255,193,7,0.8)'">
                    <i class="bi bi-sliders"></i> Cấu hình Hệ thống
                </a>
            @endif

            <div class="small text-uppercase text-muted fw-bold mb-2 ms-2 mt-4"
                style="font-size: 0.75rem; letter-spacing: 1px;">Management</div>
            <a href="#" class="nav-link" onclick="alert('Module Tài Chính đang khóa!')">
                <i class="bi bi-wallet2"></i> Tài Chính
            </a>
            <a href="#" class="nav-link" onclick="alert('Mở Cài Đặt...')">
                <i class="bi bi-gear"></i> Cài Đặt
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <div class="branch-selector">
                <select class="form-select-sm shadow-none" onchange="location.href='{{ route('admin.dashboard') }}?branch_id=' + this.value" style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; padding: 5px 10px; cursor: pointer;">
                    <option value="" class="text-dark">🌐 Toàn Hệ Thống</option>
                    @foreach($branches ?? [] as $b)
                        <option value="{{ $b['id'] }}" class="text-dark" {{ (request('branch_id') == $b['id']) ? 'selected' : '' }}>
                            📍 {{ $b['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="topbar-actions">
                <button class="btn-icon">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge">3</span>
                </button>
                <div class="user-profile dropdown">
                    <div class="d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=FF5E00&color=fff" alt="User"
                            class="user-avatar">
                        <div class="d-none d-md-block">
                            <div class="fw-bold" style="font-size: 0.9rem;">Nguyễn Văn Admin</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Super Admin</div>
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow-lg border-0 mt-2">
                        <li><a class="dropdown-item" href="#"
                                onclick="alert('Trang Quản lý Hồ sơ đang được cập nhật!')"><i
                                    class="bi bi-person me-2"></i> Hồ sơ</a></li>
                        <li><a class="dropdown-item" href="#"
                                onclick="alert('Tính năng Phân quyền chưa được mở khóa!')"><i
                                    class="bi bi-shield-lock me-2"></i> Phân quyền</a></li>
                        <li>
                            <hr class="dropdown-divider border-secondary">
                        </li>
                        <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i
                                    class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
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