-- ============================================
-- GYM MANAGEMENT & SMART FITNESS SYSTEM
-- Database Schema
-- ============================================

CREATE DATABASE IF NOT EXISTS gym_management
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gym_management;

-- ── Users ──
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('admin', 'staff', 'member', 'user') NOT NULL DEFAULT 'user',
    avatar VARCHAR(255) DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    last_login DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── Members ──
CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other') DEFAULT 'male',
    height DECIMAL(5,2) COMMENT 'cm',
    weight DECIMAL(5,2) COMMENT 'kg',
    bmi DECIMAL(5,2),
    address TEXT,
    emergency_contact VARCHAR(100),
    emergency_phone VARCHAR(20),
    join_date DATE DEFAULT (CURRENT_DATE),
    status ENUM('active', 'inactive', 'expired') DEFAULT 'active',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Packages ──
CREATE TABLE IF NOT EXISTS packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    duration INT NOT NULL COMMENT 'days',
    price DECIMAL(12,2) NOT NULL,
    description TEXT,
    features TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── Member Packages ──
CREATE TABLE IF NOT EXISTS member_packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    package_id INT NOT NULL,
    start_date DATE,
    end_date DATE,
    status ENUM('pending', 'active', 'expired', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('pending', 'paid', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Invoices ──
CREATE TABLE IF NOT EXISTS invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    package_id INT,
    amount DECIMAL(12,2) NOT NULL,
    payment_method ENUM('cash', 'transfer', 'card', 'online') DEFAULT 'cash',
    payment_date DATETIME,
    status ENUM('pending', 'paid', 'cancelled') DEFAULT 'pending',
    transaction_id VARCHAR(100),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ── Diet Plans ──
CREATE TABLE IF NOT EXISTS diet_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    goal ENUM('lose_fat', 'gain_weight', 'build_muscle', 'maintain') NOT NULL,
    total_calories INT,
    protein_grams INT,
    carbs_grams INT,
    fat_grams INT,
    description TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── Meals ──
CREATE TABLE IF NOT EXISTS meals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    diet_plan_id INT NOT NULL,
    meal_name VARCHAR(100) NOT NULL COMMENT 'Breakfast, Lunch, Dinner, Snack',
    food_items TEXT NOT NULL,
    calories INT,
    protein DECIMAL(6,2),
    carbs DECIMAL(6,2),
    fat DECIMAL(6,2),
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (diet_plan_id) REFERENCES diet_plans(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Member Diet Plans (assignment) ──
CREATE TABLE IF NOT EXISTS member_diet_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    diet_plan_id INT NOT NULL,
    assigned_date DATE DEFAULT (CURRENT_DATE),
    status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (diet_plan_id) REFERENCES diet_plans(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Muscle Groups ──
CREATE TABLE IF NOT EXISTS muscle_groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    name_vi VARCHAR(50) NOT NULL,
    icon VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── Exercises ──
CREATE TABLE IF NOT EXISTS exercises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    muscle_group_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    sets_recommended INT DEFAULT 3,
    reps_recommended VARCHAR(20) DEFAULT '10-12',
    video_url VARCHAR(255),
    image_url VARCHAR(255),
    level ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
    equipment VARCHAR(100),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (muscle_group_id) REFERENCES muscle_groups(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Workout Plans ──
CREATE TABLE IF NOT EXISTS workout_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    level ENUM('beginner', 'intermediate', 'advanced', 'custom') DEFAULT 'beginner',
    days_per_week INT DEFAULT 3,
    goal VARCHAR(100),
    description TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── Workout Sessions ──
CREATE TABLE IF NOT EXISTS workout_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    workout_plan_id INT NOT NULL,
    day_number INT NOT NULL,
    session_name VARCHAR(100) NOT NULL,
    focus_area VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (workout_plan_id) REFERENCES workout_plans(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Workout Session Exercises ──
CREATE TABLE IF NOT EXISTS workout_session_exercises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    workout_session_id INT NOT NULL,
    exercise_id INT NOT NULL,
    sets INT DEFAULT 3,
    reps VARCHAR(20) DEFAULT '10-12',
    rest_seconds INT DEFAULT 60,
    sort_order INT DEFAULT 0,
    FOREIGN KEY (workout_session_id) REFERENCES workout_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (exercise_id) REFERENCES exercises(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Member Workout Plans (assignment) ──
CREATE TABLE IF NOT EXISTS member_workout_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    workout_plan_id INT NOT NULL,
    assigned_date DATE DEFAULT (CURRENT_DATE),
    status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (workout_plan_id) REFERENCES workout_plans(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Exercise Logs ──
CREATE TABLE IF NOT EXISTS exercise_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    exercise_id INT NOT NULL,
    workout_session_id INT,
    set_number INT NOT NULL,
    reps INT NOT NULL,
    weight DECIMAL(6,2) COMMENT 'kg',
    log_date DATE NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (exercise_id) REFERENCES exercises(id) ON DELETE CASCADE,
    FOREIGN KEY (workout_session_id) REFERENCES workout_sessions(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ── Body Metrics ──
CREATE TABLE IF NOT EXISTS body_metrics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    weight DECIMAL(5,2) COMMENT 'kg',
    body_fat DECIMAL(5,2) COMMENT '%',
    muscle_mass DECIMAL(5,2) COMMENT 'kg',
    bmi DECIMAL(5,2),
    waist DECIMAL(5,2) COMMENT 'cm',
    chest DECIMAL(5,2) COMMENT 'cm',
    arm DECIMAL(5,2) COMMENT 'cm',
    thigh DECIMAL(5,2) COMMENT 'cm',
    notes TEXT,
    measured_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Attendance ──
CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    check_in_time DATETIME NOT NULL,
    check_out_time DATETIME,
    method ENUM('qr', 'manual') DEFAULT 'manual',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Notifications ──
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    user_id INT,
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('expiry', 'reminder', 'system', 'promotion') DEFAULT 'system',
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── Equipments ──
CREATE TABLE IF NOT EXISTS equipments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(100),
    status ENUM('active', 'broken', 'maintenance') DEFAULT 'active',
    purchase_date DATE,
    last_maintenance_date DATE,
    next_maintenance_date DATE,
    quantity INT DEFAULT 1,
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── Settings ──
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    description VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- SEED DATA
-- ============================================

-- Admin account (password: admin123)
INSERT INTO users (full_name, email, password, phone, role) VALUES
('Admin', 'admin@gym.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0901234567', 'admin');

-- Staff account (password: staff123)
INSERT INTO users (full_name, email, password, phone, role) VALUES
('Nhân viên Demo', 'staff@gym.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0907654321', 'staff');

-- Muscle Groups
INSERT INTO muscle_groups (name, name_vi, icon) VALUES
('Chest', 'Ngực', 'bi-heart-pulse'),
('Back', 'Lưng', 'bi-arrows-expand'),
('Shoulders', 'Vai', 'bi-triangle'),
('Biceps', 'Tay trước', 'bi-lightning'),
('Triceps', 'Tay sau', 'bi-lightning-charge'),
('Legs', 'Chân', 'bi-arrow-down-circle'),
('Abs', 'Bụng', 'bi-grid-3x3');

-- Default Packages
INSERT INTO packages (name, duration, price, description, features) VALUES
('Gói 1 Tháng', 30, 500000, 'Gói tập 1 tháng cơ bản', 'Tập gym tự do, Phòng tắm, Tủ cá nhân'),
('Gói 3 Tháng', 90, 1200000, 'Gói tập 3 tháng tiết kiệm', 'Tập gym tự do, Phòng tắm, Tủ cá nhân, 1 buổi PT miễn phí'),
('Gói 6 Tháng', 180, 2000000, 'Gói tập 6 tháng VIP', 'Tập gym tự do, Phòng tắm, Tủ VIP, 3 buổi PT miễn phí, Nước uống'),
('Gói 12 Tháng', 365, 3500000, 'Gói tập 1 năm Premium', 'Full quyền lợi, PT 5 buổi, Nutrition plan, Towel service');

-- Default Settings
INSERT INTO settings (setting_key, setting_value, description) VALUES
('gym_name', 'GYM FITNESS CENTER', 'Tên phòng gym'),
('address', '123 Đường ABC, Quận XYZ, TP.HCM', 'Địa chỉ'),
('hotline', '0901234567', 'Số hotline'),
('logo_url', '/public/img/logo.png', 'URL logo'),
('default_activity_level', '1.55', 'Mức hoạt động mặc định'),
('calorie_formula_type', 'mifflin', 'Công thức tính BMR'),
('macro_ratio_bulk', '40/30/30', 'Tỷ lệ macro tăng cân'),
('macro_ratio_cut', '40/40/20', 'Tỷ lệ macro giảm mỡ'),
('max_checkin_per_day', '2', 'Số lần check-in tối đa/ngày'),
('allow_multiple_sessions', '0', 'Cho phép nhiều session cùng lúc'),
('peak_hour_range', '17:00-20:00', 'Giờ cao điểm');
