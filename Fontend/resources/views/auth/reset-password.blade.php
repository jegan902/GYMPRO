<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu | GYMPRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-dark { background-color: #F4F6F9 !important; }
        .auth-page-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .auth-card { background: white; border-radius: 24px; width: 450px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); }
        .fw-800 { font-weight: 800; }
        .text-primary { color: #FF5E00 !important; }
        .btn-primary { background-color: #FF5E00; border: none; box-shadow: 0 5px 15px rgba(255, 94, 0, 0.3); }
        .btn-primary:hover { background-color: #E65500; }
        .form-control { padding: 12px 20px; border-radius: 12px; border: 1px solid #e2e8f0; }
        .form-control:focus { border-color: #FF5E00; box-shadow: 0 0 0 4px rgba(255, 94, 0, 0.1); }
        .otp-input { letter-spacing: 10px; text-align: center; font-size: 1.5rem; font-weight: 800; color: #FF5E00; }
    </style>
</head>
<body class="bg-dark">
    <div class="auth-page-wrapper">
        <div class="auth-card">
            <div class="text-center mb-4">
                <a href="/" class="text-primary text-decoration-none fs-3 fw-800">
                    <i class="bi bi-lightning-charge-fill"></i> GYM<strong>PRO</strong>
                </a>
            </div>
            <h2 class="fw-800 text-center mb-3">Đặt lại mật khẩu</h2>
            <p class="text-muted text-center mb-4 small">Mã OTP đã được gửi đến: <b>{{ $email }}</b></p>

            @if (session('success'))
                <div class="alert alert-success border-0 rounded-4 mb-4 small text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-4 mb-4 small">
                    @foreach ($errors->all() as $error) {{ $error }} @endforeach
                </div>
            @endif

            <form action="{{ route('reset.password.post') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                
                <div class="mb-4">
                    <label class="form-label small fw-600">Mã OTP (6 số)</label>
                    <input type="text" name="otp" class="form-control otp-input" maxlength="6" required autocomplete="off">
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-600">Mật khẩu mới</label>
                    <input type="password" name="newPassword" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-600">Xác nhận mật khẩu</label>
                    <input type="password" name="newPassword_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold mb-4">
                    ĐẶT LẠI MẬT KHẨU <i class="bi bi-check-circle ms-2"></i>
                </button>
            </form>

            <div class="text-center">
                <a href="{{ route('forgot.password') }}" class="text-muted small text-decoration-none">Gửi lại mã OTP</a>
            </div>
        </div>
    </div>
</body>
</html>
