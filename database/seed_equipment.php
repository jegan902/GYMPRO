<?php
/**
 * Seed Equipment Data
 * Run: php database/seed_equipment.php
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

$db = Database::getInstance();

$equipments = [
    ['Máy chạy bộ Impulse AC2990', 'Cardio', 'active', '2024-01-15', '2025-12-01', '2026-06-01', 5, 'Tốc độ max 20km/h, có đo nhịp tim'],
    ['Xe đạp tập Spinning Schwinn', 'Cardio', 'active', '2024-03-20', '2025-11-15', '2026-05-15', 8, 'Có màn hình LCD'],
    ['Máy elliptical Life Fitness', 'Cardio', 'active', '2024-02-10', '2025-10-20', '2026-04-20', 3, ''],
    ['Máy rowing Concept2', 'Cardio', 'active', '2024-06-01', null, '2026-06-01', 2, 'Model D, monitor PM5'],
    ['Bench Press flat', 'Strength', 'active', '2023-08-15', '2025-08-15', '2026-02-15', 4, 'Bao gồm thanh Olympic 20kg'],
    ['Squat Rack Power Cage', 'Strength', 'active', '2023-08-15', '2025-09-01', '2026-03-01', 3, 'Có catch bars an toàn'],
    ['Smith Machine', 'Strength', 'active', '2024-01-20', '2025-07-20', '2026-01-20', 2, 'Có counter balance'],
    ['Leg Press 45 độ', 'Strength', 'active', '2023-10-01', '2025-10-01', '2026-04-01', 2, 'Max load 400kg'],
    ['Cable Crossover Machine', 'Cable Machine', 'active', '2024-04-15', '2025-10-15', '2026-04-15', 2, 'Dual stack, adjustable pulleys'],
    ['Lat Pulldown / Low Row', 'Cable Machine', 'active', '2024-04-15', '2025-11-01', '2026-05-01', 3, 'Combo machine'],
    ['Tạ đơn Dumbbell bộ 1-30kg', 'Free Weight', 'active', '2023-06-01', null, null, 2, 'Rubber coated hex dumbbells'],
    ['Thanh đòn Olympic 20kg', 'Free Weight', 'active', '2023-06-01', null, null, 8, 'Chrome plated, 220cm'],
    ['Tạ đĩa Olympic bộ 300kg', 'Free Weight', 'active', '2023-06-01', null, null, 2, 'Rubber bumper plates'],
    ['Máy Chest Press ngồi', 'Strength', 'active', '2024-05-10', '2025-11-10', '2026-05-10', 2, ''],
    ['Máy Shoulder Press', 'Strength', 'maintenance', '2024-05-10', '2026-02-28', '2026-03-15', 1, 'Đang thay cable'],
    ['Máy Leg Extension', 'Strength', 'active', '2024-05-10', '2025-09-10', '2026-03-10', 2, ''],
    ['Máy Leg Curl nằm', 'Strength', 'broken', '2024-05-10', '2025-12-01', null, 1, 'Hỏng piston thủy lực, chờ phụ tùng'],
    ['GHD machine', 'Strength', 'active', '2024-07-01', null, '2026-07-01', 1, 'Glute Ham Developer'],
    ['Thảm tập Yoga', 'Other', 'active', '2024-01-01', null, null, 20, 'TPE 6mm, chống trượt'],
    ['Bóng tập Swiss Ball 65cm', 'Other', 'active', '2024-01-01', null, null, 10, 'Anti-burst'],
];

$sql = "INSERT INTO equipments (name, category, status, purchase_date, last_maintenance_date, next_maintenance_date, quantity, note) VALUES (:name, :cat, :st, :pd, :lm, :nm, :qty, :note)";

$count = 0;
foreach ($equipments as $eq) {
    $db->query($sql);
    $db->bind(':name', $eq[0]);
    $db->bind(':cat', $eq[1]);
    $db->bind(':st', $eq[2]);
    $db->bind(':pd', $eq[3]);
    $db->bind(':lm', $eq[4]);
    $db->bind(':nm', $eq[5]);
    $db->bind(':qty', $eq[6]);
    $db->bind(':note', $eq[7]);
    $db->execute();
    $count++;
}

echo "✅ Đã thêm {$count} thiết bị vào database!\n";
