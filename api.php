<?php
header('Content-Type: application/json; charset=utf-8');

$pdo = new PDO(
    'mysql:host=sql203.infinityfree.com;dbname=if0_42964744;charset=utf8mb4',
    'if0_42964744',
    'wqG7PkvT3FvnO'
);

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