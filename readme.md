🏋️ GYM MANAGEMENT & SMART FITNESS SYSTEM
SOFTWARE REQUIREMENT SPECIFICATION (SRS)
1. GIỚI THIỆU
1.1 Mục đích tài liệu

Tài liệu này mô tả đầy đủ các yêu cầu chức năng và phi chức năng của hệ thống Gym Management & Smart Fitness System.
Hệ thống nhằm hỗ trợ:

Quản lý vận hành phòng gym

Hỗ trợ hội viên tập luyện & dinh dưỡng thông minh

Theo dõi tiến trình sức khỏe và thể hình

1.2 Phạm vi hệ thống

Hệ thống gồm 2 phân hệ chính:

Gym Management System

Quản lý thành viên

Gói tập & hóa đơn

Check-in

Thiết bị

Thông báo

Báo cáo thống kê

Smart Fitness Support System

BMI, BMR, TDEE

Gợi ý dinh dưỡng

Workout plan

Theo dõi tiến trình

AI rule-based suggestion

1.3 Công nghệ sử dụng

PHP (MVC thuần OOP)

MySQL

HTML5, CSS3, Bootstrap

JavaScript, AJAX

Chart.js

2. TỔNG QUAN HỆ THỐNG
2.1 Kiến trúc hệ thống (MVC)

/app
/controllers
/models
/views
/core
/config
/public

2.2 Phân quyền người dùng
2.2.1 Admin

Quản lý tài khoản người dùng

Quản lý thành viên

Quản lý gói tập

Quản lý hóa đơn

Quản lý chế độ ăn

Quản lý bài tập & giáo án

Quản lý thiết bị

Quản lý cấu hình hệ thống

Xem báo cáo & thống kê

2.2.2 Nhân viên (Staff)

Thêm / Sửa thành viên

Tạo hóa đơn

Gán giáo án

Gán chế độ ăn

Check-in hội viên

2.2.3 Hội viên (Member)

Đăng ký / Đăng nhập

Xem thông tin cá nhân

Xem gói tập

Xem hóa đơn

Xem chế độ ăn

Xem giáo án tập

Lưu lịch sử tập

Theo dõi cân nặng

Nhận thông báo

3. YÊU CẦU CHỨC NĂNG
3.1 MODULE 1 – QUẢN LÝ THÀNH VIÊN
Chức năng:

CRUD thành viên

Upload ảnh đại diện

Tính BMI tự động

Theo dõi trạng thái gói tập

3.2 MODULE 2 – GÓI TẬP & HÓA ĐƠN
3.2.1 Quản lý gói tập

Thông tin bao gồm:

Tên gói

Thời hạn (duration)

Giá tiền

Mô tả

3.2.2 Quản lý hóa đơn

Thông tin gồm:

Thành viên

Gói tập

Ngày thanh toán

Số tiền

Phương thức thanh toán

Trạng thái:

Pending

Paid

Cancelled

transaction_id (nếu tích hợp thanh toán online)

3.3 MODULE 3 – CHẾ ĐỘ DINH DƯỠNG
Mục tiêu:

Giảm béo

Tăng cân

Tăng cơ

Duy trì

Tính năng:

Admin tạo diet plan

Gán diet plan cho hội viên

Hội viên xem thực đơn

3.4 MODULE 4 – BMI, BMR, TDEE & GỢI Ý
3.4.1 Tính BMI

BMI = weight / (height × height)

Phân loại:

< 18.5 → Tăng cân

18.5 – 24.9 → Duy trì / Tăng cơ

≥ 25 → Giảm mỡ

3.4.2 Tính BMR (Mifflin-St Jeor)

Nam:
BMR = 10W + 6.25H − 5A + 5

Nữ:
BMR = 10W + 6.25H − 5A − 161

3.4.3 Tính TDEE

TDEE = BMR × Activity Level

Activity Level:

1.2 (Ít vận động)

1.375 (Tập nhẹ 1–3 buổi)

1.55 (Tập trung bình 3–5 buổi)

1.725 (Tập nặng 6–7 buổi)

3.4.4 Phân chia Macro

Tăng cơ: Protein 30–35%

Giảm mỡ: Thâm hụt Calo + Protein cao

Duy trì: 40/30/30

3.5 MODULE 5 – WORKOUT SYSTEM
3.5.1 Nhóm cơ

Ngực

Lưng

Vai

Tay trước

Tay sau

Chân

Bụng

3.5.2 Bài tập

Thông tin:

Tên bài tập

Mô tả

Sets

Reps

Video URL

Level (Beginner / Intermediate / Advanced)

Equipment required

Cho phép lọc:

Theo nhóm cơ

Theo độ khó

Theo mục tiêu

3.5.3 Workout Plan

Beginner (3 buổi/tuần)

Intermediate (5 buổi/tuần)

Custom workout cá nhân

3.6 MODULE 6 – THEO DÕI TIẾN TRÌNH
3.6.1 Lưu lịch sử tập

Bảng exercise_logs:

member_id

exercise_id

workout_session_id

set_number

reps

weight

log_date

3.6.2 Theo dõi chỉ số cơ thể

Cân nặng

Body fat

Muscle mass

3.6.3 Biểu đồ tiến trình

Biểu đồ cân nặng

Biểu đồ mức tạ

Sử dụng Chart.js

3.7 MODULE 7 – AI RULE-BASED SUGGESTION

Dựa vào:

BMI

Mục tiêu

Lịch sử tập

Ví dụ:

BMI cao → Tăng cardio

Thiếu cân → Tăng volume + protein

4. MODULE VẬN HÀNH NÂNG CAO
4.1 Quản lý thiết bị

Bảng equipments:

name

category

status (Active / Broken / Maintenance)

last_maintenance_date

next_maintenance_date

note

Chức năng:

Thêm/Sửa/Xóa

Cảnh báo bảo trì

4.2 Hệ thống Check-in

Bảng attendance:

member_id

check_in_time

check_out_time

method (QR / Manual)

Chức năng:

Giới hạn số lần check-in/ngày

Thống kê giờ cao điểm

Thống kê lượt tập

4.3 Hệ thống Thông báo

Bảng notifications:

member_id

title

message

type (expiry, reminder, system)

is_read

created_at

Chức năng:

Thông báo gói sắp hết hạn

Nhắc nhở lâu không tập

Thông báo hệ thống

5. CƠ CHẾ LOGIC THEO THỜI GIAN (TIME-BASED LOGIC)
5.1 Kích hoạt gói tập

Sử dụng bảng member_packages:

member_id

package_id

start_date

end_date

status (Active / Expired / Pending)

payment_status

Logic:

Thanh toán → status = Pending

Kích hoạt → set start_date

end_date = start_date + duration

Hết hạn → status = Expired

5.2 Tự động xử lý hết hạn

Hai phương án:

Cách 1: Cron Job (Khuyến nghị)

Mỗi ngày chạy script

Nếu current_date > end_date → update Expired

Cách 2: Kiểm tra khi đăng nhập

So sánh current_date với end_date

Nếu hết hạn → update ngay

Ràng buộc:

Member Expired không được check-in

Không được lưu workout

6. TRẢI NGHIỆM NGƯỜI DÙNG (UX – MOBILE FIRST)
6.1 Responsive Design

Mobile-first

Nút +/- lớn

Font rõ ràng

Sticky button “Lưu buổi tập”

6.2 Offline nhẹ (LocalStorage)

Flow:

Nhập dữ liệu → auto-save local

Có mạng → sync server

Thành công → clear LocalStorage

Không mất dữ liệu khi mất mạng.

7. SYSTEM SETTINGS (CẤU HÌNH HỆ THỐNG)
7.1 Bảng settings

setting_key

setting_value

description

7.2 Các cấu hình
Thông tin phòng gym

gym_name

address

hotline

logo_url

Cấu hình Fitness

default_activity_level

calorie_formula_type

macro_ratio_bulk

macro_ratio_cut

Cấu hình Check-in

max_checkin_per_day

allow_multiple_sessions

peak_hour_range

8. DATABASE DỰ KIẾN

Các bảng chính:

users

members

packages

member_packages

invoices

diet_plans

meals

muscle_groups

exercises

workout_plans

workout_sessions

exercise_logs

body_metrics

attendance

notifications

equipments

settings

9. BẢO MẬT HỆ THỐNG

password_hash()

CSRF token

Session timeout

Middleware phân quyền

Validate & sanitize input

Kiểm tra role trước mỗi controller

10. LỘ TRÌNH TRIỂN KHAI
Giai đoạn 1

Xây dựng MVC Core

Authentication & Authorization

Giai đoạn 2

Thành viên

Gói tập

Hóa đơn

Giai đoạn 3

BMI

Diet

Workout plan

Giai đoạn 4

Workout logs

Body metrics

Biểu đồ

Giai đoạn 5

AI suggestion

Check-in

Notifications

Equipment

Hoàn thiện UI

11. KẾT LUẬN

Hệ thống sau khi hoàn thiện sẽ:

Quản lý vận hành phòng gym thực tế

Hỗ trợ Smart Fitness đầy đủ

Có logic thời gian chặt chẽ

Theo dõi tiến trình chi tiết từng set

Tối ưu Mobile UX

Có thể triển khai thực tế hoặc phát triển thành sản phẩm thương mại