<?php
require_once __DIR__ . '/config/config.php';

$db_host = DB_HOST;
$db_user = DB_USER;
$db_pass = DB_PASS;
$db_name = DB_NAME;

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = file_get_contents('database/news_table.sql');
    $pdo->exec($sql);

    echo "Successfully created and seeded news table.\n";
} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage() . "\n");
}
