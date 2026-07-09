<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIÊN HỆ | GYMPRO FITNESS</title>
    
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
        .contact-banner {
            padding-top: 170px;
            padding-bottom: 70px;
            background: var(--grey-gradient);
            border-bottom: 1px solid var(--dark-border);
            position: relative;
            z-index: 1;
        }
        .contact-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 4rem;
            font-weight: 900;
            color: #1E293B;
            text-transform: uppercase;
            letter-spacing: -2px;
            line-height: 1.1;
        }
        .contact-title span {
            color: var(--primary-red);
        }

        /* Contact content grid */
        .contact-section {
            padding: 80px 0;
            position: relative;
            z-index: 1;
        }
        .contact-grid {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            gap: 60px;
        }
        @media(max-width: 991px) {
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }
        .contact-info-card {
            background: #FFFFFF;
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.02);
            height: 100%;
        }
        .info-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.8rem;
            font-weight: 900;
            color: #1E293B;
            text-transform: uppercase;
            margin-bottom: 30px;
            letter-spacing: -0.5px;
        }
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 25px;
        }
        .info-icon {
            font-size: 1.5rem;
            color: var(--primary-red);
            background: rgba(255, 94, 0, 0.08);
            width: 48px;
            height: 48px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .info-text-box h5 {
            font-weight: 800;
            font-size: 0.95rem;
            text-transform: uppercase;
            color: #1E293B;
            margin-bottom: 5px;
        }
        .info-text-box p {
            color: var(--text-muted);
            margin: 0;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Lead Form */
        .contact-form-card {
            background: #FFFFFF;
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.02);
        }
        .form-label-custom {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: 8px;
            display: block;
        }
        .form-input-custom {
            background: #F8FAFC;
            border: 1px solid var(--dark-border);
            border-radius: 4px;
            color: #1E293B;
            padding: 12px 16px;
            width: 100%;
            outline: none;
            transition: all 0.3s;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }
        .form-input-custom:focus {
            border-color: var(--primary-red);
            box-shadow: 0 0 10px var(--primary-red-glow);
        }
        .btn-submit {
            background: var(--red-gradient);
            color: white;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 16px 36px;
            border-radius: 4px;
            transition: all 0.3s;
            border: none;
            width: 100%;
            box-shadow: 0 10px 25px rgba(255, 94, 0, 0.2);
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(255, 94, 0, 0.35);
        }

        /* Maps Placeholder */
        .map-section {
            margin-top: 60px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--dark-border);
            height: 400px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.02);
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
    <header class="contact-banner">
        <div class="container text-center">
            <span class="section-tag">{{ __('Kết nối ngay') }}</span>
            <h1 class="contact-title">{{ __('Liên Hệ với Chúng Tôi') }}</h1>
            <p class="text-muted mx-auto mt-3 fs-5" style="max-width: 600px;">{{ __('Gửi thắc mắc hoặc yêu cầu tư vấn gói tập. Đội ngũ GymPro luôn sẵn sàng hỗ trợ bạn.') }}</p>
        </div>
    </header>

    <!-- Contact Grid Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-grid">
                <!-- Left: Info Cards -->
                <div class="contact-info-card">
                    <h3 class="info-title">Thông Tin Liên Hệ</h3>
                    
                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div class="info-text-box">
                            <h5>Hotline hỗ trợ</h5>
                            <p>1900 6868 (Phím 1 cho Tư vấn, Phím 2 cho CSKH)</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div class="info-text-box">
                            <h5>Email tiếp nhận</h5>
                            <p>support@gympro.com<br>info@gympro.com</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div class="info-text-box">
                            <h5>Trụ sở chính</h5>
                            <p>Số 12 Lê Lợi, Bến Nghé, Quận 1, TP. Hồ Chí Minh</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-clock-fill"></i></div>
                        <div class="info-text-box">
                            <h5>Giờ mở cửa</h5>
                            <p>Thứ 2 - Chủ Nhật: 05:00 - 22:00 (Kể cả ngày lễ)</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Contact Form -->
                <div class="contact-form-card">
                    <h3 class="info-title">Gửi Yêu Cầu Tư Vấn</h3>
                    <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã liên hệ! Yêu cầu của bạn đã được tiếp nhận và xử lý.');">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="form-label-custom">Họ và Tên</span>
                                <input type="text" class="form-input-custom" placeholder="Nguyễn Văn A" required>
                            </div>
                            <div class="col-md-6">
                                <span class="form-label-custom">Số Điện Thoại</span>
                                <input type="tel" class="form-input-custom" placeholder="0901 234 567" required>
                            </div>
                        </div>
                        
                        <span class="form-label-custom">Địa chỉ Email</span>
                        <input type="email" class="form-input-custom" placeholder="name@example.com" required>

                        <span class="form-label-custom">Lời nhắn</span>
                        <textarea class="form-input-custom" rows="4" placeholder="Tôi muốn tìm hiểu gói tập thử..." required style="height: auto;"></textarea>

                        <button type="submit" class="btn-submit">Gửi Tin Nhắn Ngay <i class="bi bi-send-fill ms-2"></i></button>
                    </form>
                </div>
            </div>

            <!-- Interactive Map Placeholder -->
            <div class="map-section">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.460232422079!2d106.70100221480076!3d10.775658692322008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1m3!1d3919.460232422079!2d106.70100221480076!3d10.775658692322008!2m2!1d106.7010022!2d10.7756587!5e0!3m2!1svi!2s!4v1655000000000!5m2!1svi!2s" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
