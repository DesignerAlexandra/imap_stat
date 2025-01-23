<?php
$db = new PDO("mysql:host=localhost;dbname=fluidline_stat", "root", "123123");

// Получение статистики писем
$mailStats = $db->query("SELECT * FROM mail_data ORDER BY date DESC")->fetchAll(PDO::FETCH_ASSOC);

// Статистика по сайтам
$siteStats = $db->query("
    SELECT site, COUNT(*) as count 
    FROM mail_data 
    GROUP BY site
")->fetchAll(PDO::FETCH_ASSOC);

// Статистика ошибок
$errorStats = $db->query("SELECT * FROM email_errors ORDER BY date DESC")->fetchAll(PDO::FETCH_ASSOC);

// Общая статистика
$totalStats = [
    'total' => $db->query("SELECT COUNT(*) FROM mail_data")->fetchColumn(),
    'today' => $db->query("
        SELECT COUNT(*) FROM mail_data 
        WHERE DATE(date) = CURDATE()
    ")->fetchColumn()
];

echo json_encode([
    'mailStats' => $mailStats,
    'siteStats' => $siteStats,
    'errorStats' => $errorStats,
    'totalStats' => $totalStats
]);
