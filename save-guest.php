<?php
// save-guest.php
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    die('Нет данных');
}

$data['server_timestamp'] = date('Y-m-d H:i:s');
$data['ip'] = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

$logFile = __DIR__ . '/guests_data.json';

$existing = [];
if (file_exists($logFile)) {
    $existing = json_decode(file_get_contents($logFile), true) ?? [];
}

$existing[] = $data;
file_put_contents($logFile, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode(['status' => 'ok']);
