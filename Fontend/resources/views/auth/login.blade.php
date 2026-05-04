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
    <style>
        /* Embedding some styles for quick demo, but they should be in public/css/style.css */
        body { font-family: 'Inter', sans-serif; }
        .bg-dark { background-color: #0f172a !important; }
        .auth-page-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; padding: 20px; }
        .auth-glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 24px; display: flex; width: 1000px; max-width: 100%; min-height: 600px; overflow: hidden; position: relative; z-index: 1; }
        .auth-side-brand { flex: 1; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 60px; color: white; flex-direction: column; }
        .auth-side-form { flex: 1; padding: 60px; background: white; }
        .fw-800 { font-weight: 800; }
        .shadow-glow { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
        .auth-input-group { position: relative; margin-bottom: 20px; }
        .auth-input-group i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .auth-input-group input { width: 100%; padding: 15px 15px 15px 50px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; transition: all 0.3s; }
        .auth-input-group input:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
        @media (max-width: 991px) { .auth-glass-card { flex-direction: column; width: 450px; } .auth-side-brand { padding: 40px; text-align: center; } .auth-side-form { padding: 40px; } }
    </style>
</head>

<body class="bg-dark">
    <div class="auth-page-wrapper">
        <div class="auth-glass-card shadow-lg">
            <!-- Left Side - Brand -->
            <div class="auth-side-brand d-none d-lg-flex">
                <div class="mb-5">
                    <a href="/" class="text-white text-decoration-none fs-3 fw-800">
                        <i class="bi bi-lightning-charge-fill"></i> GYM<strong>PRO</strong>
                    </a>
                </div>
                <h1 class="display-5 fw-800 mb-4">Chào mừng trở lại!</h1>
                <p class="lead opacity-75 mb-5">Tiếp tục hành trình chinh phục vóc dáng cùng trợ lý huấn luyện thông minh GymPro.</p>
            </div>

            <!-- Right Side - Form -->
            <div class="auth-side-form">
                <div class="mb-5 text-center text-lg-start">
                    <h2 class="fw-800 mb-2">Đăng nhập</h2>
                    <p class="text-muted">Nhập thông tin tài khoản của bạn</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 mb-4 small">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="auth-input-group">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="Địa chỉ Email" required value="{{ old('email') }}">
                    </div>

                    <div class="auth-input-group">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 small">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label text-muted" for="remember">Ghi nhớ tôi</label>
                        </div>
                        <a href="#" class="text-primary fw-bold text-decoration-none">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-glow mb-4">
                        ĐĂNG NHẬP <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="text-center">
                    <p class="text-muted small">Chưa có tài khoản? <a href="#" class="text-primary fw-bold text-decoration-none">Đăng ký ngay</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
