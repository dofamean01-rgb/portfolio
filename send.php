<?php
header('Content-Type: application/json; charset=utf-8');

// Разрешаем запросы только методом POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Метод не разрешён']);
    exit;
}

// Получаем данные из формы
$name  = trim($_POST['name']  ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

// Проверка на пустые поля
if ($name === '' || $phone === '' || $email === '') {
    echo json_encode(['success' => false, 'error' => 'Заполните все обязательные поля']);
    exit;
}

// Проверка email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Некорректный email']);
    exit;
}

// Проверка телефона (только цифры, пробелы, +, -, скобки)
if (!preg_match('/^[0-9+\-\s()]{5,30}$/', $phone)) {
    echo json_encode(['success' => false, 'error' => 'Некорректный номер телефона']);
    exit;
}

// Подключение к базе
try {
    $pdo = new PDO(
    'mysql:host=sql203.infinityfree.com;dbname=if0_42964744;charset=utf8mb4',
    'if0_42964744',
    'wqG7PkvT3FvnO'
);

    // Подготовленный запрос — защита от SQL-инъекций
    $stmt = $pdo->prepare(
        'INSERT INTO applications (name, phone, email, message) VALUES (?, ?, ?, ?)'
    );
    $stmt->execute([$name, $phone, $email, $message]);

    echo json_encode(['success' => true, 'message' => 'Заявка отправлена']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Ошибка базы данных']);
}