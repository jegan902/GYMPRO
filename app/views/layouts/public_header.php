<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= APP_NAME ?> - Hệ thống quản lý phòng gym & fitness đẳng cấp, theo dõi sức khỏe và lịch tập thông minh.">
    <meta name="keywords" content="gym, fitness, workout, sức khỏe, thể hình, quản lý phòng tập">
    <meta property="og:title" content="<?= isset($title) ? $title . ' | ' : '' ?><?= APP_NAME ?>">
    <meta property="og:description" content="Hệ thống quản lý phòng gym & fitness đẳng cấp, theo dõi sức khỏe và lịch tập thông minh.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= URL_ROOT ?>">
    <meta property="og:image" content="<?= URL_ROOT ?>/img/og-image.jpg">
    <title><?= isset($title) ? $title . ' | ' : '' ?><?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= URL_ROOT ?>/css/style.css">
    <?php if(isset($extra_css)) echo $extra_css; ?>
</head>
<body class="landing-body bg-white">

    <!-- Navbar -->
    <!-- Sử dụng fix-top cho trang home hoặc background cho các trang chung -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top" id="landingNav" style="<?= isset($is_home) && $is_home ? 'position: fixed; width: 100%; border-bottom: none !important; background: transparent !important;' : '' ?>">
        <div class="container">
            <a class="navbar-brand" href="<?= URL_ROOT ?>/">
                <i class="bi bi-lightning-charge-fill text-primary"></i>
                GYM<strong>PRO</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($_GET['url']) && $_GET['url'] == '') ? 'active fw-bold' : '' ?>" href="<?= URL_ROOT ?>/">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($_GET['url']) && strpos($_GET['url'], 'service') !== false) ? 'active fw-bold' : '' ?>" href="<?= URL_ROOT ?>/service">Dịch vụ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($_GET['url']) && strpos($_GET['url'], 'about') !== false) ? 'active fw-bold' : '' ?>" href="<?= URL_ROOT ?>/about">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($_GET['url']) && strpos($_GET['url'], 'news') !== false) ? 'active fw-bold' : '' ?>" href="<?= URL_ROOT ?>/news">Tin tức</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL_ROOT ?>/dashboard">Hệ thống trợ lý</a>
                    </li>
                    <?php if (Session::isLoggedIn()) : ?>
                        <?php if (Session::userRole() !== 'user'): ?>
                            <!-- <li class="nav-item ms-lg-3">
                                <a class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-2" href="<?= URL_ROOT ?>/dashboard">
                                    <i class="bi bi-speedometer2"></i> Bảng điều khiển
                                </a>
                            </li> -->
                        <?php endif; ?>

                        <li class="nav-item dropdown ms-lg-3">
                            <a class="btn btn-outline-primary btn-sm px-3 dropdown-toggle d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> <?= htmlspecialchars(Session::userName()) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?= URL_ROOT ?>/profile"><i class="bi bi-person me-2"></i>Hồ sơ cá nhân</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= URL_ROOT ?>/auth/logout"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-outline-dark btn-sm px-3" href="<?= URL_ROOT ?>/auth/login">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm px-3" href="<?= URL_ROOT ?>/auth/register">Đăng ký</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    <div class="container mt-3">
        <?php if (Session::hasFlash('error')): ?>
            <?php $flash = Session::flash('error'); ?>
            <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
                <?= $flash['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (Session::hasFlash('success')): ?>
            <?php $flash = Session::flash('success'); ?>
            <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
                <?= $flash['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
