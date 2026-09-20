<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Метод не разрешён']);
    exit;
}

$name    = trim($_POST['name']  ?? '');
$phone   = trim($_POST['phone'] ?? '');
$email   = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $phone === '' || $email === '') {
    echo json_encode(['success' => false, 'error' => 'Заполните все обязательные поля']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Некорректный email']);
    exit;
}

if (!preg_match('/^[0-9+\-\s()]{5,30}$/', $phone)) {
    echo json_encode(['success' => false, 'error' => 'Некорректный номер телефона']);
    exit;
}

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=portfolio_db;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $stmt = $pdo->prepare(
        'INSERT INTO applications (name, phone, email, message) VALUES (?, ?, ?, ?)'
    );
    $stmt->execute([$name, $phone, $email, $message]);

    echo json_encode(['success' => true, 'message' => 'Заявка отправлена']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Ошибка базы данных: ' . $e->getMessage()]);
}
