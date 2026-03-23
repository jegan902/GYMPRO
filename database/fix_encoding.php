<?php
/**
 * Fix all remaining Vietnamese encoding in DB
 */
require_once __DIR__ . '/../config/config.php';

$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pdo->exec("SET NAMES utf8mb4");

// Fix muscle groups
$muscles = [
    [1, 'Chest', 'Ngực'],
    [2, 'Back', 'Lưng'],
    [3, 'Shoulders', 'Vai'],
    [4, 'Biceps', 'Tay trước'],
    [5, 'Triceps', 'Tay sau'],
    [6, 'Legs', 'Chân'],
    [7, 'Abs', 'Bụng'],
];
$stmt = $pdo->prepare("UPDATE muscle_groups SET name=?, name_vi=? WHERE id=?");
foreach ($muscles as $m) {
    $stmt->execute([$m[1], $m[2], $m[0]]);
    echo "✓ Muscle #{$m[0]}: {$m[2]}\n";
}

// Fix user names
$users = [
    [1, 'Admin'],
    [2, 'Nhân viên Demo'],
];
$stmt2 = $pdo->prepare("UPDATE users SET full_name=? WHERE id=?");
foreach ($users as $u) {
    $stmt2->execute([$u[1], $u[0]]);
    echo "✓ User #{$u[0]}: {$u[1]}\n";
}

// Fix exercise descriptions
$exercises = [
    ['Bench Press', 'Bài tập nền tảng cho ngực'],
    ['Incline Dumbbell Press', 'Phát triển ngực trên'],
    ['Cable Fly', 'Tách cơ ngực'],
    ['Push-up', 'Bài tập cơ bản không dụng cụ'],
    ['Deadlift', 'Bài compound chính cho lưng'],
    ['Lat Pulldown', 'Phát triển bề ngang lưng'],
    ['Barbell Row', 'Tăng độ dày cơ lưng'],
    ['Pull-up', 'Bài bodyweight cho lưng'],
    ['Overhead Press', 'Bài compound cho vai'],
    ['Lateral Raise', 'Phát triển vai giữa'],
    ['Face Pull', 'Vai sau và rotator cuff'],
    ['Barbell Curl', 'Bài cơ bản cho biceps'],
    ['Hammer Curl', 'Phát triển brachialis'],
    ['Tricep Pushdown', 'Cô lập triceps'],
    ['Skull Crusher', 'Phát triển đầu dài triceps'],
    ['Squat', 'Bài compound chính cho chân'],
    ['Leg Press', 'Thay thế squat an toàn'],
    ['Romanian Deadlift', 'Hamstring và mông'],
    ['Leg Curl', 'Cô lập hamstring'],
    ['Calf Raise', 'Bắp chân'],
    ['Plank', 'Core stability'],
    ['Cable Crunch', 'Phát triển cơ bụng'],
    ['Hanging Leg Raise', 'Bụng dưới'],
];
$stmt3 = $pdo->prepare("UPDATE exercises SET description=? WHERE name=?");
foreach ($exercises as $ex) {
    $stmt3->execute([$ex[1], $ex[0]]);
    echo "✓ Exercise: {$ex[0]}\n";
}

echo "\nDone! All encoding fixed.\n";
