<?php
$pdo = new PDO(
    $pdo = new PDO(
        'mysql:host=localhost;dbname=portfolio_db;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Заявки</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <section class="section">
    <div class="container">
      <h2 class="section__title">Заявки (<?= count($rows) ?>)</h2>
      <div class="table-wrap">
        <table class="table">
          <thead>
            <tr><th>Дата</th><th>Имя</th><th>Телефон</th><th>Email</th><th>Сообщение</th></tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r): ?>
              <tr>
                <td><?= htmlspecialchars($r['created_at']) ?></td>
                <td><?= htmlspecialchars($r['name']) ?></td>
                <td><?= htmlspecialchars($r['phone']) ?></td>
                <td><?= htmlspecialchars($r['email']) ?></td>
                <td><?= htmlspecialchars($r['message']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</body>
</html>
