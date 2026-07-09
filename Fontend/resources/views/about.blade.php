<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIỚI THIỆU | GYMPRO FITNESS</title>
    
    <!-- Fonts & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-red: #FF5E00; /* Athletic Orange */
            --primary-red-glow: rgba(255, 94, 0, 0.15);
            --dark-luxury-bg: #F4F6F9; /* Clean light grey-blue background */
            --dark-luxury-card: #FFFFFF; /* Pure white surface */
            --dark-border: #E2E8F0; /* Soft borders */
            --text-light: #1E293B; /* Deep Slate text */
            --text-muted: #64748B; /* Slate grey muted text */
            --red-gradient: linear-gradient(135deg, #FF7A00 0%, #FF5E00 100%);
            --grey-gradient: linear-gradient(180deg, #FFFFFF 0%, #F1F5F9 100%);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--dark-luxury-bg);
            color: var(--text-light);
            margin: 0;
            overflow-x: hidden;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.015'/%3E%3C/svg%3E");
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--dark-luxury-bg);
        }
        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-red);
        }

        /* Glow effects */
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(160px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.12;
        }
        .orb-red {
            background: var(--primary-red);
            width: 600px;
            height: 600px;
            top: 5%;
            right: -10%;
        }
        .orb-blue {
            background: #2E90FF;
            width: 500px;
            height: 500px;
            bottom: 15%;
            left: -10%;
        }

        /* Navbar */
        .navbar {
            backdrop-filter: blur(20px);
            background: rgba(244, 246, 249, 0.8);
            border-bottom: 1px solid var(--dark-border);
            padding: 20px 0;
            transition: all 0.3s;
            z-index: 9999;
        }
        .navbar.scrolled {
            padding: 14px 0;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        }
        .navbar-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 900;
            font-size: 1.8rem;
            letter-spacing: -1px;
            color: #1E293B !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .navbar-brand span {
            color: var(--primary-red);
        }
        .nav-link {
            color: #1E293B !important;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 8px 16px !important;
            transition: all 0.3s;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .nav-link:hover {
            color: var(--primary-red) !important;
        }
        .btn-login {
            background: transparent;
            border: 1px solid #1E293B;
            color: #1E293B !important;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 28px;
            border-radius: 4px;
            transition: all 0.3s;
            text-decoration: none;
        }
        .btn-login:hover {
            background: #1E293B;
            color: white !important;
            box-shadow: 0 4px 12px rgba(30, 41, 59, 0.15);
            transform: translateY(-2px);
        }

        /* Banner Header */
        .about-banner {
            padding-top: 170px;
            padding-bottom: 70px;
            background: var(--grey-gradient);
            border-bottom: 1px solid var(--dark-border);
            position: relative;
            z-index: 1;
        }
        .about-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 4rem;
            font-weight: 900;
            color: #1E293B;
            text-transform: uppercase;
            letter-spacing: -2px;
            line-height: 1.1;
        }
        .about-title span {
            color: var(--primary-red);
        }

        /* Section Layouts */
        .premium-section {
            padding: 90px 0;
            position: relative;
            z-index: 1;
        }
        .section-header-left {
            margin-bottom: 50px;
        }
        .section-tag {
            background: rgba(255, 94, 0, 0.08);
            border: 1px solid rgba(255, 94, 0, 0.2);
            color: var(--primary-red);
            font-weight: 800;
            font-size: 0.75rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 15px;
        }
        .section-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2.8rem;
            font-weight: 900;
            color: #1E293B;
            text-transform: uppercase;
            letter-spacing: -1px;
        }

        /* Premium Cards */
        .about-card {
            background: #FFFFFF;
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.02);
            transition: all 0.3s ease;
        }
        .about-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-red);
            box-shadow: 0 15px 35px rgba(255, 94, 0, 0.05);
        }
        .card-icon {
            font-size: 2.5rem;
            color: var(--primary-red);
            margin-bottom: 25px;
            display: inline-block;
        }
        .card-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: #1E293B;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        .card-text {
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 0;
            font-size: 0.95rem;
        }

        /* Grid Composition */
        .vision-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 60px;
            align-items: center;
        }
        @media(max-width: 991px) {
            .vision-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }
        .vision-image-wrapper {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--dark-border);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
        }
        .vision-image {
            width: 100%;
            height: 460px;
            object-fit: cover;
            filter: grayscale(10%) brightness(95%);
            transition: all 0.5s;
        }
        .vision-image-wrapper:hover .vision-image {
            transform: scale(1.02);
            filter: grayscale(0%);
        }

        /* Timeline styles */
        .timeline-container {
            position: relative;
            margin-top: 40px;
        }
        .timeline-container::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 100%;
            background: var(--dark-border);
            top: 0;
        }
        @media(max-width: 767px) {
            .timeline-container::before {
                left: 20px;
            }
        }
        .timeline-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 60px;
            position: relative;
        }
        @media(max-width: 767px) {
            .timeline-row {
                flex-direction: column;
                align-items: flex-start;
                padding-left: 50px;
            }
        }
        .timeline-badge {
            background: var(--red-gradient);
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 900;
            font-size: 1.25rem;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 10px #FFFFFF, 0 10px 25px rgba(255, 94, 0, 0.25);
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }
        @media(max-width: 767px) {
            .timeline-badge {
                left: 20px;
                width: 50px;
                height: 50px;
                font-size: 0.9rem;
                box-shadow: 0 0 0 6px #FFFFFF, 0 5px 15px rgba(255, 94, 0, 0.25);
            }
        }
        .timeline-card {
            background: #FFFFFF;
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            padding: 30px;
            width: 42%;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.01);
            transition: all 0.3s;
        }
        @media(max-width: 767px) {
            .timeline-card {
                width: 100%;
                margin-bottom: 20px;
            }
        }
        .timeline-card:hover {
            border-color: var(--primary-red);
            box-shadow: 0 15px 35px rgba(255, 94, 0, 0.05);
        }
        .timeline-row:nth-child(even) .timeline-card {
            order: 2;
        }
        .timeline-row:nth-child(odd) .timeline-card {
            order: 0;
        }
        @media(max-width: 767px) {
            .timeline-row:nth-child(even) .timeline-card,
            .timeline-row:nth-child(odd) .timeline-card {
                order: unset;
            }
        }

        /* Premium Campaign Buttons */
        .btn-red-glow {
            background: var(--red-gradient);
            color: white;
            font-weight: 800;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 18px 38px;
            border-radius: 4px;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 10px 25px rgba(255, 94, 0, 0.2);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-red-glow:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(255, 94, 0, 0.35);
            color: white;
        }

        /* Footer */
        footer {
            background: #0F172A;
            border-top: 1px solid rgba(255,255,255,0.05);
            padding: 80px 0 40px;
            color: #94A3B8;
            font-size: 0.9rem;
        }
        .footer-logo {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 900;
            font-size: 1.6rem;
            color: white;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .footer-logo span {
            color: var(--primary-red);
        }
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-links li {
            margin-bottom: 14px;
        }
        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .footer-links a:hover {
            color: white;
        }
    </style>
</head>

<body>
    <!-- Glow Orbs background -->
    <div class="glow-orb orb-red"></div>
    <div class="glow-orb orb-blue"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-lightning-charge-fill" style="color: var(--primary-red);"></i> GYM<span>PRO</span>
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <i class="bi bi-list fs-2"></i>
            </button>
            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">{{ __('Giới thiệu') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('news') }}">{{ __('Tin tức') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#pricing">{{ __('Gói tập') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">{{ __('Liên hệ') }}</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <!-- Language Switcher (vi/en) -->
                    <div class="dropdown me-1">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle text-uppercase fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.75rem; border-color: var(--dark-border); color: var(--text-light); padding: 8px 14px;">
                            <i class="bi bi-globe me-1" style="color: var(--primary-red);"></i>{{ App::getLocale() }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-light">
                            <li><a class="dropdown-item fw-semibold" href="{{ route('lang.switch', 'vi') }}">Tiếng Việt (VI)</a></li>
                            <li><a class="dropdown-item fw-semibold" href="{{ route('lang.switch', 'en') }}">English (EN)</a></li>
                        </ul>
                    </div>

                    <!-- User Account Icon Button -->
                    @if(session('api_token'))
                        <a href="{{ route('admin.dashboard') }}" class="btn-login d-flex align-items-center gap-2" title="{{ __('Vào Dashboard') }}">
                            <i class="bi bi-person-circle fs-5" style="color: var(--primary-red);"></i>
                            <span class="d-none d-md-inline">{{ __('Vào Dashboard') }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-login d-flex align-items-center gap-2" title="{{ __('Đăng nhập') }}">
                            <i class="bi bi-person-fill fs-5"></i>
                            <span class="d-none d-md-inline">{{ __('Đăng nhập') }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Banner Header -->
    <header class="about-banner">
        <div class="container text-center">
            <span class="section-tag">{{ __('Về chúng tôi') }}</span>
            <h1 class="about-title">{{ __('Hành Trình Kiến Tạo GymPro Fitness') }}</h1>
            <p class="text-muted mx-auto mt-3 fs-5" style="max-width: 600px;">{{ __('Khám phá sứ mệnh, các giá trị cốt lõi và cột mốc phát triển của chúng tôi.') }}</p>
        </div>
    </header>

    <!-- Mission & Vision Section -->
    <section class="premium-section">
        <div class="container">
            <div class="vision-grid">
                <div>
                    <span class="section-tag">Tầm nhìn & Sứ mệnh</span>
                    <h2 class="section-title mb-4">Mục tiêu nâng tầm thể chất Việt</h2>
                    <p class="fs-5 text-muted mb-4" style="line-height: 1.7;">
                        Chúng tôi hướng đến việc trở thành thương hiệu thể hình công nghệ số 1 tại Việt Nam, mang lại cho hàng triệu hội viên giải pháp tập luyện khoa học, chính xác và dễ tiếp cận nhất.
                    </p>
                    <p class="text-muted mb-4" style="line-height: 1.7;">
                        Sứ mệnh của GymPro là kết hợp hoàn hảo giữa không gian rèn luyện đẳng cấp và công nghệ theo dõi sinh học AI tự động. Bằng cách số hóa số đo cơ thể, tính toán BMI/BMR và kết nối dữ liệu trực tiếp với hệ thống quản trị CMS chi nhánh, chúng tôi giúp cá nhân hóa hoàn toàn lộ trình tập luyện của bạn.
                    </p>
                    <a href="{{ route('register') }}" class="btn-red-glow">Đăng ký tham gia ngay <i class="bi bi-chevron-right"></i></a>
                </div>
                <div class="vision-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1000" alt="GymPro Vision" class="vision-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="premium-section bg-white border-top border-bottom border-light">
        <div class="container">
            <div class="text-center section-header-left">
                <span class="section-tag">Giá trị cốt lõi</span>
                <h2 class="section-title">Triết Lý Vận Hành Của GymPro</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="about-card h-100">
                        <i class="bi bi-shield-check card-icon"></i>
                        <h3 class="card-title">Chuyên Nghiệp</h3>
                        <p class="card-text">Đội ngũ huấn luyện viên (PT) có chứng chỉ quốc tế và các nhà quản lý chi nhánh tận tâm đồng bộ từ CMS.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="about-card h-100">
                        <i class="bi bi-cpu card-icon" style="color: #2E90FF;"></i>
                        <h3 class="card-title">Công Nghệ</h3>
                        <p class="card-text">Hệ sinh thái AI Health Tool tự động phân tích chỉ số sinh trắc học và lịch sử tập luyện thời gian thực.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="about-card h-100">
                        <i class="bi bi-people card-icon" style="color: #10B981;"></i>
                        <h3 class="card-title">Cộng Đồng</h3>
                        <p class="card-text">Chúng tôi kiến tạo một môi trường tập luyện văn minh, kết nối và truyền cảm hứng thể thao tích cực.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline / History Section -->
    <section class="premium-section">
        <div class="container">
            <div class="text-center section-header-left">
                <span class="section-tag">Lịch sử phát triển</span>
                <h2 class="section-title">Hành Trình Phát Triển</h2>
            </div>
            <div class="timeline-container">
                <!-- Year 2022 -->
                <div class="timeline-row">
                    <div class="timeline-badge">2022</div>
                    <div class="timeline-card">
                        <h4 class="fw-bold mb-2">Thành lập GymPro</h4>
                        <p class="text-muted mb-0">Ra mắt chi nhánh đầu tiên tại TP. Hồ Chí Minh với quy mô 1000m² đạt chuẩn Olympic.</p>
                    </div>
                    <div style="width: 42%;"></div>
                </div>
                <!-- Year 2024 -->
                <div class="timeline-row">
                    <div style="width: 42%;"></div>
                    <div class="timeline-badge" style="background: linear-gradient(135deg, #2E90FF 0%, #0066FF 100%);">2024</div>
                    <div class="timeline-card">
                        <h4 class="fw-bold mb-2">Số hóa Hệ thống CMS</h4>
                        <p class="text-muted mb-0">Tích hợp phần mềm quản trị CMS phân quyền chi tiết cho Branch Admin, quản lý trang thiết bị và huấn luyện viên.</p>
                    </div>
                </div>
                <!-- Year 2026 -->
                <div class="timeline-row">
                    <div class="timeline-badge">2026</div>
                    <div class="timeline-card">
                        <h4 class="fw-bold mb-2">15+ Chi nhánh Toàn quốc</h4>
                        <p class="text-muted mb-0">Mở rộng mạng lưới chi nhánh trên khắp 3 miền Bắc-Trung-Nam và ra mắt AI Health Tool đề xuất dinh dưỡng.</p>
                    </div>
                    <div style="width: 42%;"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-logo">
                        <i class="bi bi-lightning-charge-fill" style="color: var(--primary-red);"></i> GYM<span>PRO</span>
                    </div>
                    <p class="text-muted pe-lg-4">
                        Hệ sinh thái thể hình công nghệ cao cấp. Đồng bộ dữ liệu quản trị từ CMS các chi nhánh thời gian thực.
                    </p>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold text-white mb-3" style="font-size: 0.75rem; letter-spacing: 1.5px; text-transform: uppercase;">Điều Hướng</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Trang Chủ</a></li>
                        <li><a href="{{ route('about') }}">Giới Thiệu</a></li>
                        <li><a href="{{ route('news') }}">Tin Tức</a></li>
                        <li><a href="{{ route('contact') }}">Liên Hệ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold text-white mb-3" style="font-size: 0.75rem; letter-spacing: 1.5px; text-transform: uppercase;">Hỗ Trợ</h5>
                    <p class="mb-2 text-muted"><i class="bi bi-telephone-fill me-2 text-white"></i> Hotline: 1900 6868</p>
                    <p class="mb-2 text-muted"><i class="bi bi-envelope-fill me-2 text-white"></i> Email: support@gympro.com</p>
                    <p class="mb-0 text-muted"><i class="bi bi-geo-alt-fill me-2 text-white"></i> HQ: Quận 1, TP. Hồ Chí Minh</p>
                </div>
            </div>
            <div class="border-top border-secondary mt-5 pt-4 text-center text-muted small">
                <p class="mb-0">© 2026 GYMPRO. All rights reserved. Powered by Laravel & ASP.NET Core.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar Scrolled Class
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
