@extends('layouts.admin')

@section('title', 'Quản lý Hội viên')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
    }

    .header-title {
        color: var(--primary-color);
        font-weight: 800;
        font-size: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 2px;
    }

    .header-desc {
        color: #64748B;
        font-size: 12px;
        margin-bottom: 0;
        font-weight: 600;
    }

    .metric-card {
        background: #fff;
        padding: 16px 20px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s;
    }

    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }

    .metric-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .metric-value {
        font-size: 20px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 0;
        line-height: 1.2;
    }

    .metric-label {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-add-member {
        background: var(--primary-color);
        color: white !important;
        font-weight: 700;
        font-size: 12px;
        padding: 8px 16px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none !important;
        box-shadow: 0 4px 10px rgba(255, 94, 0, 0.2);
        transition: all 0.3s;
    }

    .btn-add-member:hover {
        background: var(--secondary-color);
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(255, 94, 0, 0.3);
    }

    .filter-bar {
        background: white;
        border-radius: 12px;
        padding: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 16px;
    }

    .member-table {
        background: white;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .member-table thead th {
        padding: 12px 16px !important;
        color: #475569;
        font-size: 11px !important;
        font-weight: 800;
        text-transform: uppercase;
        border-bottom: 1px solid #f1f5f9;
        letter-spacing: 0.5px;
    }

    .member-table tbody td {
        padding: 10px 16px !important;
        vertical-align: middle;
        border-bottom: 1px solid #f8fafc;
        font-size: 13px;
        color: #334155;
    }

    .member-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #e2e8f0;
    }

    .bmi-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .bmi-underweight { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .bmi-normal { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .bmi-overweight { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .bmi-obese { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

    .status-badge {
        font-size: 10px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
    }

    .status-active { background: #ecfdf5; color: #059669; }
    .status-expired { background: #fef2f2; color: #dc2626; }
    .status-pending { background: #fff7ed; color: #ea580c; }

    .action-btn {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        margin-left: 4px;
        font-size: 12px;
        transition: all 0.2s;
        background: white;
        color: #64748b;
        text-decoration: none !important;
    }

    .action-btn:hover {
        background: #f8fafc;
        transform: scale(1.05);
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .action-btn.delete:hover {
        color: #ef4444;
        border-color: #fca5a5;
        background: #fef2f2;
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <div class="header-title">
                <i class="bi bi-people-fill"></i> Quản lý Hội viên
            </div>
            <p class="header-desc">Hệ thống quản lý hồ sơ, thẻ tập, và chỉ số sức khỏe sinh học của hội viên.</p>
        </div>
        <a href="{{ route('admin.members.create') }}" class="btn-add-member">
            <i class="bi bi-person-plus-fill"></i> Thêm hội viên
        </a>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 rounded-4 shadow-sm" role="alert" style="background:#ecfdf5; color:#047857;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 rounded-4 shadow-sm" role="alert" style="background:#fef2f2; color:#b91c1c;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Metrics Row -->
    @php
        $totalMembers = count($members);
        $activeMembers = collect($members)->where('status', 'active')->count();
        $expiredMembers = collect($members)->where('status', 'expired')->count();
        $averageBmi = collect($members)->where('bmi', '>', 0)->avg('bmi');
    @endphp
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="metric-card">
                <div class="metric-icon" style="background: #eff6ff; color: #2563eb;">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="metric-label">Tổng Hội Viên</div>
                    <div class="metric-value">{{ $totalMembers }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card">
                <div class="metric-icon" style="background: #ecfdf5; color: #059669;">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div>
                    <div class="metric-label">Đang Hoạt Động</div>
                    <div class="metric-value">{{ $activeMembers }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card">
                <div class="metric-icon" style="background: #fef2f2; color: #dc2626;">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div>
                    <div class="metric-label">Hết Hạn / Khóa</div>
                    <div class="metric-value">{{ $expiredMembers }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card">
                <div class="metric-icon" style="background: #fff7ed; color: #ea580c;">
                    <i class="bi bi-heart-pulse"></i>
                </div>
                <div>
                    <div class="metric-label">BMI Trung Bình</div>
                    <div class="metric-value">{{ number_format($averageBmi ?? 22.4, 1) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <form action="{{ route('admin.members') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Tìm tên, email, SĐT, CCCD..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="branchId" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
                    <option value="">Tất cả chi nhánh</option>
                    @foreach($branches as $b)
                        @php
                            $bId = data_get($b, 'id') ?? data_get($b, 'Id');
                            $bName = data_get($b, 'name') ?? data_get($b, 'Name');
                        @endphp
                        <option value="{{ $bId }}" {{ request('branchId') == $bId ? 'selected' : '' }}>📍 {{ $bName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>🟢 Hoạt động</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>🟠 Đang chờ</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>🔴 Hết hạn/Khóa</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-sm btn-dark fw-bold rounded-3">Áp dụng</button>
            </div>
        </form>
    </div>

    <!-- Members Table Card -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
        <div class="table-responsive">
            <table class="table member-table mb-0">
                <thead>
                    <tr>
                        <th>Hội viên</th>
                        <th>Chi nhánh</th>
                        <th class="text-center">Chiều cao/Nặng</th>
                        <th class="text-center">Chỉ số BMI</th>
                        <th class="text-center">Số buổi PT</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Ngày gia nhập</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $m)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @php
                                        $avatar = $m['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($m['fullName']) . '&background=FF5E00&color=fff';
                                    @endphp
                                    <img src="{{ $avatar }}" class="member-avatar" alt="Avatar">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $m['fullName'] }}</div>
                                        <div class="text-muted small" style="font-size: 11px;">
                                            <i class="bi bi-envelope me-1"></i>{{ $m['email'] }} <br>
                                            <i class="bi bi-telephone me-1"></i>{{ $m['phone'] ?? 'Chưa cập nhật' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1" style="font-size:11px;">
                                    📍 {{ $m['branchName'] ?? 'Không rõ' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($m['height'] && $m['weight'])
                                    <span class="fw-bold">{{ $m['height'] }} cm</span> <br>
                                    <span class="text-muted small">{{ $m['weight'] }} kg</span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($m['bmi'])
                                    @php
                                        $bmi = $m['bmi'];
                                        $class = 'bmi-normal';
                                        $label = 'Bình thường';
                                        if ($bmi < 18.5) {
                                            $class = 'bmi-underweight';
                                            $label = 'Gầy';
                                        } elseif ($bmi >= 25 && $bmi < 30) {
                                            $class = 'bmi-overweight';
                                            $label = 'Thừa cân';
                                        } elseif ($bmi >= 30) {
                                            $class = 'bmi-obese';
                                            $label = 'Béo phì';
                                        }
                                    @endphp
                                    <span class="bmi-badge {{ $class }}">
                                        {{ $bmi }} <small>({{ $label }})</small>
                                    </span>
                                @else
                                    <span class="text-muted small">Chưa đo</span>
                                @endif
                            </td>
                            <td class="text-center fw-bold text-dark">
                                {{ $m['ptSessions'] }}
                            </td>
                            <td class="text-center">
                                <span class="status-badge status-{{ $m['status'] }}">
                                    @if($m['status'] == 'active')
                                        Hoạt động
                                    @elseif($m['status'] == 'pending')
                                        Chờ duyệt
                                    @else
                                        Khóa/Hết hạn
                                    @endif
                                </span>
                            </td>
                            <td class="text-center text-muted small">
                                {{ \Carbon\Carbon::parse($m['joinDate'])->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.members.show', $m['id']) }}" class="action-btn" title="Chi tiết sức khỏe AI">
                                    <i class="bi bi-activity text-primary"></i>
                                </a>
                                <a href="{{ route('admin.members.edit', $m['id']) }}" class="action-btn" title="Chỉnh sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.members.destroy', $m['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa hội viên này khỏi hệ thống?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-people-fill display-4 d-block mb-3 opacity-25"></i>
                                Không tìm thấy hội viên nào khớp với bộ lọc.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
