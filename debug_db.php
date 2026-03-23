<?php
require_once 'config/config.php';
try {
    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $stmt = $db->query('SHOW TABLES');
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables in " . DB_NAME . ":\n";
    print_r($tables);
    
    if (in_array('news', $tables)) {
        echo "\nSUCCESS: news table exists.\n";
        $count = $db->query('SELECT COUNT(*) FROM news')->fetchColumn();
        echo "Row count in news: $count\n";
    } else {
        echo "\nFAILURE: news table does NOT exist.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
