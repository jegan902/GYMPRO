<?php
/**
 * Seed exercises data - matches actual DB schema
 */
require_once __DIR__ . '/../config/config.php';

$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pdo->exec("SET NAMES utf8mb4");

// muscle_group_id mapping: 1=Chest, 2=Back, 3=Shoulders, 4=Biceps, 5=Triceps, 6=Legs, 7=Abs
$exercises = [
    // Chest (1)
    [1, 'Bench Press', 'Bài tập nền tảng cho ngực', 3, '8-12', 'intermediate', 'Barbell'],
    [1, 'Incline Dumbbell Press', 'Phát triển ngực trên', 3, '10-12', 'intermediate', 'Dumbbell'],
    [1, 'Cable Fly', 'Tách cơ ngực', 3, '12-15', 'beginner', 'Cable Machine'],
    [1, 'Push-up', 'Bài tập cơ bản không dụng cụ', 3, '15-20', 'beginner', 'Bodyweight'],
    // Back (2)
    [2, 'Deadlift', 'Bài compound chính cho lưng', 4, '5-8', 'advanced', 'Barbell'],
    [2, 'Lat Pulldown', 'Phát triển bề ngang lưng', 3, '10-12', 'beginner', 'Cable Machine'],
    [2, 'Barbell Row', 'Tăng độ dày cơ lưng', 3, '8-12', 'intermediate', 'Barbell'],
    [2, 'Pull-up', 'Bài bodyweight cho lưng', 3, '8-12', 'intermediate', 'Pull-up Bar'],
    // Shoulders (3)
    [3, 'Overhead Press', 'Bài compound cho vai', 3, '8-12', 'intermediate', 'Barbell'],
    [3, 'Lateral Raise', 'Phát triển vai giữa', 3, '12-15', 'beginner', 'Dumbbell'],
    [3, 'Face Pull', 'Vai sau và rotator cuff', 3, '15-20', 'beginner', 'Cable Machine'],
    // Biceps (4)
    [4, 'Barbell Curl', 'Bài cơ bản cho biceps', 3, '10-12', 'beginner', 'Barbell'],
    [4, 'Hammer Curl', 'Phát triển brachialis', 3, '10-12', 'beginner', 'Dumbbell'],
    // Triceps (5)
    [5, 'Tricep Pushdown', 'Cô lập triceps', 3, '12-15', 'beginner', 'Cable Machine'],
    [5, 'Skull Crusher', 'Phát triển đầu dài triceps', 3, '10-12', 'intermediate', 'EZ Bar'],
    // Legs (6)
    [6, 'Squat', 'Bài compound chính cho chân', 4, '8-12', 'intermediate', 'Barbell'],
    [6, 'Leg Press', 'Thay thế squat an toàn', 3, '10-12', 'beginner', 'Leg Press Machine'],
    [6, 'Romanian Deadlift', 'Hamstring và mông', 3, '10-12', 'intermediate', 'Barbell'],
    [6, 'Leg Curl', 'Cô lập hamstring', 3, '12-15', 'beginner', 'Leg Curl Machine'],
    [6, 'Calf Raise', 'Bắp chân', 3, '15-20', 'beginner', 'Smith Machine'],
    // Abs (7)
    [7, 'Plank', 'Core stability', 3, '30-60s', 'beginner', 'Bodyweight'],
    [7, 'Cable Crunch', 'Phát triển cơ bụng', 3, '15-20', 'beginner', 'Cable Machine'],
    [7, 'Hanging Leg Raise', 'Bụng dưới', 3, '12-15', 'intermediate', 'Pull-up Bar'],
];

$stmt = $pdo->prepare("INSERT INTO exercises (muscle_group_id, name, description, sets_recommended, reps_recommended, level, equipment) VALUES (?, ?, ?, ?, ?, ?, ?)");
foreach ($exercises as $ex) {
    try {
        $stmt->execute($ex);
        echo "✓ {$ex[1]}\n";
    } catch(Exception $e) {
        echo "✗ {$ex[1]}: {$e->getMessage()}\n";
    }
}

echo "\nDone! " . count($exercises) . " exercises processed.\n";
