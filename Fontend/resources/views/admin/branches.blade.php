@extends('layouts.admin')

@section('title', 'Quản Lý Chi Nhánh')

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

    /* Custom Switch Toggle */
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.25em;
        background-color: rgba(255, 255, 255, 0.2);
        border: none;
        cursor: pointer;
    }
    .form-switch .form-check-input:checked {
        background-color: #28a745;
    }
    .form-switch .form-check-input:focus {
        box-shadow: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <!-- Hiển thị thông báo (Alert) -->
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

    <!-- Tiêu đề -->
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <div>
            <h2 class="fw-bold mb-1 text-warning"><i class="bi bi-building me-2"></i> Quản Lý Chi Nhánh</h2>
            <p class="text-muted mb-0">Quản trị tối cao: Thêm, sửa, xóa và quản lý tất cả chi nhánh thuộc hệ thống GymPro.</p>
        </div>
        <div>
            <button class="btn btn-warning fw-bold shadow-sm" onclick="openBranchModal()" style="border-radius: 10px; padding: 10px 20px;">
                <i class="bi bi-plus-lg me-2"></i> Thêm Chi Nhánh
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="glass-card animate-fade-in" style="animation-delay: 0.2s;">
        <div class="table-responsive">
            <table class="table table-glass mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Chi Nhánh</th>
                        <th>Quản Lý (Manager)</th>
                        <th>Thống Kê</th>
                        <th>Trạng Thái</th>
                        <th class="text-end">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branches as $branch)
                    <tr>
                        <td class="fw-bold text-muted">#{{ str_pad($branch['id'], 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="fw-bold" style="color: #1e293b;">{{ $branch['name'] }}</div>
                            <div class="small text-muted"><i class="bi bi-geo-alt-fill me-1"></i>{{ $branch['address'] }}</div>
                        </td>
                        <td>
                            @if($branch['manager'] == 'Chưa có quản lý')
                                <span class="badge bg-secondary text-light">Chưa có quản lý</span>
                            @else
                                <div class="d-flex align-items-center gap-2">
                                    @php
                                        $mAvatar = $branch['manager_avatar'] ?? ('https://ui-avatars.com/api/?name=' . urlencode($branch['manager']) . '&background=F1C40F&color=fff');
                                        if (str_starts_with($mAvatar, '/')) {
                                            $mAvatar = config('services.backend.url_base') . $mAvatar;
                                        }
                                    @endphp
                                    <img src="{{ $mAvatar }}" alt="Manager" class="rounded-circle" width="30" height="30" style="object-fit: cover; border: 1px solid rgba(0,0,0,0.1);">
                                    <span class="fw-bold" style="font-size: 0.9rem; color: #1e293b;">
                                        {{ !empty($branch['manager']) ? $branch['manager'] : 'Quản trị viên' }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="small"><i class="bi bi-people-fill text-primary me-1"></i> {{ number_format($branch['members_count']) }} hội viên</div>
                            <div class="small"><i class="bi bi-currency-dollar text-success me-1"></i> {{ $branch['revenue'] }}</div>
                        </td>
                        <td>
                            <div class="form-check form-switch fs-5">
                                <input class="form-check-input" type="checkbox" role="switch" id="switch{{ $branch['id'] }}" 
                                    {{ $branch['status'] == 'active' ? 'checked' : '' }}
                                    onchange="toggleBranchStatus({{ $branch['id'] }}, this.checked)">
                                <label class="form-check-label ms-2 small" for="switch{{ $branch['id'] }}" id="label{{ $branch['id'] }}" style="margin-top: 3px;">
                                    {!! $branch['status'] == 'active' ? '<span class="text-success fw-bold">Hoạt động</span>' : '<span class="text-danger fw-bold">Tạm ngưng</span>' !!}
                                </label>
                            </div>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-light rounded-circle p-2" 
                                onclick="openBranchModal({{ json_encode($branch) }})" title="Chỉnh sửa">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.branches.delete', $branch['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Cảnh báo: Bạn có chắc chắn muốn xóa vĩnh viễn chi nhánh này không? Hành động này không thể hoàn tác!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-2 ms-1" title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Thêm/Sửa Chi Nhánh (Glassmorphism) -->
<div class="modal fade" id="branchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: rgba(26, 26, 46, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 15px; color: white;">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title fw-bold" id="modalTitle">Thêm Chi Nhánh Mới</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="branchForm" method="POST" action="{{ route('admin.branches.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase fw-bold">Tên chi nhánh <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-transparent text-white border-secondary" name="name" id="branchName" required placeholder="VD: Chi nhánh Quận 1...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase fw-bold">Địa chỉ</label>
                        <input type="text" class="form-control bg-transparent text-white border-secondary" name="address" id="branchAddress" placeholder="Số nhà, đường, phường, quận...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase fw-bold">Số điện thoại</label>
                        <input type="text" class="form-control bg-transparent text-white border-secondary" name="phone" id="branchPhone" placeholder="0901234567">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase fw-bold">Người Quản Lý</label>
                        <select class="form-select bg-transparent text-white border-secondary" name="manager_id" id="branchManager">
                            <option value="" class="text-dark">-- Chọn người quản lý --</option>
                            @foreach($managers ?? [] as $manager)
                                <option value="{{ $manager['id'] }}" class="text-dark">{{ $manager['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check form-switch mt-4 fs-5">
                        <input class="form-check-input" type="checkbox" role="switch" id="branchStatus" name="is_active" checked>
                        <label class="form-check-label ms-2 text-white" for="branchStatus" style="font-size: 1rem;">Hoạt động ngay</label>
                    </div>
                </div>
                <div class="modal-footer border-secondary border-opacity-25">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-save me-1"></i> Lưu Dữ Liệu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleBranchStatus(id, isChecked) {
        const label = document.getElementById('label' + id);
        const originalHtml = label.innerHTML;
        
        // Hiệu ứng đang tải (Loading)
        label.innerHTML = '<span class="spinner-border spinner-border-sm text-warning" role="status" aria-hidden="true"></span> <span class="small text-muted">Đang lưu...</span>';

        // Gọi API qua Route của Laravel
        fetch(`/admin/branches/${id}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'active') {
                label.innerHTML = '<span class="text-success fw-bold">Hoạt động</span>';
            } else if (data.status === 'inactive') {
                label.innerHTML = '<span class="text-danger fw-bold">Tạm ngưng</span>';
            } else {
                // Restore if failed
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

    // Xử lý Modal Thêm / Sửa
    const branchModal = new bootstrap.Modal(document.getElementById('branchModal'));
    
    function openBranchModal(branch = null) {
        const form = document.getElementById('branchForm');
        const title = document.getElementById('modalTitle');
        const methodInput = document.getElementById('formMethod');
        
        if (branch) {
            // Chế độ Edit
            title.innerText = 'Cập nhật: ' + branch.name;
            form.action = `/admin/branches/${branch.id}`;
            methodInput.value = 'PUT'; // Laravel form method spoofing
            
            document.getElementById('branchName').value = branch.name;
            document.getElementById('branchAddress').value = branch.address && branch.address !== 'Chưa cập nhật địa chỉ' ? branch.address : '';
            document.getElementById('branchPhone').value = branch.phone || '';
            
            // Tìm và chọn manager trong select box
            const managerSelect = document.getElementById('branchManager');
            managerSelect.value = branch.manager_id || '';

            document.getElementById('branchStatus').checked = branch.is_active;
        } else {
            // Chế độ Add Mới
            title.innerText = 'Thêm Chi Nhánh Mới';
            form.action = '{{ route("admin.branches.store") }}';
            methodInput.value = 'POST';
            
            form.reset();
            document.getElementById('branchManager').value = '';
            document.getElementById('branchStatus').checked = true;
        }
        
        branchModal.show();
    }
</script>
@endpush
