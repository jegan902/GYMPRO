@extends('layouts.admin')

@section('title', 'Chi tiết: ' . $package['name'])

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }

    .detail-card { background: white; border-radius: 20px; border: 1px solid #e2e8f0; padding: 28px; margin-bottom: 24px; }

    .pkg-hero {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 20px; padding: 32px; color: white; position: relative; overflow: hidden;
    }
    .pkg-hero::after {
        content: ''; position: absolute; top: -40px; right: -40px; width: 200px; height: 200px;
        border-radius: 50%; background: rgba(255,122,0,0.12);
    }
    .pkg-hero .hero-price { font-size: 36px; font-weight: 800; }
    .pkg-hero .hero-per-day { font-size: 13px; color: #94a3b8; }
    .pkg-hero .hero-name { font-size: 22px; font-weight: 800; }

    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f8fafc; }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: 12px; color: #64748b; font-weight: 600; }
    .info-val { font-size: 13px; color: #0f172a; font-weight: 700; }

    .feature-list { list-style: none; padding: 0; margin: 0; }
    .feature-list li {
        padding: 8px 0; border-bottom: 1px solid #f8fafc; font-size: 13px; color: #334155;
        display: flex; align-items: center; gap: 8px;
    }
    .feature-list li::before { content: '✓'; color: #10b981; font-weight: 800; font-size: 14px; }

    .sub-table th {
        font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;
        letter-spacing: 0.5px; border-bottom: 2px solid #f1f5f9; padding: 10px 14px;
    }
    .sub-table td { padding: 12px 14px; font-size: 13px; color: #334155; vertical-align: middle; border-bottom: 1px solid #f8fafc; }
    .sub-table tbody tr:hover { background: #fafbfd; }

    .badge-sub-active { background: #d1fae5; color: #065f46; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; }
    .badge-sub-expired { background: #fee2e2; color: #991b1b; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; }
    .badge-sub-cancelled { background: #f1f5f9; color: #64748b; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; }
    .badge-sub-pending { background: #ffedd5; color: #9a3412; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; }
    .badge-paid { background: #d1fae5; color: #065f46; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 20px; }
    .badge-unpaid { background: #fef3c7; color: #92400e; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 20px; }

    .btn-assign {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white !important; font-weight: 700; font-size: 13px;
        padding: 10px 20px; border-radius: 12px; border: none;
        box-shadow: 0 8px 16px rgba(16,185,129,0.2); transition: all 0.3s;
    }
    .btn-assign:hover { transform: translateY(-1px); box-shadow: 0 10px 20px rgba(16,185,129,0.3); }

    .modal-content { border-radius: 20px; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
    .modal-header { border-bottom: 1px solid #f1f5f9; padding: 24px 28px; }
    .modal-body { padding: 28px; }
    .modal-footer { border-top: 1px solid #f1f5f9; padding: 18px 28px; }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.packages') }}" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;padding:0;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Chi tiết Gói Tập</h5>
                <p class="text-muted small mb-0">Quản lý đăng ký, phân bổ hội viên và theo dõi thanh toán.</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.packages.edit', $package['id']) }}" class="btn btn-outline-dark rounded-3 px-3 py-2 fw-bold me-2">
                <i class="bi bi-pencil me-1"></i> Chỉnh sửa
            </a>
            <button class="btn-assign" data-bs-toggle="modal" data-bs-target="#assignModal">
                <i class="bi bi-person-plus-fill me-1"></i> Đăng ký cho Hội viên
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 rounded-4 shadow-sm" style="background:#ecfdf5; color:#047857;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 rounded-4 shadow-sm" style="background:#fef2f2; color:#b91c1c;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Left: Package Info -->
        <div class="col-lg-4">
            <div class="pkg-hero mb-4">
                <div class="hero-name mb-2">{{ $package['name'] }}</div>
                <div class="hero-price">{{ number_format($package['price'], 0, ',', '.') }} <span style="font-size:16px;">₫</span></div>
                @php $perDay = $package['duration'] > 0 ? round($package['price'] / $package['duration']) : 0; @endphp
                <div class="hero-per-day mt-1">≈ {{ number_format($perDay, 0, ',', '.') }}₫/ngày · {{ $package['duration'] }} ngày</div>
                <div class="mt-3">
                    @if($package['isActive'])
                        <span class="badge-sub-active">🟢 Đang hoạt động</span>
                    @else
                        <span class="badge-sub-cancelled">⚪ Tạm ngừng</span>
                    @endif
                </div>
            </div>

            <div class="detail-card">
                <div class="small text-uppercase fw-bold text-muted mb-3" style="font-size:11px; letter-spacing:0.5px;">Thông tin chi tiết</div>
                <div class="info-row"><span class="info-label">Mã gói</span><span class="info-val">#PKG-{{ sprintf('%04d', $package['id']) }}</span></div>
                <div class="info-row"><span class="info-label">Thời hạn</span><span class="info-val">{{ $package['duration'] }} ngày (≈ {{ round($package['duration']/30, 1) }} tháng)</span></div>
                <div class="info-row"><span class="info-label">HV đang dùng</span><span class="info-val text-primary">{{ $package['activeSubscriptions'] ?? 0 }} hội viên</span></div>
                <div class="info-row"><span class="info-label">Ngày tạo</span><span class="info-val">{{ \Carbon\Carbon::parse($package['createdAt'])->format('d/m/Y') }}</span></div>
            </div>

            @if($package['description'])
                <div class="detail-card">
                    <div class="small text-uppercase fw-bold text-muted mb-2" style="font-size:11px; letter-spacing:0.5px;">Mô tả</div>
                    <p class="text-dark small mb-0">{{ $package['description'] }}</p>
                </div>
            @endif

            @if($package['features'])
                <div class="detail-card">
                    <div class="small text-uppercase fw-bold text-muted mb-2" style="font-size:11px; letter-spacing:0.5px;">Quyền lợi</div>
                    <ul class="feature-list">
                        @foreach(explode(',', $package['features']) as $f)
                            <li>{{ trim($f) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Right: Subscriptions List -->
        <div class="col-lg-8">
            <div class="detail-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-people text-primary me-2"></i>Danh sách Đăng ký ({{ count($package['subscriptions'] ?? []) }})</h6>
                </div>

                @if(empty($package['subscriptions']))
                    <div class="text-center py-5">
                        <i class="bi bi-people text-muted" style="font-size:48px; opacity:0.3;"></i>
                        <p class="text-muted mt-3 mb-0">Chưa có hội viên nào đăng ký gói tập này.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table sub-table mb-0">
                            <thead>
                                <tr>
                                    <th>Hội viên</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày hết hạn</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Thanh toán</th>
                                    <th class="text-end">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($package['subscriptions'] as $sub)
                                    @php
                                        $daysLeft = $sub['endDate'] ? \Carbon\Carbon::parse($sub['endDate'])->diffInDays(now(), false) : 0;
                                        $isExpiring = $sub['endDate'] && \Carbon\Carbon::parse($sub['endDate'])->diffInDays(now()) <= 7 && $sub['status'] == 'active';
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $sub['memberName'] }}</div>
                                            <div class="text-muted" style="font-size:11px;">ID: #MEM-{{ sprintf('%04d', $sub['memberId']) }}</div>
                                        </td>
                                        <td>{{ $sub['startDate'] ? \Carbon\Carbon::parse($sub['startDate'])->format('d/m/Y') : '--' }}</td>
                                        <td>
                                            {{ $sub['endDate'] ? \Carbon\Carbon::parse($sub['endDate'])->format('d/m/Y') : '--' }}
                                            @if($isExpiring)
                                                <br><span class="text-danger small fw-bold"><i class="bi bi-exclamation-triangle"></i> Sắp hết hạn</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($sub['status'] == 'active')
                                                <span class="badge-sub-active">Active</span>
                                            @elseif($sub['status'] == 'expired')
                                                <span class="badge-sub-expired">Expired</span>
                                            @elseif($sub['status'] == 'cancelled')
                                                <span class="badge-sub-cancelled">Cancelled</span>
                                            @else
                                                <span class="badge-sub-pending">Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($sub['paymentStatus'] == 'paid')
                                                <span class="badge-paid">Đã thu</span>
                                            @else
                                                <span class="badge-unpaid">Chưa thu</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if($sub['status'] == 'active')
                                                <form action="{{ route('admin.packages.subscription.cancel', $sub['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Hủy đăng ký gói tập cho hội viên này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-3" title="Hủy đăng ký"><i class="bi bi-x-circle"></i></button>
                                                </form>
                                            @else
                                                <span class="text-muted small">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal: Assign package to member -->
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.packages.subscription.assign', $package['id']) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill text-success me-2"></i>Đăng ký gói: {{ $package['name'] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded-3 p-3 mb-3 border d-flex justify-content-between align-items-center">
                        <span class="small fw-bold text-dark">{{ $package['name'] }} · {{ $package['duration'] }} ngày</span>
                        <span class="fw-bold text-primary">{{ number_format($package['price'], 0, ',', '.') }}₫</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Chọn Hội viên <span class="text-danger">*</span></label>
                            <select name="memberId" class="form-select" required>
                                <option value="">-- Chọn hội viên --</option>
                                @foreach($members as $m)
                                    <option value="{{ $m['id'] }}">{{ $m['fullName'] }} ({{ $m['email'] ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ngày bắt đầu</label>
                            <input type="date" name="startDate" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Trạng thái thanh toán</label>
                            <select name="paymentStatus" class="form-select">
                                <option value="pending">🟠 Chưa thanh toán</option>
                                <option value="paid">🟢 Đã thanh toán</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-3 fw-bold px-3 py-2" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn-assign py-2">Xác nhận Đăng ký</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
