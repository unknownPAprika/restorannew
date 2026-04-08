<?php
require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM reservations ORDER BY created_at DESC");
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель | Бронирования</title>
    <style>
        body { font-family: Inter, sans-serif; background: #0a0a0a; color: #f0f0f0; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #8b0000; padding: 10px; text-align: left; }
        th { background: #8b0000; color: white; }
        tr:nth-child(even) { background: #1a1a1a; }
    </style>
</head>
<body>
    <h1>Список бронирований</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Телефон</th>
            <th>Дата</th>
            <th>Время</th>
            <th>Гостей</th>
            <th>Создано</th>
        </tr>
        <?php foreach ($reservations as $r): ?>
        <tr>
            <td><?= $r['id'] ?></td>
            <td><?= htmlspecialchars($r['name']) ?></td>
            <td><?= htmlspecialchars($r['phone']) ?></td>
            <td><?= $r['reservation_date'] ?></td>
            <td><?= $r['reservation_time'] ?></td>
            <td><?= $r['guests'] ?></td>
            <td><?= $r['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>