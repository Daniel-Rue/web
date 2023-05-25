<?php
require 'config.php';
session_start();

if (!isset($_SESSION['userid']) || $_SESSION['role'] != 1) {
    header('Location: index.php');
    exit();
}

// Проверка, были ли отправлены данные формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Сбор данных формы
    $class_date = $_POST['class_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $room_id = $_POST['classroom'];
    $group_id = $_POST['group'];

    // Подготовка запроса
    $stmt = $pdo->prepare("CALL addClass(?, ?, ?, ?, ?)");
    // Выполнение запроса
    $stmt->execute([$class_date, $start_time, $end_time, $room_id, $group_id]);

    // Перенаправление на страницу администратора
    header('Location: pages/admin_dashboard.php');
    exit();
}
?>
