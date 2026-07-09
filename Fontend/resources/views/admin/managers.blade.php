@extends('layouts.admin')

@section('title', 'Quản Lý Nhân Sự')

@push('styles')
<style>
    .table-glass {
        color: var(--text-main);
        vertical-align: middle;
    }
    
    .table-glass th {
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--border-color);
        padding: 15px;
    }

    .table-glass td {
        background: transparent;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 15px;
        color: #475569;
    }

    .table-glass tbody tr:hover td {
        background: rgba(0, 0, 0, 0.02);
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show animate-fade-in" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show animate-fade-in" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--text-main);"><i class="bi bi-person-badge me-2 text-primary-orange"></i> Quản Lý Nhân Sự</h2>
            <p class="text-muted mb-0">Quản trị tối cao: Quản lý danh sách quản lý chi nhánh và nhân viên hệ thống.</p>
        </div>
        <div>
            <button class="btn fw-bold shadow-sm text-white" onclick="openManagerModal()" style="background-color: var(--primary-color); border: none; border-radius: 4px; padding: 10px 20px;">
                <i class="bi bi-person-plus-fill me-2"></i> Thêm Nhân Sự
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.2s; background: white; border-radius: 8px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-glass mb-0">
                <thead>
                    <tr style="background: #F8FAFC;">
                        <th style="border-bottom: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 16px;">ID</th>
                        <th style="border-bottom: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 16px;">Nhân Viên</th>
                        <th style="border-bottom: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 16px;">Vai Trò</th>
                        <th style="border-bottom: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 16px;">Chi Nhánh</th>
                        <th style="border-bottom: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 16px;">Trạng Thái</th>
                        <th style="border-bottom: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 16px;" class="text-end">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($managers as $manager)
                    <tr>
                        <td class="fw-bold text-muted" style="padding: 16px;">#{{ str_pad($manager['id'], 3, '0', STR_PAD_LEFT) }}</td>
                        <td style="padding: 16px;">
                            <div class="d-flex align-items-center gap-3">
                                @php
                                    $avatar = $manager['avatar'] ?? ('https://ui-avatars.com/api/?name=' . urlencode($manager['full_name']) . '&background=FF5E00&color=fff');
                                    if (str_starts_with($avatar, '/')) {
                                        $avatar = config('services.backend.url_base') . $avatar;
                                    }
                                @endphp
                                <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle" width="38" height="38" style="object-fit: cover; border: 1px solid var(--border-color);">
                                <div>
                                    <div class="fw-bold" style="color: var(--text-main);">{{ !empty($manager['full_name']) ? $manager['full_name'] : 'Quản trị viên' }}</div>
                                    <div class="small text-muted">{{ $manager['email'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 16px;">
                            <span class="badge {{ $manager['role_name'] == 'Super Admin' ? 'bg-warning text-dark' : 'bg-info text-white' }} p-2">
                                <i class="bi bi-shield-lock me-1"></i> {{ $manager['role_name'] }}
                            </span>
                        </td>
                        <td style="padding: 16px;">
                            <div style="color: var(--text-main);"><i class="bi bi-building me-1 text-primary-orange"></i> {{ $manager['branch_name'] }}</div>
                        </td>
                        <td style="padding: 16px;">
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input" type="checkbox" role="switch" id="switch{{ $manager['id'] }}" 
                                    {{ $manager['is_active'] ? 'checked' : '' }}
                                    onchange="toggleManagerStatus({{ $manager['id'] }}, this.checked)">
                                <label class="form-check-label ms-2 small" for="switch{{ $manager['id'] }}" id="label{{ $manager['id'] }}" style="margin-top: 2px;">
                                    {!! $manager['is_active'] ? '<span class="text-success fw-bold" style="font-size: 0.8rem;">Đang hoạt động</span>' : '<span class="text-danger fw-bold" style="font-size: 0.8rem;">Tạm ngưng</span>' !!}
                                </label>
                            </div>
                        </td>
                        <td class="text-end" style="padding: 16px;">
                            <button class="btn btn-sm btn-outline-secondary rounded-circle p-2" 
                                onclick="openManagerModal({{ json_encode($manager) }})" title="Chỉnh sửa">
                                <i class="bi bi-pencil text-info"></i>
                            </button>
                            @if(session('user_email') != $manager['email'])
                            <form action="{{ route('admin.managers.delete', $manager['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân sự này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-2 ms-1" title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Thêm/Sửa Quản Lý -->
<div class="modal fade" id="managerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #FFFFFF; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-main); box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="modalTitle">Thêm Quản Lý Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="managerForm" method="POST" action="{{ route('admin.managers.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control text-dark border-secondary-subtle" name="full_name" id="managerFullName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control text-dark border-secondary-subtle" name="email" id="managerEmail" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Mật khẩu <span id="pwdLabel" class="text-danger small font-monospace"></span></label>
                        <input type="password" class="form-control text-dark border-secondary-subtle" name="password" id="managerPassword" placeholder="Nhập để đặt mật khẩu mới...">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Vai trò</label>
                            <select class="form-select text-dark border-secondary-subtle" name="role_id" id="managerRoleId">
                                @foreach($roles ?? [] as $role)
                                    @php
                                        $rId = data_get($role, 'id') ?? data_get($role, 'Id');
                                        $rName = data_get($role, 'name') ?? data_get($role, 'Name');
                                    @endphp
                                    <option value="{{ $rId }}">{{ $rName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Chi nhánh</label>
                            <select class="form-select text-dark border-secondary-subtle" name="branch_id" id="managerBranchId">
                                <option value="">-- Tất cả chi nhánh --</option>
                                @foreach($branches ?? [] as $branch)
                                    @php
                                        $bId = data_get($branch, 'id') ?? data_get($branch, 'Id');
                                        $bName = data_get($branch, 'name') ?? data_get($branch, 'Name');
                                    @endphp
                                    <option value="{{ $bId }}">{{ $bName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-check form-switch mt-3 fs-6">
                        <input class="form-check-input" type="checkbox" role="switch" id="managerStatus" name="is_active" checked>
                        <label class="form-check-label ms-2 text-dark" for="managerStatus" style="font-size: 0.95rem;">Đang hoạt động</label>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn fw-bold text-white" style="background-color: var(--primary-color); border:none;"><i class="bi bi-save me-1"></i> Lưu Nhân Sự</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const managerModal = new bootstrap.Modal(document.getElementById('managerModal'));
    
    function openManagerModal(manager = null) {
        const form = document.getElementById('managerForm');
        const title = document.getElementById('modalTitle');
        const methodInput = document.getElementById('formMethod');
        const pwdLabel = document.getElementById('pwdLabel');
        
        if (manager) {
            title.innerText = 'Cập nhật: ' + manager.full_name;
            form.action = `/admin/managers/${manager.id}`;
            methodInput.value = 'PUT';
            pwdLabel.innerText = '(Để trống nếu không đổi)';
            
            document.getElementById('managerFullName').value = manager.full_name;
            document.getElementById('managerEmail').value = manager.email;
            document.getElementById('managerPassword').value = '';
            document.getElementById('managerRoleId').value = manager.role_id;
            document.getElementById('managerBranchId').value = manager.branch_id || '';
            document.getElementById('managerStatus').checked = manager.is_active;
        } else {
            title.innerText = 'Thêm Quản Lý Mới';
            form.action = '{{ route("admin.managers.store") }}';
            methodInput.value = 'POST';
            pwdLabel.innerText = '(Mặc định: 123456)';
            
            form.reset();
            document.getElementById('managerStatus').checked = true;
        }
        
        managerModal.show();
    }

    function toggleManagerStatus(id, isChecked) {
        const label = document.getElementById('label' + id);
        const originalHtml = label.innerHTML;
        
        label.innerHTML = '<span class="spinner-border spinner-border-sm text-warning" role="status" aria-hidden="true"></span>';

        fetch(`/admin/managers/${id}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === true) {
                label.innerHTML = '<span class="text-success fw-bold" style="font-size: 0.8rem;">Đang hoạt động</span>';
            } else if (data.status === false) {
                label.innerHTML = '<span class="text-danger fw-bold" style="font-size: 0.8rem;">Tạm ngưng</span>';
            } else {
                label.innerHTML = originalHtml;
                alert('Lỗi: ' + (data.message || 'Không thể lưu trạng thái!'));
                document.getElementById('switch' + id).checked = !isChecked;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            label.innerHTML = originalHtml;
            alert('Lỗi kết nối máy chủ!');
            document.getElementById('switch' + id).checked = !isChecked;
        });
    }
</script>
@endpush
