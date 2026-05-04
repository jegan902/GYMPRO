<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | GYMPRO</title>
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
                <h1 class="display-5 fw-800 mb-4">Chào mừng trở lại!</h1>
                <p class="lead opacity-75 mb-5">Tiếp tục hành trình chinh phục vóc dáng cùng trợ lý huấn luyện thông
                    minh GymPro.</p>

                <div class="mt-auto">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="glass-pill rounded-circle"
                            style="width: 40px; height: 40px; display: grid; place-items: center; background: rgba(255,255,255,0.2) !important;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <span>Bảo mật thông tin tối đa</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="auth-side-form">
                <div class="mb-5 text-center text-lg-start">
                    <h2 class="fw-800 font-heading mb-2">Đăng nhập</h2>
                    <p class="text-muted">Nhập thông tin tài khoản của bạn</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success border-0 rounded-4 mb-4 small">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 mb-4 small">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="auth-form-premium">
                    @csrf
                    <div class="auth-input-group">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="Địa chỉ Email" required
                            value="{{ old('email') }}">
                    </div>

                    <div class="auth-input-group">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                        <button type="button"
                            class="position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent pe-3 text-muted"
                            onclick="togglePassword('password')">
                            <i class="bi bi-eye" id="password-icon" style="position: static; transform: none;"></i>
                        </button>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 small">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label text-muted" for="remember">Ghi nhớ tôi</label>
                        </div>
                        <a href="{{ route('forgot.password') }}" class="text-primary fw-bold text-decoration-none">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-glow mb-4">
                        ĐĂNG NHẬP <i class="bi bi-arrow-right ms-2"></i>
                    </button>

                    <div class="text-center">
                        <p class="text-muted small mb-0">Chưa có tài khoản? <a href="{{ route('register') }}"
                                class="text-primary fw-bold text-decoration-none">Đăng ký ngay</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = document.getElementById(id + '-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => document.querySelector('.reveal').classList.add('active'), 100);
        });
    </script>
</body>

</html>

