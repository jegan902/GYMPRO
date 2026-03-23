<?php
require_once __DIR__ . '/../config/config.php';
$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

echo "=== exercises table ===\n";
$r = $pdo->query('DESCRIBE exercises');
while ($c = $r->fetch(PDO::FETCH_ASSOC)) {
    echo $c['Field'] . ' : ' . $c['Type'] . "\n";
}

echo "\n=== workout_plans table ===\n";
$r = $pdo->query('DESCRIBE workout_plans');
while ($c = $r->fetch(PDO::FETCH_ASSOC)) {
    echo $c['Field'] . ' : ' . $c['Type'] . "\n";
}

echo "\n=== workout_session_exercises table ===\n";
$r = $pdo->query('DESCRIBE workout_session_exercises');
while ($c = $r->fetch(PDO::FETCH_ASSOC)) {
    echo $c['Field'] . ' : ' . $c['Type'] . "\n";
}
