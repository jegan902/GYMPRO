@extends('layouts.admin')

@section('title', 'Quản lý Thiết bị')

@section('content')
    <style>
        /* Tổng thể theo mẫu Quản lý Nhân sự - Phiên bản Thu nhỏ */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        .header-section {
            margin-bottom: 12px;
        }

        .header-title {
            color: #EAB308;
            font-weight: 800;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .header-desc {
            color: #64748B;
            font-size: 11px;
            margin-bottom: 0;
            font-weight: 600;
        }

        .metric-card-custom {
            background: #fff;
            padding: 6px 12px;
            border-radius: 8px;
            border: 1px solid #f1f5f9;
            height: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .metric-icon-box {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        .metric-value {
            font-size: 14px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 0;
            line-height: 1;
        }

        .metric-label {
            font-size: 8px;
            color: #64748b;
            font-weight: 600;
        }

        .metric-badge {
            font-size: 8px;
            padding: 1px 5px;
            border-radius: 10px;
            font-weight: 700;
            margin-left: auto;
        }

        .metric-number {
            font-size: 18px;
            font-weight: 800;
            color: #111;
            margin-top: auto;
            padding-left: 36px;
        }

        .btn-add-custom {
            background: #FACC15;
            color: #000 !important;
            font-weight: 700;
            font-size: 11px;
            padding: 5px 12px;
            border-radius: 6px;
            border: none;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none !important;
        }

        .btn-export-custom {
            background: #78350F;
            color: white !important;
            font-weight: 700;
            font-size: 11px;
            padding: 5px 12px;
            border-radius: 6px;
            border: none;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none !important;
            margin-left: 5px;
        }

        .filter-bar-mini {
            background: white;
            border-radius: 6px;
            padding: 3px 8px;
            margin-bottom: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .tab-btn {
            border: none;
            background: #f1f3f9;
            color: #555;
            padding: 1px 6px;
            border-radius: 4px;
            font-size: 8.5px;
            font-weight: 700;
            margin-left: 2px;
            white-space: nowrap;
        }

        .tab-btn.active {
            background: #e2e8f0;
            color: #111;
        }

        .form-control-sm {
            font-size: 8.5px !important;
            height: 22px !important;
            padding: 1px 6px !important;
        }

        .table-personnel-style {
            background: white;
            border-radius: 10px;
            border: none;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        /* Ultra Compact Table */
        .table-personnel-style thead th {
            padding: 4px 8px !important;
            color: #475569;
            font-size: 8.5px !important;
            font-weight: 800;
            text-transform: uppercase;
            border-bottom: 1px solid #F1F5F9;
            white-space: nowrap;
        }

        .table-personnel-style tbody td {
            padding: 3px 8px !important;
            vertical-align: middle;
            border-bottom: 1px solid #F8FAFC;
            font-size: 8.5px;
        }

        .entity-info {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .entity-img {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            object-fit: cover;
            border: 1px solid #E2E8F0;
            background: #F1F5F9;
            transition: 0.3s;
        }

        .entity-img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .img-placeholder-custom {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #E2E8F0;
            color: #94A3B8;
            position: relative;
            overflow: hidden;
        }

        .entity-name {
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
            font-size: 11.5px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .entity-sub {
            font-size: 8.5px;
            color: #64748b;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .category-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 1px 6px;
            border-radius: 5px;
            font-weight: 700;
            font-size: 8.5px;
        }

        /* Dropdown Status Badge - Click to Open */
        .status-picker {
            position: relative;
            display: inline-block;
        }

        .status-badge-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 8.5px;
            cursor: pointer;
            border: 1px solid transparent;
            transition: 0.2s;
            min-width: 110px;
            background: #F1F5F9;
            color: #475569;
            outline: none !important;
        }

        .status-badge-btn:hover {
            border-color: #CBD5E1;
        }

        .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
        }

        /* Màu sắc theo nhóm mới */
        .dot-active {
            background: #059669;
        }

        .dot-idle {
            background: #3B82F6;
        }

        .dot-maint {
            background: #D97706;
        }

        .dot-req {
            background: #F59E0B;
        }

        .dot-parts {
            background: #EAB308;
        }

        .dot-broken {
            background: #DC2626;
        }

        .dot-insp {
            background: #F87171;
        }

        .dot-scrapped {
            background: #4B5563;
        }

        .dot-offline {
            background: #94A3B8;
        }

        .bg-active-light {
            background: #ECFDF5;
            color: #059669;
        }

        .bg-maint-light {
            background: #FFFBEB;
            color: #B45309;
        }

        .bg-broken-light {
            background: #FEF2F2;
            color: #DC2626;
        }

        .bg-idle-light {
            background: #EFF6FF;
            color: #1D4ED8;
        }

        .bg-req-light {
            background: #FFF7ED;
            color: #C2410C;
        }

        .bg-parts-light {
            background: #FEFCE8;
            color: #A16207;
        }

        .bg-insp-light {
            background: #FFF1F2;
            color: #E11D48;
        }

        .bg-scrapped-light {
            background: #F8FAFC;
            color: #475569;
        }

        .bg-disposed-light {
            background: #F1F5F9;
            color: #64748B;
        }

        .custom-dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 160px;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
            z-index: 9999 !important;
            padding: 6px;
            border: 1px solid #E2E8F0;
            margin-top: 5px;
        }

        .custom-dropdown-content.show {
            display: block;
        }

        .dropdown-group-label {
            font-size: 8.5px;
            font-weight: 800;
            color: #94A3B8;
            text-transform: uppercase;
            padding: 6px 10px 4px 10px;
            letter-spacing: 0.5px;
            border-top: 1px solid #F1F5F9;
        }

        .dropdown-group-label:first-child {
            border-top: none;
        }

        .dropdown-item-status {
            display: flex;
            width: 100%;
            border: none;
            background: transparent;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 6px;
            color: #334155;
            font-weight: 700;
            cursor: pointer !important;
            font-size: 9.5px;
            transition: 0.1s;
            text-align: left;
        }

        .dropdown-item-status:hover {
            background: #F8FAFC;
            color: #000;
        }

        .action-btn-group {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
        }

        .action-btn {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #E2E8F0;
            margin-left: 3px;
            font-size: 9px;
            transition: 0.2s;
            cursor: pointer !important;
            background: white;
        }

        .action-btn:hover {
            background: #F8FAFC;
            transform: scale(1.1);
            border-color: #CBD5E1;
        }

        .maint-link {
            font-size: 9px;
            color: #2563EB;
            font-weight: 800;
            margin-right: 8px;
            text-decoration: none !important;
            cursor: pointer !important;
            white-space: nowrap;
        }

        /* Pagination Styling */
        .pagination .page-link {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #64748B;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            margin: 0 2px;
            transition: 0.2s;
            border-radius: 6px !important;
        }

        .pagination .page-item.active .page-link {
            background: #FACC15;
            color: #000;
            border-color: #FACC15;
        }

        .pagination .page-link:hover {
            background: #F1F5F9;
            color: #000;
            border-color: #CBD5E1;
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.5;
            background: #F8FAFC;
        }
    </style>

    <div class="container-fluid py-2">
        <!-- Metrics -->
        <div class="row g-2 mb-3">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="metric-card-custom">
                    <div class="metric-icon-box" style="background: #FFFBEB; color: #D97706;">
                        <i class="bi bi-box"></i>
                    </div>
                    <div>
                        <div class="metric-label">Tổng Thiết bị</div>
                        <div class="metric-value">{{ $metrics['totalEquipments'] }}</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="metric-card-custom">
                    <div class="metric-icon-box" style="background: #F0FDF4; color: #16A34A;">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <div class="metric-label">Đang hoạt động</div>
                        <div class="metric-value">{{ $metrics['activeEquipments'] }}</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="metric-card-custom">
                    <div class="metric-icon-box" style="background: #FFFBEB; color: #D97706;">
                        <i class="bi bi-tools"></i>
                    </div>
                    <div>
                        <div class="metric-label">Đang bảo trì</div>
                        <div class="metric-value">{{ $metrics['brokenEquipments'] }}</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="metric-card-custom">
                    <div class="metric-icon-box" style="background: #FEF2F2; color: #DC2626;">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <div>
                        <div class="metric-label">Đã Hỏng/Thay</div>
                        <div class="metric-value">{{ $metrics['brokenEquipments'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-end header-section">
            <div>
                <div class="header-title"><i class="bi bi-gear-fill"></i> Quản lý Trang thiết bị</div>
                <p class="header-desc">Hệ thống quản lý danh sách và trạng thái vận hành thiết bị gym.</p>
            </div>
            <div class="d-flex">
                <a href="{{ route('admin.equipments.create') }}" class="btn-add-custom shadow-sm"><i
                        class="bi bi-plus-lg"></i> Thêm Thiết bị</a>
                <button class="btn-export-custom shadow-sm"><i class="bi bi-file-earmark-arrow-down"></i> Xuất Báo
                    cáo</button>
            </div>
        </div>

        <!-- Filter Bar -->
        <form id="filterForm" action="{{ route('admin.equipments') }}" method="GET"
            class="filter-bar-mini d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <input type="text" name="search" class="form-control form-control-sm mr-2" placeholder="Tìm ID..."
                    value="{{ request('search') }}" style="width: 80px;" onchange="this.form.submit()">

                <input type="hidden" name="category" id="categoryInput" value="{{ request('category') }}">

                <select name="branchId" class="form-control form-control-sm" style="width: 90px;"
                    onchange="this.form.submit()">
                    <option value="">Tất cả chi nhánh</option>
                    @if(isset($branches) && count($branches) > 0)
                        @foreach($branches as $branch)
                            @php
                                $bName = data_get($branch, 'name') ?? data_get($branch, 'Name') ?? 'Chi nhánh';
                                $bId = data_get($branch, 'id') ?? data_get($branch, 'Id') ?? 0;
                            @endphp
                            <option value="{{ $bId }}" {{ request('branchId') == $bId ? 'selected' : '' }}>
                                {{ $bName }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="d-flex align-items-center">
                <button type="button" class="tab-btn {{ !request('category') ? 'active' : '' }}"
                    onclick="filterCategory('')">Tất cả</button>
                <button type="button" class="tab-btn {{ request('category') == 'CardioEquipment' ? 'active' : '' }}"
                    onclick="filterCategory('CardioEquipment')">Tim mạch</button>
                <button type="button" class="tab-btn {{ request('category') == 'StrengthMachine' ? 'active' : '' }}"
                    onclick="filterCategory('StrengthMachine')">Cơ bắp</button>
                <button type="button" class="tab-btn {{ request('category') == 'FreeWeight' ? 'active' : '' }}"
                    onclick="filterCategory('FreeWeight')">Tạ tự do</button>
                <button type="button" class="tab-btn {{ request('category') == 'YogaEquipment' ? 'active' : '' }}"
                    onclick="filterCategory('YogaEquipment')">Yoga/Functional</button>
                <button type="button" class="tab-btn {{ request('category') == 'SmartDeviceIoT' ? 'active' : '' }}"
                    onclick="filterCategory('SmartDeviceIoT')">IoT</button>
                <button type="button" class="tab-btn {{ request('category') == 'LockerEquipment' ? 'active' : '' }}"
                    onclick="filterCategory('LockerEquipment')">Tủ & Tiện ích</button>
            </div>
        </form>

        <script>
            function filterCategory(cat) {
                var input = document.getElementById('categoryInput');
                if (input) {
                    input.value = cat;
                    document.getElementById('filterForm').submit();
                }
            }
        </script>

        <!-- Table -->
        <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 10px;">
            <div class="table-responsive">
                <table class="table table-personnel-style mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;">MÃ MÁY</th>
                            <th class="text-center">THIẾT BỊ</th>
                            <th class="text-center">SỐ LƯỢNG</th>
                            <th class="text-center">DANH MỤC</th>
                            <th class="text-center">CHI NHÁNH</th>
                            <th class="text-center">LỊCH BẢO TRÌ</th>
                            <th class="text-center">TRẠNG THÁI</th>
                            <th class="text-center">HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipments as $index => $e)
                            <tr>
                                <td class="text-center" style="color: #6366F1; font-weight: 800; font-size: 9.5px;">
                                    <span
                                        style="background: #EEF2FF; padding: 3px 8px; border-radius: 6px; border: 1px solid rgba(99, 102, 241, 0.1); white-space: nowrap; display: inline-block; min-width: 80px;">{{ $e['deviceCode'] }}</span>
                                </td>
                                <td class="text-left">
                                    <div class="entity-info">
                                        @php
                                            $defaultImgs = [
                                                'treadmill' => ['https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=200&auto=format&fit=crop', 'bi-speedometer2'],
                                                'bike' => ['https://images.unsplash.com/photo-1594882645126-14020914d58d?q=80&w=200&auto=format&fit=crop', 'bi-bicycle'],
                                                'elliptical' => ['https://images.unsplash.com/photo-1620188467120-5042ed1eb5da?q=80&w=200&auto=format&fit=crop', 'bi-moisture'],
                                                'dumbbell' => ['https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=200&auto=format&fit=crop', 'bi-box'],
                                                'strength' => ['https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=200&auto=format&fit=crop', 'bi-gear-wide-connected'],
                                                'yoga' => ['https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=200&auto=format&fit=crop', 'bi-flower1']
                                            ];

                                            $lowerNameForImg = strtolower($e['name']);
                                            $imgKey = 'strength';

                                            if (str_contains($lowerNameForImg, 'run') || str_contains($lowerNameForImg, 'treadmill'))
                                                $imgKey = 'treadmill';
                                            elseif (str_contains($lowerNameForImg, 'cycle') || str_contains($lowerNameForImg, 'bike'))
                                                $imgKey = 'bike';
                                            elseif (str_contains($lowerNameForImg, 'elliptical'))
                                                $imgKey = 'elliptical';
                                            elseif (str_contains($lowerNameForImg, 'dumbbell') || str_contains($lowerNameForImg, 'ziva') || str_contains($lowerNameForImg, 'tạ'))
                                                $imgKey = 'dumbbell';
                                            elseif (str_contains($lowerNameForImg, 'yoga') || str_contains($lowerNameForImg, 'pilates'))
                                                $imgKey = 'yoga';

                                            $displayImg = $e['imageUrl'] ?: ($defaultImgs[$imgKey][0]);
                                            $displayIcon = $defaultImgs[$imgKey][1];
                                        @endphp
                                        <div class="img-placeholder-custom">
                                            <i class="bi {{ $displayIcon }}"
                                                style="font-size: 14px; position: absolute; z-index: 0;"></i>
                                            <img src="{{ $displayImg }}" class="entity-img"
                                                style="position: relative; z-index: 1;" onerror="this.style.display='none'">
                                        </div>
                                        <div>
                                            <div class="entity-name" style="color: #1E293B;">{{ $e['name'] }}</div>
                                            <div class="entity-sub" style="color: #94A3B8; font-weight: 500;">
                                                {{ $e['brand'] ?? 'GYM-PRO' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div style="font-weight: 700; color: #475569;">
                                        {{ $e['quantity'] }} <small style="font-weight: 400; color: #94A3B8;">máy</small>
                                    </div>
                                    @if(($e['quantity'] - $e['availableQuantity']) > 0)
                                        <div style="font-size: 9px; color: #DC2626;">Đang lỗi:
                                            {{ $e['quantity'] - $e['availableQuantity'] }}</div>
                                    @endif
                                </td>
                                <td class="text-left">
                                    @php
                                        $catMap = [
                                            'CardioEquipment' => ['Máy Tim mạch', 'background:#E0F2FE;color:#0369A1', 'bi-heart-pulse'],
                                            'StrengthMachine' => ['Máy tập tạ (Strength)', 'background:#FFEDD5;color:#C2410C', 'bi-gear-wide-connected'],
                                            'FreeWeight' => ['Tạ tự do', 'background:#F3E8FF;color:#7E22CE', 'bi-box'],
                                            'FunctionalTraining' => ['Thiết bị tập chức năng', 'background:#ECFDF5;color:#059669', 'bi-lightning-charge'],
                                            'YogaEquipment' => ['Yoga & Pilates', 'background:#FDF2F8;color:#DB2777', 'bi-flower1'],
                                            'MedicalEquipment' => ['Thiết bị trị liệu / phục hồi', 'background:#FEF2F2;color:#DC2626', 'bi-plus-circle'],
                                            'SmartDeviceIoT' => ['Thiết bị thông minh (IoT)', 'background:#EEF2FF;color:#4F46E5', 'bi-cpu'],
                                            'FacilityEquipment' => ['Trang thiết bị phòng gym', 'background:#F8FAFC;color:#475569', 'bi-building'],
                                            'SecurityEquipment' => ['Thiết bị an ninh', 'background:#FEFCE8;color:#854D0E', 'bi-shield-check'],
                                            'LockerEquipment' => ['Tủ locker', 'background:#F1F5F9;color:#334155', 'bi-safe'],
                                            'MaintenanceEquipment' => ['Dụng cụ bảo trì', 'background:#FFF7ED;color:#C2410C', 'bi-tools']
                                        ];

                                        // Sử dụng trực tiếp danh mục từ Backend trả về để đảm bảo nhất quán với bộ lọc
                                        $rawCat = $e['categoryName'] ?? 'Khác';
                                        $c = $catMap[$rawCat] ?? ['Khác', 'background:#F1F5F9;color:#475569', 'bi-tag'];
                                    @endphp
                                    <span class="category-badge" style="{{ $c[1] }}; border: 1px solid rgba(0,0,0,0.05);"><i
                                            class="bi {{ $c[2] }}"></i> {{ $c[0] }}</span>
                                </td>
                                <td class="text-left">
                                    <span class="category-badge"
                                        style="background: #F8FAFC; color: #64748B; border: 1px solid #E2E8F0;">
                                        <i class="bi bi-building mr-1"></i> {{ $e['branchName'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusId = (int) $e['status'];
                                        $dateMap = [
                                            0 => ['#059669', '#ECFDF5', '#D1FAE5'], // Đang hoạt động -> Xanh lá
                                            1 => ['#D97706', '#FFFBEB', '#FEF3C7'], // Đang bảo trì -> Vàng cam
                                            2 => ['#DC2626', '#FEF2F2', '#FEE2E2'], // Hỏng hóc -> Đỏ
                                            3 => ['#64748B', '#F8FAFC', '#F1F5F9'], // Đã thanh lý -> Xám
                                            4 => ['#2563EB', '#EFF6FF', '#DBEAFE'], // Chưa sử dụng -> Xanh dương
                                            5 => ['#EA580C', '#FFF7ED', '#FFEDD5'], // Cần bảo trì -> Cam đậm
                                            6 => ['#CA8A04', '#FEFCE8', '#FEF9C3'], // Chờ linh kiện -> Vàng
                                            7 => ['#E11D48', '#FFF1F2', '#FFE4E6'], // Cần kiểm tra -> Hồng đỏ
                                            8 => ['#4B5563', '#F9FAFB', '#F3F4F6']  // Đã hỏng/Thay thế -> Xám đậm
                                        ];
                                        $dC = $dateMap[$statusId] ?? ['#475569', '#F8FAFC', '#E2E8F0'];
                                    @endphp
                                    <span
                                        style="color: {{ $dC[0] }}; background: {{ $dC[1] }}; border: 1px solid {{ $dC[2] }}; padding: 3px 8px; border-radius: 6px; font-weight: 800; font-size: 8.5px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="bi bi-calendar3" style="font-size: 8px;"></i>
                                        {{ $e['nextMaintenanceDate'] ? \Carbon\Carbon::parse($e['nextMaintenanceDate'])->format('d/m/y') : '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="status-picker">
                                        @php
                                            $statusConfigs = [
                                                0 => ['bg-active-light', 'dot-active', 'Đang hoạt động'],
                                                1 => ['bg-maint-light', 'dot-maint', 'Đang bảo trì'],
                                                2 => ['bg-broken-light', 'dot-broken', 'Hỏng hóc'],
                                                3 => ['bg-disposed-light', 'dot-offline', 'Đã thanh lý'],
                                                4 => ['bg-idle-light', 'dot-idle', 'Chưa sử dụng'],
                                                5 => ['bg-req-light', 'dot-req', 'Cần bảo trì'],
                                                6 => ['bg-parts-light', 'dot-parts', 'Chờ linh kiện'],
                                                7 => ['bg-insp-light', 'dot-insp', 'Cần kiểm tra'],
                                                8 => ['bg-scrapped-light', 'dot-scrapped', 'Đã hỏng/Thay thế']
                                            ];

                                            $statusId = (int) $e['status'];
                                            $statusName = $e['statusName'] ?? '';
                                            $s = $statusConfigs[$statusId] ?? ['bg-secondary-light', 'dot-secondary', $statusName ?: $statusId];
                                        @endphp
                                        <button class="status-badge-btn {{ $s[0] }}" id="badge-{{ $e['id'] }}"
                                            onclick="toggleStatusMenu({{ $e['id'] }}, event)">
                                            <span class="dot {{ $s[1] }}"></span>
                                            <span class="status-label">{{ $s[2] }}</span>
                                            <i class="bi bi-chevron-down ml-auto" style="font-size: 8px;"></i>
                                        </button>
                                        <div class="custom-dropdown-content" id="menu-{{ $e['id'] }}">
                                            <div class="dropdown-group-label">Vận hành</div>
                                            <button class="dropdown-item-status" style="color: #059669;"
                                                onclick="updateStatus({{ $e['id'] }}, 0, event)"><span
                                                    class="dot dot-active"></span> Đang hoạt động</button>
                                            <button class="dropdown-item-status" style="color: #1D4ED8;"
                                                onclick="updateStatus({{ $e['id'] }}, 4, event)"><span
                                                    class="dot dot-idle"></span> Chưa sử dụng</button>

                                            <div class="dropdown-group-label">Bảo trì & Sửa chữa</div>
                                            <button class="dropdown-item-status" style="color: #B45309;"
                                                onclick="updateStatus({{ $e['id'] }}, 1, event)"><span
                                                    class="dot dot-maint"></span> Đang bảo trì</button>
                                            <button class="dropdown-item-status" style="color: #C2410C;"
                                                onclick="updateStatus({{ $e['id'] }}, 5, event)"><span
                                                    class="dot dot-req"></span> Cần bảo trì</button>
                                            <button class="dropdown-item-status" style="color: #A16207;"
                                                onclick="updateStatus({{ $e['id'] }}, 6, event)"><span
                                                    class="dot dot-parts"></span> Chờ linh kiện</button>

                                            <div class="dropdown-group-label">Hư hỏng & Cảnh báo</div>
                                            <button class="dropdown-item-status" style="color: #DC2626;"
                                                onclick="updateStatus({{ $e['id'] }}, 2, event)"><span
                                                    class="dot dot-broken"></span> Hỏng hóc</button>
                                            <button class="dropdown-item-status" style="color: #E11D48;"
                                                onclick="updateStatus({{ $e['id'] }}, 7, event)"><span
                                                    class="dot dot-insp"></span> Cần kiểm tra</button>
                                            <button class="dropdown-item-status" style="color: #475569;"
                                                onclick="updateStatus({{ $e['id'] }}, 8, event)"><span
                                                    class="dot dot-scrapped"></span> Đã hỏng/Thay thế</button>
                                            <button class="dropdown-item-status" style="color: #64748B;"
                                                onclick="updateStatus({{ $e['id'] }}, 3, event)"><span
                                                    class="dot dot-offline"></span> Đã thanh lý</button>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="action-btn-group">
                                        <a href="{{ route('admin.equipments.edit', $e['id']) }}" class="action-btn"
                                            style="color:#3B82F6" title="Sửa"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('admin.equipments.destroy', $e['id']) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn" style="color:#EF4444" title="Xóa"
                                                onclick="return confirm('Xóa thiết thiết bị này?')"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted" style="font-size: 11px; font-weight: 600;">
                        Hiển thị <span
                            class="text-dark">{{ ($pagination['currentPage'] - 1) * $pagination['pageSize'] + 1 }} -
                            {{ min($pagination['currentPage'] * $pagination['pageSize'], $pagination['totalCount']) }}</span>
                        trong số <span class="text-dark">{{ $pagination['totalCount'] }}</span> thiết bị
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Nút Trang trước --}}
                            <li class="page-item {{ $pagination['currentPage'] <= 1 ? 'disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $pagination['currentPage'] > 1 ? request()->fullUrlWithQuery(['page' => $pagination['currentPage'] - 1]) : '#' }}">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>

                            {{-- Các số trang --}}
                            @for ($i = 1; $i <= $pagination['totalPages']; $i++)
                                @if ($i == 1 || $i == $pagination['totalPages'] || ($i >= $pagination['currentPage'] - 1 && $i <= $pagination['currentPage'] + 1))
                                    <li class="page-item {{ $pagination['currentPage'] == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                    </li>
                                @elseif ($i == 2 || $i == $pagination['totalPages'] - 1)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                            @endfor

                            <li
                                class="page-item {{ $pagination['currentPage'] >= $pagination['totalPages'] ? 'disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ request()->fullUrlWithQuery(['page' => $pagination['currentPage'] + 1]) }}"
                                    aria-label="Next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleStatusMenu(id, event) {
            event.stopPropagation();
            document.querySelectorAll('.custom-dropdown-content').forEach(m => {
                if (m.id !== 'menu-' + id) m.classList.remove('show');
            });
            const menu = document.getElementById('menu-' + id);
            menu.classList.toggle('show');
        }

        document.addEventListener('click', function () {
            document.querySelectorAll('.custom-dropdown-content').forEach(m => m.classList.remove('show'));
        });

        async function updateStatus(id, newStatusValue, event) {
            if (event) event.stopPropagation();

            const badgeBtn = document.getElementById(`badge-${id}`);
            const menu = document.getElementById(`menu-${id}`);
            if (menu) menu.classList.remove('show');

            if (!badgeBtn) return;
            const label = badgeBtn.querySelector('.status-label');
            const dot = badgeBtn.querySelector('.dot');

            const uiMap = {
                0: { class: 'bg-active-light', dot: 'dot-active', text: 'Đang hoạt động' },
                1: { class: 'bg-maint-light', dot: 'dot-maint', text: 'Đang bảo trì' },
                2: { class: 'bg-broken-light', dot: 'dot-broken', text: 'Hỏng hóc' },
                3: { class: 'bg-disposed-light', dot: 'dot-offline', text: 'Đã thanh lý' },
                4: { class: 'bg-idle-light', dot: 'dot-idle', text: 'Chưa sử dụng' },
                5: { class: 'bg-req-light', dot: 'dot-req', text: 'Cần bảo trì' },
                6: { class: 'bg-parts-light', dot: 'dot-parts', text: 'Chờ linh kiện' },
                7: { class: 'bg-insp-light', dot: 'dot-insp', text: 'Cần kiểm tra' },
                8: { class: 'bg-scrapped-light', dot: 'dot-scrapped', text: 'Đã hỏng/Thay thế' }
            };

            badgeBtn.style.opacity = '0.5';

            try {
                const response = await fetch(`http://127.0.0.1:5083/api/v1/equipments/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: parseInt(newStatusValue) })
                });

                if (response.ok) {
                    const ui = uiMap[newStatusValue];
                    badgeBtn.className = `status-badge-btn ${ui.class}`;
                    dot.className = `dot ${ui.dot}`;
                    label.innerText = ui.text;
                    if (window.toastr) toastr.success(`Cập nhật thành công`);
                } else {
                    alert('Lỗi: Không thể cập nhật trạng thái.');
                }
            } catch (error) {
                alert('Lỗi kết nối Backend. Vui lòng kiểm tra API (5083).');
            } finally {
                badgeBtn.style.opacity = '1';
            }
        }
    </script>
@endsection