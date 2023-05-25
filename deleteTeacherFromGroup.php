<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка наличия 'selectedTeachers' в $_POST
    if (!empty($_POST['selectedTeachers']) && is_array($_POST['selectedTeachers'])) {
        // Создаем подготовленное выражение для удаления учителей из группы
        $stmt = $pdo->prepare("UPDATE studentgroups SET TeacherID = NULL WHERE TeacherID = ?");

        // Цикл по всем выбранным учителям
        foreach ($_POST['selectedTeachers'] as $teacherID) {
            // Проверка успешности удаления каждого учителя
            if (!$stmt->execute([$teacherID])) {
                die("Ошибка при удалении учителя с ID {$teacherID} из группы");
            }
        }
    }
    header('Location: pages/admin_dashboard.php'); // Возврат на страницу администратора
} else {
    die("Некорректный запрос");
}
?>
