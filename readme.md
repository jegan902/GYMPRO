🏋️ GYM MANAGEMENT & SMART FITNESS SYSTEM
========================================

## 1. GIỚI THIỆU
Hệ thống quản lý phòng GYM hiện đại được tái cấu trúc (refactored) theo mô hình **Decoupled Architecture** (Backend và Frontend tách biệt).

## 2. KIẾN TRÚC HỆ THỐNG CÁCH TÂN
Dự án hiện được chia thành 2 phần chính:

### 2.1 Backend (.NET 8 Web API)
- **Vị trí**: `/Backend/GymApi`
- **Công nghệ**: ASP.NET Core 8, Entity Framework Core, JWT Authentication, MySQL.
- **Chức năng**: Xử lý toàn bộ logic nghiệp vụ, quản lý database, cung cấp API bảo mật cho Frontend.

### 2.2 Frontend (PHP Framework)
- **Vị trí**: `/Fontend`
- **Công nghệ**: Laravel 12, Blade Templates, Guzzle HTTP Client.
- **Chức năng**: Giao diện người dùng (UI/UX), tương tác với người dùng và gọi API từ Backend.

## 3. HƯỚNG DẪN CHẠY DỰ ÁN

### 3.1 Chạy Backend
1. Di chuyển vào thư mục backend: `cd Backend/GymApi`
2. Chạy lệnh: `dotnet run`
3. Swagger UI sẽ có sẵn tại: `http://localhost:5083/swagger` (hoặc cổng được cấu hình).

### 3.2 Chạy Frontend
1. Di chuyển vào thư mục frontend: `cd Fontend`
2. Cài đặt dependency: `composer install`
3. Cấu hình `.env` (BACKEND_API_URL trỏ về port của Backend).
4. Chạy lệnh: `php artisan serve`
5. Truy cập tại: `http://localhost:8000`.

## 4. CÁC MODULE CHÍNH
- **Quản lý thành viên**: CRUD, chỉ số sức khỏe (BMI, BMR).
- **Gói tập & Hóa đơn**: Quản lý đăng ký, kích hoạt và hết hạn.
- **Dinh dưỡng & Bài tập**: Diet plans, Workout plans (Beginner/Intermediate/Advanced).
- **Theo dõi tiến trình**: Exercise logs, biểu đồ tiến triển.
- **Vận hành**: Check-in QR, Quản lý thiết bị, Thông báo tự động.

## 5. BẢO MẬT
- **JWT (JSON Web Tokens)**: Bảo mật giao tiếp giữa Frontend và Backend.
- **BCrypt**: Mã hóa mật khẩu người dùng.
- **Middleware**: Phân quyền truy cập dựa trên Role (Admin, Staff, Member).