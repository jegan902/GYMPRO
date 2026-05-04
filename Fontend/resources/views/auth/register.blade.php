<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký | GYMPRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-dark">
    <div class="auth-page-wrapper">
        <!-- Background Shapes -->
        <div class="auth-bg-shapes">
            <div class="auth-shape auth-shape-1"></div>
            <div class="auth-shape auth-shape-2"></div>
            <div class="auth-shape auth-shape-3"></div>
        </div>

        <div class="auth-glass-card shadow-lg reveal">
            <!-- Left Side - Brand -->
            <div class="auth-side-brand d-none d-lg-flex">
                <div class="mb-5">
                    <a href="/" class="text-white text-decoration-none fs-3 fw-800">
                        <i class="bi bi-lightning-charge-fill"></i> GYM<strong>PRO</strong>
                    </a>
                </div>
                <h1 class="display-5 fw-800 mb-4">Bắt đầu hành trình!</h1>
                <p class="lead opacity-75 mb-5">Chỉ mất 30 giây để tạo tài khoản và mở khóa tương lai sức khỏe của bạn.
                </p>

                <div class="mt-auto">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="glass-pill rounded-circle"
                            style="width: 40px; height: 40px; display: grid; place-items: center; background: rgba(255,255,255,0.2) !important;">
                            <i class="bi bi-gift"></i>
                        </div>
                        <span>Nhận ngay 01 buổi tập thử Miễn phí</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="auth-side-form">
                <div class="mb-4 text-center text-lg-start">
                    <h2 class="fw-800 font-heading mb-2">Đăng ký</h2>
                    <p class="text-muted">Cung cấp thông tin để tạo tài khoản mới</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 mb-4 small">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST" class="auth-form-premium">
                    @csrf
                    <div class="auth-input-group">
                        <i class="bi bi-person"></i>
                        <input type="text" name="fullName" id="fullName" placeholder="Họ và tên của bạn" required
                            value="{{ old('fullName') }}">
                    </div>

                    <div class="auth-input-group">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="Địa chỉ Email" required
                            value="{{ old('email') }}">
                    </div>

                    <div class="auth-input-group">
                        <i class="bi bi-phone"></i>
                        <input type="tel" name="phone" id="phone" placeholder="Số điện thoại"
                            value="{{ old('phone') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="auth-input-group">
                                <i class="bi bi-lock"></i>
                                <input type="password" name="password" id="password" placeholder="Mật khẩu" required
                                    minlength="6">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="auth-input-group">
                                <i class="bi bi-patch-check"></i>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    placeholder="Nhập lại mật khẩu" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-check mb-4 small">
                        <input class="form-check-input" type="checkbox" id="terms" required checked>
                        <label class="form-check-label text-muted" for="terms">
                            Tôi đồng ý với <a href="#" class="text-primary text-decoration-none fw-bold">Điều khoản &
                                Chính sách</a>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-glow mb-4">
                        TẠO TÀI KHOẢN <i class="bi bi-person-plus-fill ms-2"></i>
                    </button>

                    <div class="text-center">
                        <p class="text-muted small mb-0">Đã có tài khoản? <a href="{{ route('login') }}"
                                class="text-primary fw-bold text-decoration-none">Đăng nhập ngay</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => document.querySelector('.reveal').classList.add('active'), 100);
        });
    </script>
</body>
</html>
