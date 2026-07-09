<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIN TỨC & SỰ KIỆN | GYMPRO FITNESS</title>
    
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
        .news-banner {
            padding-top: 170px;
            padding-bottom: 70px;
            background: var(--grey-gradient);
            border-bottom: 1px solid var(--dark-border);
            position: relative;
            z-index: 1;
        }
        .news-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 4rem;
            font-weight: 900;
            color: #1E293B;
            text-transform: uppercase;
            letter-spacing: -2px;
            line-height: 1.1;
        }
        .news-title span {
            color: var(--primary-red);
        }

        /* Article Cards Grid */
        .news-section {
            padding: 80px 0;
            position: relative;
            z-index: 1;
        }
        .news-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }
        @media(max-width: 991px) {
            .news-grid {
                grid-template-columns: 1fr;
            }
        }
        .article-card {
            background: #FFFFFF;
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.02);
            transition: all 0.35s ease;
            display: flex;
            flex-direction: column;
        }
        .article-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-red);
            box-shadow: 0 15px 35px rgba(255, 94, 0, 0.08);
        }
        .article-image-wrapper {
            position: relative;
            height: 280px;
            overflow: hidden;
        }
        .article-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .article-card:hover .article-image {
            transform: scale(1.03);
        }
        .article-category {
            position: absolute;
            top: 20px;
            left: 20px;
            background: var(--red-gradient);
            color: white;
            font-weight: 800;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 6px 14px;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(255, 94, 0, 0.25);
        }
        .article-body {
            padding: 35px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .article-date {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .article-title-text {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #1E293B;
            line-height: 1.25;
            margin-bottom: 15px;
            transition: color 0.3s;
            text-decoration: none;
        }
        .article-title-text:hover {
            color: var(--primary-red);
        }
        .article-summary {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        .article-link {
            font-size: 0.85rem;
            font-weight: 800;
            color: #1E293B;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: auto;
            transition: color 0.3s;
        }
        .article-link:hover {
            color: var(--primary-red);
        }

        /* Newsletter Box */
        .newsletter-box {
            background: #FFFFFF;
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            padding: 60px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.02);
            margin-top: 60px;
        }
        .newsletter-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2.2rem;
            font-weight: 900;
            color: #1E293B;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        .newsletter-input-group {
            max-width: 500px;
            margin: 25px auto 0;
            display: flex;
            gap: 10px;
        }
        .newsletter-input {
            flex-grow: 1;
            background: #F8FAFC;
            border: 1px solid var(--dark-border);
            border-radius: 4px;
            padding: 14px 20px;
            color: #1E293B;
            outline: none;
            font-size: 0.95rem;
        }
        .newsletter-input:focus {
            border-color: var(--primary-red);
        }
        .newsletter-btn {
            background: var(--red-gradient);
            color: white;
            font-weight: 800;
            border: none;
            padding: 0 30px;
            border-radius: 4px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .newsletter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 94, 0, 0.2);
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
    <header class="news-banner">
        <div class="container text-center">
            <span class="section-tag">{{ __('Cập nhật mới nhất') }}</span>
            <h1 class="news-title">{{ __('Tin Tức & Sự Kiện') }}</h1>
            <p class="text-muted mx-auto mt-3 fs-5" style="max-width: 600px;">{{ __('Theo dõi các tin tức thể hình, dinh dưỡng và sự kiện giải đấu tại GymPro.') }}</p>
        </div>
    </header>

    <!-- News Grid Section -->
    <section class="news-section">
        <div class="container">
            <div class="news-grid">
                @foreach($articles as $article)
                    @php
                        $artId = data_get($article, 'id') ?? 1;
                        $artTitle = data_get($article, 'title');
                        $artSummary = data_get($article, 'summary');
                        $artImage = data_get($article, 'image');
                        $artCategory = data_get($article, 'category');
                        $artDate = data_get($article, 'date');
                    @endphp
                    <div class="article-card">
                        <div class="article-image-wrapper">
                            <span class="article-category">{{ $artCategory }}</span>
                            <img src="{{ $artImage }}" alt="{{ $artTitle }}" class="article-image">
                        </div>
                        <div class="article-body">
                            <span class="article-date"><i class="bi bi-calendar3"></i> {{ $artDate }}</span>
                            <a href="javascript:void(0)" class="article-title-text" onclick="showArticleDetails('{{ $artId }}', '{{ addslashes($artTitle) }}', '{{ addslashes($artSummary) }}', '{{ $artImage }}', '{{ $artCategory }}', '{{ $artDate }}')">{{ $artTitle }}</a>
                            <p class="article-summary">{{ $artSummary }}</p>
                            <a href="javascript:void(0)" class="article-link" onclick="showArticleDetails('{{ $artId }}', '{{ addslashes($artTitle) }}', '{{ addslashes($artSummary) }}', '{{ $artImage }}', '{{ $artCategory }}', '{{ $artDate }}')"><?php echo __('Đọc chi tiết'); ?> <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Newsletter Subscription -->
            <div class="newsletter-box">
                <h3 class="newsletter-title">{{ __('Nhận Ưu Đãi & Tin Tức Mới') }}</h3>
                <p class="text-muted mb-0">{{ __('Đăng ký email để nhận lịch trình giải đấu, mẹo ăn uống giảm mỡ và các voucher gói tập sớm nhất.') }}</p>
                <div class="newsletter-input-group">
                    <input type="email" class="newsletter-input" placeholder="{{ __('Nhập địa chỉ email của bạn...') }}">
                    <button class="newsletter-btn">{{ __('Đăng ký') }}</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Detail Modal -->
    <div class="modal fade" id="articleModal" tabindex="-1" aria-labelledby="articleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: var(--dark-luxury-card); border: 1px solid var(--dark-border); border-radius: 12px; overflow: hidden; color: var(--text-light);">
                <div class="modal-header border-0 pb-0 position-relative" style="z-index: 10;">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 bg-dark p-2 rounded-circle" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.8; filter: invert(1);"></button>
                </div>
                <div class="modal-body p-0">
                    <div style="height: 350px; position: relative;">
                        <img id="modalImage" src="" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%); padding: 30px; padding-top: 80px;">
                            <span id="modalCategory" class="badge bg-danger mb-2" style="background: var(--red-gradient) !important; letter-spacing: 1px; font-weight: 800; font-size: 0.7rem; text-transform: uppercase; padding: 6px 12px; border-radius: 4px;"></span>
                            <h2 id="modalTitle" class="text-white fw-bold uppercase m-0" style="font-size: 1.8rem; line-height: 1.2; text-shadow: 0 2px 4px rgba(0,0,0,0.5);"></h2>
                        </div>
                    </div>
                    <div class="p-4 p-md-5">
                        <div class="d-flex align-items-center gap-3 text-muted small mb-4 font-monospace">
                            <span><i class="bi bi-calendar3 me-1"></i> <span id="modalDate"></span></span>
                            <span>•</span>
                            <span><i class="bi bi-person-fill me-1"></i> Admin GymPro</span>
                        </div>
                        <div id="modalContent" class="fs-5 lh-lg text-muted" style="text-align: justify; font-weight: 400;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-light p-3 d-flex justify-content-end bg-light bg-opacity-50">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; border-color: var(--dark-border); color: var(--text-light);"><?php echo __('Đóng'); ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-logo">
                        <i class="bi bi-lightning-charge-fill" style="color: var(--primary-red);"></i> GYM<span>PRO</span>
                    </div>
                    <p class="text-muted pe-lg-4">
                        <?php echo __('Hệ sinh thái thể hình công nghệ cao cấp. Đồng bộ dữ liệu quản trị từ CMS các chi nhánh thời gian thực.'); ?>
                    </p>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold text-white mb-3" style="font-size: 0.75rem; letter-spacing: 1.5px; text-transform: uppercase;"><?php echo __('Điều Hướng'); ?></h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><?php echo __('Trang Chủ'); ?></a></li>
                        <li><a href="{{ route('about') }}"><?php echo __('Giới Thiệu'); ?></a></li>
                        <li><a href="{{ route('news') }}"><?php echo __('Tin Tức'); ?></a></li>
                        <li><a href="{{ route('contact') }}"><?php echo __('Liên Hệ'); ?></a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold text-white mb-3" style="font-size: 0.75rem; letter-spacing: 1.5px; text-transform: uppercase;"><?php echo __('Hỗ Trợ'); ?></h5>
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

        // Mock detail database mapping
        const articleDetails = {
            1: "<?php echo __('GymPro Quận 7 tự hào là một trong những trung tâm thể hình cao cấp nhất khu vực phía Nam Sài Gòn. Với quy mô diện tích lên đến hơn 2.000m², cơ sở mới trang bị toàn bộ hệ thống máy tập hiện đại từ thương hiệu Technogym (Italy) đạt tiêu chuẩn thi đấu Olympic. Không gian tập luyện tại đây được thiết kế theo phong cách Luxury Industrial tinh tế, sang trọng, mang lại cảm hứng bứt phá giới hạn cho từng hội viên. Ngoài ra, chi nhánh còn sở hữu khu vực locker 5 sao, phòng tắm xông hơi thảo dược miễn phí và đội ngũ huấn luyện viên (PT) giàu kinh nghiệm sẵn sàng đồng hành 1-1 cùng học viên.'); ?>",
            2: "<?php echo __('Chế độ dinh dưỡng chiếm tới 70% thành công trong hành trình cải thiện vóc dáng. Để bắt đầu một cách khoa học, người mới cần hiểu rõ về các nhóm chất dinh dưỡng vĩ lượng (Macro) bao gồm Protein, Carb và Fat. Sử dụng chỉ số chiều cao và cân nặng để tính toán TDEE (Tổng lượng năng lượng tiêu thụ hàng ngày) là bước đầu tiên để xác định lượng calo cần nạp vào. GymPro khuyên bạn nên tập trung vào việc bổ sung nguồn đạm sạch (ức gà, bò, cá), carb hấp thụ chậm (yến mạch, khoai lang) và chất béo tốt (hạnh nhân, quả bơ) kết hợp uống đủ 2-3 lít nước mỗi ngày để tối ưu trao đổi chất.'); ?>",
            3: "<?php echo __('Các bài tập phối hợp nhiều nhóm cơ cùng lúc (Compound) như Squat, Bench Press và Deadlift là chìa khóa vàng để kích thích cơ bắp phát triển toàn diện và gia tăng sức mạnh cốt lõi. Khi thực hiện các bài tập này, kỹ thuật chuẩn xác là yếu tố quan trọng nhất để tránh chấn thương cột sống và khớp. Bạn nên bắt đầu với mức tạ nhẹ để làm quen với biên độ chuyển động (ROM), tập trung gồng cơ trọng tâm (bracing core) và luôn có sự giám sát của huấn luyện viên hỗ trợ khi nâng tạ nặng.'); ?>",
            4: "<?php echo __('Giải đấu GymPro Powerlifting Championship 2026 chính thức khởi tranh tại chi nhánh Quận 1 vào ngày 28/05/2026. Đây là giải đấu thường niên quy tụ hơn 200 lực sĩ bán chuyên và chuyên nghiệp trên toàn quốc tham gia tranh tài ở 3 nội dung: Squat, Bench Press và Deadlift. Tổng giá trị giải thưởng lên đến 100 triệu đồng cùng cơ hội nhận gói tập VIP trọn đời tại hệ thống GymPro. Khán giả và hội viên có thể đến cổ vũ trực tiếp hoặc theo dõi livestream trên fanpage chính thức của chúng tôi.'); ?>"
        };

        // Show details in Modal
        function showArticleDetails(id, title, summary, image, category, date) {
            const content = articleDetails[id] || summary;
            
            document.getElementById('modalImage').src = image;
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalCategory').innerText = category;
            document.getElementById('modalDate').innerText = date;
            document.getElementById('modalContent').innerText = content;

            const myModal = new bootstrap.Modal(document.getElementById('articleModal'));
            myModal.show();
        }
    </script>
</body>
</html>
