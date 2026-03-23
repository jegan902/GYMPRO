<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= URL_ROOT ?>/css/style.css">
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
                    <a href="<?= URL_ROOT ?>/" class="text-white text-decoration-none fs-3 fw-800">
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

                <?php if (Session::hasFlash('error')): ?>
                    <?php $flash = Session::flash('error'); ?>
                    <div class="alert alert-danger border-0 rounded-4 mb-4 small">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $flash['message'] ?>
                    </div>
                <?php endif; ?>

                <?php if (Session::hasFlash('success')): ?>
                    <?php $flash = Session::flash('success'); ?>
                    <div class="alert alert-success border-0 rounded-4 mb-4 small">
                        <i class="bi bi-check-circle-fill me-2"></i><?= $flash['message'] ?>
                    </div>
                <?php endif; ?>

                <form action="<?= URL_ROOT ?>/auth/authenticate" method="POST" class="auth-form-premium">
                    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">

                    <div class="auth-input-group">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="Địa chỉ Email" required
                            autocomplete="email">
                    </div>

                    <div class="auth-input-group">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Mật khẩu" required
                            autocomplete="current-password">
                        <button type="button"
                            class="position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent pe-3 text-muted"
                            onclick="togglePassword('password')">
                            <i class="bi bi-eye" id="password-icon" style="position: static; transform: none;"></i>
                        </button>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 small">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label text-muted" for="remember">Ghi nhớ tôi</label>
                        </div>
                        <a href="#" class="text-primary fw-bold text-decoration-none">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-glow mb-4">
                        ĐĂNG NHẬP <i class="bi bi-arrow-right ms-2"></i>
                    </button>

                    <div class="text-center">
                        <p class="text-muted small">Hoặc đăng nhập bằng</p>
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <button type="button" class="btn btn-light rounded-circle shadow-sm"
                                style="width: 50px; height: 50px;"><i class="bi bi-google"></i></button>
                            <button type="button" class="btn btn-light rounded-circle shadow-sm"
                                style="width: 50px; height: 50px;"><i class="bi bi-facebook text-primary"></i></button>
                        </div>
                        <p class="text-muted small mb-0">Chưa có tài khoản? <a href="<?= URL_ROOT ?>/auth/register"
                                class="text-primary fw-bold text-decoration-none">Đăng ký ngay</a></p>
                    </div>
                </form>

                <!-- Demo accounts
                <div class="mt-5 p-3 rounded-4 bg-light border border-dashed text-center">
                    <p class="text-muted x-small mb-2"><i class="bi bi-info-circle me-1"></i> Tài khoản demo (click để điền):</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-white btn-sm shadow-sm rounded-pill px-3 border" onclick="fillDemo('admin@gym.com', 'password')">Admin</button>
                        <button class="btn btn-white btn-sm shadow-sm rounded-pill px-3 border" onclick="fillDemo('member@gym.com', 'password')">Member</button>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

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

        function fillDemo(email, pass) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = pass;
        }

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => document.querySelector('.reveal').classList.add('active'), 100);
        });
    </script>
</body>

</html>