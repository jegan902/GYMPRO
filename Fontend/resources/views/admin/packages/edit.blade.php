@extends('layouts.admin')

@section('title', 'Chỉnh sửa: ' . $package['name'])

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }

    .form-card { background: white; border-radius: 20px; border: 1px solid #e2e8f0; padding: 30px; }
    .section-title {
        font-size: 14px; font-weight: 800; color: #1e293b; text-transform: uppercase;
        letter-spacing: 0.5px; margin-bottom: 20px; padding-bottom: 8px;
        border-bottom: 2px solid #f1f5f9; display: flex; align-items: center; gap: 8px;
    }
    .form-label { font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px; }
    .form-control, .form-select {
        border-radius: 10px; border: 1px solid #cbd5e1; padding: 10px 14px;
        font-size: 13.5px; transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(255,94,0,0.15); }
    .btn-submit {
        background: var(--primary-color); color: white; font-weight: 700; font-size: 13.5px;
        padding: 12px 24px; border-radius: 10px; border: none;
        box-shadow: 0 10px 15px -3px rgba(255,94,0,0.25); transition: all 0.3s;
    }
    .btn-submit:hover { background: var(--secondary-color); transform: translateY(-1px); }
    .btn-cancel {
        background: #f1f5f9; color: #475569; font-weight: 700; font-size: 13.5px;
        padding: 12px 24px; border-radius: 10px; border: none; text-decoration: none !important;
    }
    .btn-cancel:hover { background: #e2e8f0; color: #1e293b; }
    .price-preview {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        color: white; border-radius: 16px; padding: 20px; text-align: center;
    }
    .price-preview .price-num { font-size: 32px; font-weight: 800; }
    .price-preview .price-per { font-size: 12px; color: #94a3b8; }
</style>

<div class="container-fluid py-4">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.packages.show', $package['id']) }}" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;padding:0;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h5 class="fw-bold mb-0">Chỉnh Sửa Gói Tập</h5>
            <p class="text-muted small mb-0">Cập nhật thông tin, giá và quyền lợi gói <b>{{ $package['name'] }}</b>.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4" style="background:#fef2f2; color:#b91c1c;">
            <ul class="mb-0 px-3 small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.packages.update', $package['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="form-card">
                    <div class="section-title"><i class="bi bi-box-seam text-primary"></i> 1. Thông tin cơ bản</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="form-label">Tên gói tập <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="pkgName" class="form-control" value="{{ old('name', $package['name']) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Thời hạn (ngày) <span class="text-danger">*</span></label>
                            <input type="number" name="duration" id="pkgDuration" class="form-control" value="{{ old('duration', $package['duration']) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Giá niêm yết (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="pkgPrice" class="form-control" value="{{ old('price', $package['price']) }}" required>
                        </div>
                    </div>

                    <div class="section-title"><i class="bi bi-stars text-warning"></i> 2. Mô tả & Quyền lợi</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="form-label">Mô tả gói tập</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $package['description']) }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Tính năng / Quyền lợi <span class="text-muted">(Phân tách bằng dấu phẩy)</span></label>
                            <textarea name="features" class="form-control" rows="2">{{ old('features', $package['features']) }}</textarea>
                        </div>
                    </div>

                    <div class="section-title"><i class="bi bi-toggle-on text-success"></i> 3. Cấu hình</div>
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="isActive" name="isActive" value="1" {{ old('isActive', $package['isActive']) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="isActive">Kích hoạt gói tập</label>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('admin.packages.show', $package['id']) }}" class="btn-cancel">Hủy bỏ</a>
                        <button type="submit" class="btn-submit"><i class="bi bi-check-all me-1"></i> Lưu thay đổi</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="price-preview">
                    <div class="text-uppercase small fw-bold mb-2" style="color:#94a3b8; letter-spacing:1px;">Preview giá</div>
                    <div class="price-num" id="previewPrice">0 ₫</div>
                    <div class="price-per" id="previewPerDay">-- ₫/ngày</div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceIn = document.getElementById('pkgPrice');
    const durationIn = document.getElementById('pkgDuration');
    const previewPrice = document.getElementById('previewPrice');
    const previewPerDay = document.getElementById('previewPerDay');

    function updatePreview() {
        const price = parseFloat(priceIn.value) || 0;
        const duration = parseInt(durationIn.value) || 0;
        previewPrice.textContent = price.toLocaleString('vi-VN') + ' ₫';
        previewPerDay.textContent = duration > 0 ? Math.round(price / duration).toLocaleString('vi-VN') + ' ₫/ngày' : '-- ₫/ngày';
    }
    priceIn.addEventListener('input', updatePreview);
    durationIn.addEventListener('input', updatePreview);
    updatePreview();
});
</script>
@endpush
@endsection
