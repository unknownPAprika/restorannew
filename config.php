<?php
// Путь к файлу базы данных SQLite
// Файл будет создан автоматически, если его нет
$db_file = __DIR__ . '/database.sqlite';

try {
    $pdo = new PDO("sqlite:" . $db_file);
    // Включаем режим исключений для ошибок
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Создаём таблицу reservations, если её ещё нет
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS reservations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            phone TEXT NOT NULL,
            reservation_date DATE NOT NULL,
            reservation_time TIME NOT NULL,
            guests INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
?>