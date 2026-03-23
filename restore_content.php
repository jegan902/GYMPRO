<?php
require_once 'config/config.php';
require_once 'core/Database.php';
$db = Database::getInstance();
$articles = [
    ['slug' => 'eat-clean-7-ngay', 'content' => '<h4>1. Eat Clean là gì?</h4><p>Eat Clean (Ăn sạch) là chế độ ăn ưu tiên thực phẩm thực vật, thực phẩm nguyên bản...</p><h4>3. Thực đơn chi tiết 7 ngày</h4><table class="table table-bordered">...</table>'],
    ['slug' => 'top-10-thuc-pham-protein', 'content' => '<h4>1. Tại sao Protein quan trọng?</h4><table class="table table-striped">...</table>'],
    ['slug' => 'loi-ich-uong-nuoc', 'content' => '<h4>1. Nước - Nhiên liệu Gymer</h4><div class="alert alert-info">...</div>'],
    ['slug' => 'lich-tap-5-ngay-cho-moi', 'content' => '<h4>1. Lịch tập chi tiết</h4><ul><li>Thứ 2: Ngực & Triceps...</li></ul>']
];
foreach ($articles as $article) {
    $db->query("UPDATE news SET content = :content WHERE slug = :slug");
    $db->bind(':content', $article['content']);
    $db->bind(':slug', $article['slug']);
    $db->execute();
}
echo "Content restored.\n";
unlink(__FILE__);
