@extends('layouts.admin')

@section('title', 'Quản lý Gói Tập')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }

    .revenue-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        transition: all 0.3s;
    }
    .revenue-card:hover { transform: translateY(-3px); box-shadow: 0 12px 24px -8px rgba(0,0,0,0.06); }
    .revenue-card .icon-circle {
        width: 48px; height: 48px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
    }
    .revenue-card .stat-val { font-size: 28px; font-weight: 800; color: #0f172a; line-height: 1.1; }
    .revenue-card .stat-lbl { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }

    .pkg-table-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 24px;
    }

    .pkg-table th {
        font-size: 11px; font-weight: 800; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.5px;
        border-bottom: 2px solid #f1f5f9; padding: 12px 16px;
    }
    .pkg-table td {
        padding: 14px 16px; font-size: 13px; color: #334155;
        vertical-align: middle; border-bottom: 1px solid #f8fafc;
    }
    .pkg-table tbody tr:hover { background: #fafbfd; }

    .price-tag {
        font-size: 15px; font-weight: 800; color: #0f172a;
    }
    .price-currency { font-size: 11px; font-weight: 600; color: #94a3b8; }

    .badge-pkg-active { background: #d1fae5; color: #065f46; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; }
    .badge-pkg-inactive { background: #f1f5f9; color: #64748b; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; }
    .badge-duration { background: #eff6ff; color: #1d4ed8; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; }

    .btn-add-pkg {
        background: linear-gradient(135deg, #FF7A00 0%, #FF4D00 100%);
        color: white !important; font-weight: 700; font-size: 13px;
        padding: 10px 20px; border-radius: 12px; border: none;
        box-shadow: 0 10px 20px rgba(255,94,0,0.2); transition: all 0.3s;
        text-decoration: none !important;
    }
    .btn-add-pkg:hover { transform: translateY(-1px); box-shadow: 0 12px 24px rgba(255,94,0,0.3); }

    .feature-pills { display: flex; flex-wrap: wrap; gap: 4px; }
    .feature-pill {
        background: #f1f5f9; color: #475569; font-size: 10px; font-weight: 700;
        padding: 3px 8px; border-radius: 6px; white-space: nowrap;
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-0">Quản Lý Gói Tập & Doanh Thu</h5>
            <p class="text-muted small mb-0">Thiết lập gói membership, theo dõi doanh thu và phân bổ cho hội viên.</p>
        </div>
        <a href="{{ route('admin.packages.create') }}" class="btn-add-pkg">
            <i class="bi bi-plus-lg me-1"></i> Tạo gói tập mới
        </a>
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

    <!-- Revenue Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="revenue-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-circle" style="background:#eff6ff; color:#3b82f6;"><i class="bi bi-box-seam"></i></div>
                    <div>
                        <div class="stat-lbl">Tổng gói tập</div>
                        <div class="stat-val">{{ $stats['totalPackages'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="revenue-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-circle" style="background:#ecfdf5; color:#10b981;"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <div class="stat-lbl">Đăng ký đang hoạt động</div>
                        <div class="stat-val">{{ $stats['activeSubscriptions'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="revenue-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-circle" style="background:#fef3c7; color:#f59e0b;"><i class="bi bi-cash-stack"></i></div>
                    <div>
                        <div class="stat-lbl">Doanh thu đã thu</div>
                        <div class="stat-val" style="font-size:22px;">{{ number_format($stats['totalRevenue'], 0, ',', '.') }}<span class="price-currency ms-1">₫</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="revenue-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-circle" style="background:#fef2f2; color:#ef4444;"><i class="bi bi-hourglass-split"></i></div>
                    <div>
                        <div class="stat-lbl">Công nợ chờ thu</div>
                        <div class="stat-val" style="font-size:22px;">{{ number_format($stats['pendingRevenue'], 0, ',', '.') }}<span class="price-currency ms-1">₫</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Packages Table -->
    <div class="pkg-table-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-dark mb-0"><i class="bi bi-grid-3x3-gap-fill text-primary me-2"></i>Danh sách Gói Tập ({{ count($packages) }})</h6>
        </div>

        @if(count($packages) === 0)
            <div class="text-center py-5">
                <i class="bi bi-box-seam text-muted" style="font-size:48px; opacity:0.3;"></i>
                <p class="text-muted mt-3 mb-0">Chưa có gói tập nào. Nhấn <b>"Tạo gói tập mới"</b> để bắt đầu.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table pkg-table mb-0">
                    <thead>
                        <tr>
                            <th>Gói tập</th>
                            <th>Thời hạn</th>
                            <th>Giá niêm yết</th>
                            <th>Tính năng</th>
                            <th class="text-center">HV đang dùng</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $pkg)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $pkg['name'] }}</div>
                                    @if($pkg['description'])
                                        <div class="text-muted" style="font-size:11px;">{{ \Illuminate\Support\Str::limit($pkg['description'], 50) }}</div>
                                    @endif
                                </td>
                                <td><span class="badge-duration">{{ $pkg['duration'] }} ngày</span></td>
                                <td>
                                    <span class="price-tag">{{ number_format($pkg['price'], 0, ',', '.') }}</span>
                                    <span class="price-currency">₫</span>
                                </td>
                                <td>
                                    @if($pkg['features'])
                                        <div class="feature-pills">
                                            @foreach(array_slice(explode(',', $pkg['features']), 0, 3) as $f)
                                                <span class="feature-pill">{{ trim($f) }}</span>
                                            @endforeach
                                            @if(count(explode(',', $pkg['features'])) > 3)
                                                <span class="feature-pill" style="background:#e0e7ff; color:#4f46e5;">+{{ count(explode(',', $pkg['features'])) - 3 }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-dark">{{ $pkg['activeSubscriptions'] ?? 0 }}</span>
                                </td>
                                <td class="text-center">
                                    @if($pkg['isActive'])
                                        <span class="badge-pkg-active">Hoạt động</span>
                                    @else
                                        <span class="badge-pkg-inactive">Tạm ngừng</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('admin.packages.show', $pkg['id']) }}" class="btn btn-sm btn-outline-primary border-0 rounded-3" title="Chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.packages.edit', $pkg['id']) }}" class="btn btn-sm btn-outline-dark border-0 rounded-3" title="Sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.packages.toggle', $pkg['id']) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning border-0 rounded-3" title="{{ $pkg['isActive'] ? 'Tạm ngừng' : 'Kích hoạt' }}">
                                                <i class="bi {{ $pkg['isActive'] ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.packages.destroy', $pkg['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa gói tập này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-3" title="Xóa">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
