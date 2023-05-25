<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка наличия 'selectedClasses' в $_POST
    if (!empty($_POST['selectedClasses']) && is_array($_POST['selectedClasses'])) {
        // Создаем подготовленное выражение для удаления классов
        $stmt = $pdo->prepare("DELETE FROM classes WHERE id = ?");

        // Цикл по всем выбранным классам
        foreach ($_POST['selectedClasses'] as $classID) {
            // Проверка успешности удаления каждого класса
            if (!$stmt->execute([$classID])) {
                die("Ошибка при удалении класса с ID {$classID}");
            }
        }
    }
    header('Location: pages/admin_dashboard.php'); // Возврат на страницу администратора
} else {
    die("Некорректный запрос");
}
?>








