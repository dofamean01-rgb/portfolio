<?php
header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=portfolio_db;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'works':
        $stmt = $pdo->query('SELECT title, type, description, link FROM works WHERE user_id = 1');
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
        break;

    case 'skills':
        $stmt = $pdo->query('SELECT name, level FROM skills WHERE user_id = 1');
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
        break;

    case 'grades':
        $stmt = $pdo->query('
            SELECT s.name AS subject, g.term, g.grade
            FROM grades g
            JOIN subjects s ON s.id = g.subject_id
            WHERE g.user_id = 1
        ');
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
        break;

    case 'profile':
        $stmt = $pdo->query('
            SELECT full_name, email, city, course, github, avatar_url
            FROM users WHERE id = 1
        ');
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
        break;

    default:
        echo json_encode(['error' => 'Unknown action'], JSON_UNESCAPED_UNICODE);
}
