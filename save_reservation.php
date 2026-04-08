<?php
// Отключаем вывод ошибок в стандартный поток (они будут перехвачены)
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

try {
    require_once 'config.php';

    // Разрешаем кросс-доменные запросы (для локальной разработки)
    header("Access-Control-Allow-Origin: *");

    // Получаем данные из POST
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $guests = $_POST['guests'] ?? '';

    if (empty($name) || empty($phone) || empty($date) || empty($time) || empty($guests)) {
        echo json_encode(['success' => false, 'message' => 'Все поля обязательны']);
        exit;
    }

    $sql = "INSERT INTO reservations (name, phone, reservation_date, reservation_time, guests) 
            VALUES (:name, :phone, :date, :time, :guests)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':phone' => $phone,
        ':date' => $date,
        ':time' => $time,
        ':guests' => $guests
    ]);

    echo json_encode(['success' => true, 'message' => 'Бронь успешно сохранена!']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка сервера: ' . $e->getMessage()]);
}
?>