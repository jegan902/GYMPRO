<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HLV <?= htmlspecialchars($trainer['name']) ?> - GYMPRO Trainers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= URL_ROOT ?>/css/style.css">
</head>
<body class="landing-body bg-light">

    <!-- Navbar Minimal -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= URL_ROOT ?>/">
                <i class="bi bi-lightning-charge-fill text-primary"></i>
                GYM<strong>PRO</strong>
            </a>
            <div class="ms-auto">
                <a class="btn btn-outline-dark btn-sm" href="<?= URL_ROOT ?>/"><i class="bi bi-arrow-left me-2"></i> Về trang chủ</a>
            </div>
        </div>
    </nav>

    <!-- Profile Section -->
    <div class="container py-5">
        <div class="bg-white rounded-4 shadow-sm border overflow-hidden">
            <div class="row g-0">
                <!-- Image Side -->
                <div class="col-lg-5">
                    <img src="<?= htmlspecialchars($trainer['image']) ?>" alt="<?= htmlspecialchars($trainer['name']) ?>" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 500px;">
                </div>
                <!-- Content Side -->
                <div class="col-lg-7 p-4 p-md-5">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-primary px-3 py-2 rounded-pill me-3"><?= htmlspecialchars($trainer['title']) ?></span>
                        <span class="text-muted"><i class="bi bi-briefcase-fill me-1"></i> <?= htmlspecialchars($trainer['experience']) ?> kinh nghiệm</span>
                    </div>
                    
                    <h1 class="fw-bold display-5 mb-1" style="color: #1A1A2E;"><?= htmlspecialchars($trainer['name']) ?></h1>
                    <p class="fs-4 text-primary fw-medium mb-4"><?= htmlspecialchars($trainer['role']) ?></p>

                    <hr class="mb-4">

                    <!-- Info Grid -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3"><i class="bi bi-award-fill text-warning me-2"></i> Chứng Chỉ Quốc Tế</h5>
                            <ul class="list-unstyled text-muted">
                                <?php foreach($trainer['certifications'] as $cert): ?>
                                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> <?= htmlspecialchars($cert) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3"><i class="bi bi-star-fill text-warning me-2"></i> Lĩnh Vực Chuyên Môn</h5>
                            <ul class="list-unstyled text-muted">
                                <?php foreach($trainer['specialties'] as $spec): ?>
                                    <li class="mb-2"><i class="bi bi-lightning-fill text-primary me-2"></i> <?= htmlspecialchars($spec) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Philosophy -->
                    <div class="bg-light p-4 rounded-4 mb-4 border border-primary border-opacity-25">
                        <h5 class="fw-bold text-dark mb-3">Triết lý Huấn Luyện</h5>
                        <p class="text-muted fst-italic mb-0" style="line-height: 1.7;">
                            <?= htmlspecialchars($trainer['philosophy']) ?>
                        </p>
                    </div>

                    <p class="fs-5 text-dark fw-bold mb-4 border-start border-4 border-primary ps-3 py-1">
                        <?= htmlspecialchars($trainer['quote']) ?>
                    </p>

                    <!-- CTA -->
                    <div class="mt-5">
                        <a href="<?= URL_ROOT ?>/auth/register" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm">
                            <i class="bi bi-calendar-check me-2"></i> Đăng Ký Tập Với <?= htmlspecialchars($trainer['name']) ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-4">
        <div class="container text-center">
            <p class="mb-0 opacity-75">&copy; <?= date('Y') ?> GYMPRO SYSTEM. Xây Dựng Bản Thân.</p>
        </div>
    </footer>

</body>
</html>
