@extends('layouts.admin')

@section('title', isset($equipment) ? 'Chỉnh sửa: ' . $equipment['name'] : 'Thêm thiết bị mới')

@section('content')
<div class="container-fluid py-4">
    <form action="{{ isset($equipment) ? route('admin.equipments.update', $equipment['id']) : route('admin.equipments.store') }}" method="POST" enctype="multipart/form-data" id="equipmentForm">
        @csrf
        @if(isset($equipment))
            @method('PATCH')
            <input type="hidden" name="row_version" value="{{ base64_encode($equipment['rowVersion']) }}">
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">{{ isset($equipment) ? 'Cập nhật thiết bị' : 'Đăng ký thiết bị mới' }}</h6>
                        <div>
                            <a href="{{ route('admin.equipments') }}" class="btn btn-sm btn-secondary mr-2">Hủy</a>
                            <button type="submit" class="btn btn-sm btn-primary shadow-sm px-4">Lưu dữ liệu</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Navigation Tabs -->
                        <ul class="nav nav-pills mb-4 nav-fill bg-light p-2 rounded" id="equipmentTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="basic-tab" data-bs-toggle="pill" data-bs-target="#basic" type="button" role="tab"><i class="fas fa-info-circle mr-2"></i>Cơ bản</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="inventory-tab" data-bs-toggle="pill" data-bs-target="#inventory" type="button" role="tab"><i class="fas fa-boxes mr-2"></i>Kho & SL</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="purchase-tab" data-bs-toggle="pill" data-bs-target="#purchase" type="button" role="tab"><i class="fas fa-shopping-cart mr-2"></i>Mua hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="supplier-tab" data-bs-toggle="pill" data-bs-target="#supplier" type="button" role="tab"><i class="fas fa-truck mr-2"></i>Nhà cung cấp</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="maintenance-tab" data-bs-toggle="pill" data-bs-target="#maintenance" type="button" role="tab"><i class="fas fa-tools mr-2"></i>Bảo trì</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="media-tab" data-bs-toggle="pill" data-bs-target="#media" type="button" role="tab"><i class="fas fa-images mr-2"></i>Media & Files</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="smart-tab" data-bs-toggle="pill" data-bs-target="#smart" type="button" role="tab"><i class="fas fa-microchip mr-2"></i>Smart/IoT</a>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="equipmentTabsContent">
                            <!-- Basic Info -->
                            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Mã thiết bị <small class="text-danger">*</small></label>
                                            <input type="text" name="device_code" class="form-control" placeholder="Ví dụ: TREAD-001" value="{{ $equipment['deviceCode'] ?? old('device_code') }}" required {{ isset($equipment) ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tên thiết bị <small class="text-danger">*</small></label>
                                            <input type="text" name="name" class="form-control" placeholder="Tên đầy đủ của thiết bị" value="{{ $equipment['name'] ?? old('name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Loại thiết bị <small class="text-danger">*</small></label>
                                            <select name="category" class="form-control" required>
                                                <option value="1" {{ ($equipment['category'] ?? '') == 1 ? 'selected' : '' }}>Cardio Equipment</option>
                                                <option value="2" {{ ($equipment['category'] ?? '') == 2 ? 'selected' : '' }}>Strength Machine</option>
                                                <option value="3" {{ ($equipment['category'] ?? '') == 3 ? 'selected' : '' }}>Free Weight</option>
                                                <option value="4" {{ ($equipment['category'] ?? '') == 4 ? 'selected' : '' }}>Functional Training</option>
                                                <option value="10" {{ ($equipment['category'] ?? '') == 10 ? 'selected' : '' }}>Smart Device / IoT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Chi nhánh <small class="text-danger">*</small></label>
                                            <select name="branch_id" class="form-control" required>
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch['id'] }}" {{ ($equipment['branchId'] ?? '') == $branch['id'] ? 'selected' : '' }}>{{ $branch['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Trạng thái</label>
                                            <select name="status" class="form-control">
                                                <option value="1" {{ ($equipment['status'] ?? '') == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="2" {{ ($equipment['status'] ?? '') == 2 ? 'selected' : '' }}>Maintenance</option>
                                                <option value="3" {{ ($equipment['status'] ?? '') == 3 ? 'selected' : '' }}>Broken</option>
                                                <option value="5" {{ ($equipment['status'] ?? '') == 5 ? 'selected' : '' }}>Retired</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Mô tả chi tiết</label>
                                            <textarea name="description" class="form-control" rows="4" placeholder="Thông tin thêm về thiết bị...">{{ $equipment['description'] ?? old('description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">QR Code / Barcode</label>
                                            <div class="input-group">
                                                <input type="text" name="qr_code" class="form-control" placeholder="QR Code" value="{{ $equipment['qrCode'] ?? '' }}">
                                                <input type="text" name="barcode" class="form-control" placeholder="Barcode" value="{{ $equipment['barcode'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Inventory & Location -->
                            <div class="tab-pane fade" id="inventory" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tổng số lượng</label>
                                            <input type="number" name="quantity" class="form-control" value="{{ $equipment['quantity'] ?? 1 }}" min="1">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Khả dụng</label>
                                            <input type="number" name="available_quantity" class="form-control" value="{{ $equipment['availableQuantity'] ?? 1 }}" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tồn tối thiểu (Alert)</label>
                                            <input type="number" name="minimum_stock" class="form-control" value="{{ $equipment['minimumStock'] ?? 0 }}" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Vị trí (Room/Zone)</label>
                                            <input type="text" name="room" class="form-control" placeholder="Phòng tập A, Khu Cardio..." value="{{ $equipment['room'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <h6 class="font-weight-bold text-dark">Thông số khối lượng</h6>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="small">Trọng lượng (kg)</label>
                                                        <input type="number" step="0.1" name="weight" class="form-control form-control-sm" value="{{ $equipment['weight'] ?? '' }}">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="small">Tải trọng tối đa</label>
                                                        <input type="number" step="0.1" name="max_weight" class="form-control form-control-sm" value="{{ $equipment['maxWeight'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Purchase Info -->
                            <div class="tab-pane fade" id="purchase" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Ngày mua</label>
                                            <input type="date" name="purchase_date" class="form-control" value="{{ isset($equipment['purchaseDate']) ? \Carbon\Carbon::parse($equipment['purchaseDate'])->format('Y-m-d') : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Giá mua (VNĐ)</label>
                                            <input type="number" name="purchase_price" class="form-control" value="{{ $equipment['purchasePrice'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Hạn bảo hành</label>
                                            <input type="date" name="warranty_expiry" class="form-control" value="{{ isset($equipment['warrantyExpiry']) ? \Carbon\Carbon::parse($equipment['warrantyExpiry'])->format('Y-m-d') : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Số hóa đơn</label>
                                            <input type="text" name="invoice_number" class="form-control" value="{{ $equipment['invoiceNumber'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Số năm khấu hao</label>
                                            <input type="number" name="depreciation_years" class="form-control" value="{{ $equipment['depreciationYears'] ?? 5 }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Supplier Info -->
                            <div class="tab-pane fade" id="supplier" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Thương hiệu (Brand)</label>
                                            <input type="text" name="brand" class="form-control" value="{{ $equipment['brand'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Model</label>
                                            <input type="text" name="model" class="form-control" value="{{ $equipment['model'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Serial Number</label>
                                            <input type="text" name="serial_number" class="form-control" value="{{ $equipment['serialNumber'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nhà cung cấp</label>
                                            <input type="text" name="supplier" class="form-control" value="{{ $equipment['supplier'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">SĐT nhà CC</label>
                                            <input type="text" name="supplier_phone" class="form-control" value="{{ $equipment['supplierPhone'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Quốc gia xuất xứ</label>
                                            <input type="text" name="country_origin" class="form-control" value="{{ $equipment['countryOrigin'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Maintenance Info -->
                            <div class="tab-pane fade" id="maintenance" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Chu kỳ bảo trì (Ngày)</label>
                                            <input type="number" name="maintenance_cycle_days" class="form-control" value="{{ $equipment['maintenanceCycleDays'] ?? 90 }}">
                                            <small class="text-muted">Hệ thống sẽ tự tính ngày bảo trì tiếp theo.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Ngày bảo trì gần nhất</label>
                                            <input type="date" name="last_maintenance_date" class="form-control" value="{{ isset($equipment['lastMaintenanceDate']) ? \Carbon\Carbon::parse($equipment['lastMaintenanceDate'])->format('Y-m-d') : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-primary">Dự kiến bảo trì tiếp</label>
                                            <input type="text" class="form-control bg-light" value="{{ isset($equipment['nextMaintenanceDate']) ? \Carbon\Carbon::parse($equipment['nextMaintenanceDate'])->format('d/m/Y') : 'Chưa xác định' }}" readonly>
                                        </div>
                                    </div>
                                    
                                    @if(isset($equipment) && count($equipment['maintenanceLogs']) > 0)
                                    <div class="col-12 mt-4">
                                        <h6>Lịch sử bảo trì / Sửa chữa</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Ngày</th>
                                                        <th>Vấn đề</th>
                                                        <th>Xử lý</th>
                                                        <th>Chi phí</th>
                                                        <th>Người thực hiện</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($equipment['maintenanceLogs'] as $log)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($log['repairedAt'])->format('d/m/Y') }}</td>
                                                        <td>{{ $log['issue'] }}</td>
                                                        <td>{{ $log['repairAction'] }}</td>
                                                        <td>{{ number_format($log['cost']) }}đ</td>
                                                        <td>{{ $log['performedBy'] }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Media Files -->
                            <div class="tab-pane fade" id="media" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Ảnh đại diện thiết bị</label>
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input" id="imageInput">
                                                <label class="custom-file-label" for="imageInput">Chọn file...</label>
                                            </div>
                                            @if(isset($equipment['imageUrl']))
                                                <div class="mt-2">
                                                    <img src="{{ $equipment['imageUrl'] }}" class="img-thumbnail" width="200">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tài liệu hướng dẫn (PDF)</label>
                                            <div class="custom-file">
                                                <input type="file" name="manual" class="custom-file-input" id="manualInput">
                                                <label class="custom-file-label" for="manualInput">Chọn file...</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Smart Features -->
                            <div class="tab-pane fade" id="smart" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="isSmartSwitch" name="is_smart_device" {{ ($equipment['isSmartDevice'] ?? false) ? 'checked' : '' }}>
                                            <label class="custom-control-label font-weight-bold" for="isSmartSwitch">Đây là thiết bị thông minh (Smart/IoT)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">MAC Address</label>
                                            <input type="text" name="ble_mac_address" class="form-control" value="{{ $equipment['bleMacAddress'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">IP Address</label>
                                            <input type="text" name="ip_address" class="form-control" value="{{ $equipment['ipAddress'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Firmware Version</label>
                                            <input type="text" name="firmware_version" class="form-control" value="{{ $equipment['firmwareVersion'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <h6 class="mt-3 font-weight-bold">Hỗ trợ cảm biến</h6>
                                        <div class="d-flex flex-wrap">
                                            <div class="custom-control custom-checkbox mr-4">
                                                <input type="checkbox" class="custom-control-input" id="hrCheck" name="supports_heart_rate" {{ ($equipment['supportsHeartRate'] ?? false) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="hrCheck">Heart Rate</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mr-4">
                                                <input type="checkbox" class="custom-control-input" id="spo2Check" name="supports_spo2" {{ ($equipment['supportsSpo2'] ?? false) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="spo2Check">SpO2</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mr-4">
                                                <input type="checkbox" class="custom-control-input" id="aiCheck" name="supports_ai_tracking" {{ ($equipment['supportsAiTracking'] ?? false) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="aiCheck">AI Motion Tracking</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Xử lý hiển thị tên file khi chọn
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Auto-switch tab nếu có lỗi trong validation (Phần này bổ sung sau)
</script>
@endpush
@endsection
