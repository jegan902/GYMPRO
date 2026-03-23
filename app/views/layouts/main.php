<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= APP_NAME ?> - Hệ thống quản lý phòng gym thông minh">
    <title><?= $title ?? APP_NAME ?> | <?= APP_NAME ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= URL_ROOT ?>/css/style.css">
</head>
<body class="app-body">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?= URL_ROOT ?>" class="sidebar-brand">
                <i class="bi bi-lightning-charge-fill"></i>
                <span>GYM<strong>PRO</strong></span>
            </a>
            <button class="sidebar-close d-lg-none" id="sidebarClose">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <span class="nav-section-title">TỔNG QUAN</span>
                <a href="<?= URL_ROOT ?>/dashboard" class="nav-link-item <?= ($title ?? '') === 'Dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
                <?php if (Session::userRole() === 'member'): ?>
                <a href="<?= URL_ROOT ?>/package" class="nav-link-item <?= ($title ?? '') === 'Gói tập' ? 'active' : '' ?>">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Gói tập</span>
                </a>
                <?php endif; ?>
            </div>

            <?php if (Session::userRole() === 'admin' || Session::userRole() === 'staff'): ?>
            <div class="nav-section">
                <span class="nav-section-title">QUẢN LÝ</span>
                <a href="<?= URL_ROOT ?>/member" class="nav-link-item">
                    <i class="bi bi-people-fill"></i>
                    <span>Thành viên</span>
                </a>
                <a href="<?= URL_ROOT ?>/package" class="nav-link-item">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Gói tập</span>
                </a>
                <a href="<?= URL_ROOT ?>/invoice" class="nav-link-item">
                    <i class="bi bi-receipt-cutoff"></i>
                    <span>Hóa đơn</span>
                </a>
                <a href="<?= URL_ROOT ?>/attendance" class="nav-link-item">
                    <i class="bi bi-qr-code-scan"></i>
                    <span>Check-in</span>
                </a>
                <a href="<?= URL_ROOT ?>/news/admin_index" class="nav-link-item <?= (isset($title) && $title === 'Quản lý Tin tức') ? 'active' : '' ?>">
                    <i class="bi bi-newspaper"></i>
                    <span>Tin tức</span>
                </a>
            </div>
            <?php endif; ?>

            <div class="nav-section">
                <span class="nav-section-title">FITNESS</span>
                <a href="<?= URL_ROOT ?>/fitness" class="nav-link-item">
                    <i class="bi bi-calculator-fill"></i>
                    <span>BMI / BMR / TDEE</span>
                </a>
                <a href="<?= URL_ROOT ?>/diet" class="nav-link-item">
                    <i class="bi bi-egg-fried"></i>
                    <span>Dinh dưỡng</span>
                </a>
                <a href="<?= URL_ROOT ?>/workout" class="nav-link-item">
                    <i class="bi bi-activity"></i>
                    <span>Giáo án tập</span>
                </a>
                <a href="<?= URL_ROOT ?>/exercise" class="nav-link-item">
                    <i class="bi bi-heart-pulse-fill"></i>
                    <span>Bài tập</span>
                </a>
            </div>

            <div class="nav-section">
                <span class="nav-section-title">THEO DÕI</span>
                <a href="<?= URL_ROOT ?>/tracking" class="nav-link-item">
                    <i class="bi bi-speedometer2"></i>
                    <span>Chỉ số cơ thể</span>
                </a>
                <a href="<?= URL_ROOT ?>/tracking/logs" class="nav-link-item">
                    <i class="bi bi-journal-text"></i>
                    <span>Nhật ký tập</span>
                </a>
                <a href="<?= URL_ROOT ?>/suggestion" class="nav-link-item">
                    <i class="bi bi-robot"></i>
                    <span>Gợi ý AI</span>
                </a>
                <?php if (Session::userRole() === 'admin' || Session::userRole() === 'staff'): ?>
                <a href="<?= URL_ROOT ?>/report" class="nav-link-item">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Báo cáo</span>
                </a>
                <?php endif; ?>
            </div>

            <?php if (Session::userRole() === 'admin'): ?>
            <div class="nav-section">
                <span class="nav-section-title">HỆ THỐNG</span>
                <a href="<?= URL_ROOT ?>/equipment" class="nav-link-item">
                    <i class="bi bi-tools"></i>
                    <span>Thiết bị</span>
                </a>
                <a href="<?= URL_ROOT ?>/user" class="nav-link-item">
                    <i class="bi bi-person-gear"></i>
                    <span>Tài khoản</span>
                </a>
                <a href="<?= URL_ROOT ?>/setting" class="nav-link-item">
                    <i class="bi bi-gear-fill"></i>
                    <span>Cấu hình</span>
                </a>
            </div>
            <?php endif; ?>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="page-title"><?= $title ?? 'Dashboard' ?></h1>
            </div>
            <div class="topbar-right">
                <!-- Notifications -->
                <div class="dropdown">
                    <button class="topbar-icon" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown">
                        <h6 class="dropdown-header">Thông báo</h6>
                        <div class="dropdown-item notification-item">
                            <i class="bi bi-exclamation-triangle text-warning"></i>
                            <div>
                                <p>2 gói tập sắp hết hạn</p>
                                <small class="text-muted">5 phút trước</small>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="<?= URL_ROOT ?>/notification" class="dropdown-item text-center">Xem tất cả</a>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="dropdown">
                    <button class="user-menu" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            <?php if (Session::get('user_avatar')): ?>
                                <img src="<?= URL_ROOT ?>/uploads/<?= Session::get('user_avatar') ?>" alt="">
                            <?php else: ?>
                                <i class="bi bi-person-fill"></i>
                            <?php endif; ?>
                        </div>
                        <div class="user-info d-none d-md-block">
                            <span class="user-name"><?= Session::userName() ?></span>
                            <span class="user-role"><?= ucfirst(Session::userRole()) ?></span>
                        </div>
                        <i class="bi bi-chevron-down d-none d-md-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="<?= URL_ROOT ?>/profile">
                            <i class="bi bi-person"></i> Hồ sơ
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?= URL_ROOT ?>/auth/logout">
                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="content-area">
            <!-- Flash Messages -->
            <?php if (Session::hasFlash('success')): ?>
                <?php $flash = Session::flash('success'); ?>
                <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show flash-alert" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= $flash['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (Session::hasFlash('error')): ?>
                <?php $flash = Session::flash('error'); ?>
                <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show flash-alert" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <?= $flash['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?= $content ?>
        </main>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= URL_ROOT ?>/js/app.js"></script>
</body>
</html>
