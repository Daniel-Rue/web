<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['activity_id']) && !empty($_POST['teacher_id'])) {
        $stmt = $pdo->prepare("INSERT INTO StudentGroups (ActivityID, TeacherID) VALUES (?, ?)");
        if (!$stmt->execute([$_POST['activity_id'], $_POST['teacher_id']])) {
            die("Ошибка при добавлении группы");
        }
    }
    header('Location: pages/admin_dashboard.php'); // Возврат на страницу администратора
} else {
    die("Некорректный запрос");
}
?>