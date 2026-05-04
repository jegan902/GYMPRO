<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMPRO | Hệ Thống Quản Lý Phòng Gym Thông Minh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF5E00;
            --secondary-color: #E65500;
            --accent-color: #1A1A2E;
            --orange-gradient: linear-gradient(135deg, #FF7A00 0%, #FF4D00 100%);
            --glass-white: rgba(255, 255, 255, 0.15);
            --text-main: #FFFFFF;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--orange-gradient);
            color: var(--text-main);
            margin: 0;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -1px;
            color: white !important;
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 100px;
            padding-bottom: 80px;
        }

        .hero-bg-glow {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 70%);
            z-index: -1;
            filter: blur(100px);
        }

        .display-1 {
            font-weight: 900;
            color: white;
            margin-bottom: 30px;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            line-height: 1.1;
        }

        .btn-premium {
            padding: 18px 40px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 0.9rem;
        }

        .btn-white-premium {
            background: white;
            border: none;
            color: var(--primary-color);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .btn-white-premium:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.2);
            color: var(--secondary-color);
        }

        .btn-outline-white {
            border: 2px solid rgba(255, 255, 255, 0.4);
            color: white;
        }

        .btn-outline-white:hover {
            border-color: white;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateY(-5px);
        }

        .features-grid {
            margin-top: 100px;
        }

        .feature-card {
            background: var(--glass-white);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 40px;
            height: 100%;
            transition: all 0.4s;
            color: white;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .feature-icon {
            width: 65px;
            height: 65px;
            background: white;
            border-radius: 18px;
            display: grid;
            place-items: center;
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 25px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .badge-premium {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            font-weight: 600;
            letter-spacing: 1px;
        }

        footer {
            background: rgba(0, 0, 0, 0.05);
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-lightning-charge-fill text-white"></i> GYM<strong>PRO</strong>
            </a>
            <div class="ms-auto">
                <a href="{{ route('login') }}" class="btn btn-outline-white rounded-pill px-4 fw-600">Đăng nhập</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg-glow"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 text-center text-lg-start">
                    <span class="badge rounded-pill badge-premium px-3 py-2 mb-4">HỆ THỐNG QUẢN LÝ SMART FITNESS</span>
                    <h1 class="display-1">Khai Phá Tiềm Năng<br>Của Bạn</h1>
                    <p class="lead mb-5 fs-4">GymPro kết hợp trí tuệ nhân tạo và quản lý vận hành tối ưu, giúp hành trình chinh phục vóc dáng của bạn trở nên khoa học hơn bao giờ hết.</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                        <a href="{{ route('login') }}" class="btn btn-premium btn-white-premium">Bắt đầu ngay <i class="bi bi-arrow-right ms-2"></i></a>
                        <a href="#features" class="btn btn-premium btn-outline-white">Tìm hiểu thêm</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="position-relative">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-10 rounded-4 rotate-3"></div>
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop" alt="Gym" class="img-fluid rounded-4 shadow-2xl relative z-1" style="filter: brightness(1.1) contrast(1.1);">
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div id="features" class="features-grid row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <h4 class="fw-bold mb-3">Theo Dõi Chỉ Số</h4>
                        <p class="opacity-75">Tự động tính toán BMI, BMR, TDEE và gợi ý dinh dưỡng theo thời gian thực.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-calendar-check"></i></div>
                        <h4 class="fw-bold mb-3">Giáo Án Tập Luyện</h4>
                        <p class="opacity-75">Hàng trăm bài tập được thiết kế riêng cho từng cấp độ và mục tiêu cá nhân.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-shield-lock"></i></div>
                        <h4 class="fw-bold mb-3">Quản Lý Chuyên Nghiệp</h4>
                        <p class="opacity-75">Quản lý hội viên, gói tập và hóa đơn với hệ thống bảo mật JWT hàng đầu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5 text-center border-top border-white border-opacity-10">
        <div class="container">
            <p class="mb-0">© 2026 GYMPRO Management System. Powered by .NET 8 & Laravel.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
