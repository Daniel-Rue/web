<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка наличия и тип данных в $_POST
    if (isset($_POST['group_id']) && isset($_POST['teacher_id'])) {
        $groupID = $_POST['group_id'];
        $teacherID = $_POST['teacher_id'];

        // Обновление записи в таблице studentgroups
        $stmt = $pdo->prepare("UPDATE studentgroups SET TeacherID = ? WHERE id = ?");
        $stmt->execute([$teacherID, $groupID]);

        header('Location: pages/admin_dashboard.php'); // Возврат на страницу администратора
        exit;
    }
} else {
    die("Некорректный запрос");
}
?>
