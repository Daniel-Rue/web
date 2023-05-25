<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка наличия и тип данных в $_POST
    if (isset($_POST['student_id']) && isset($_POST['group_id'])) {
        $studentID = $_POST['student_id'];
        $groupID = $_POST['group_id'];

        // Создаем подготовленное выражение для добавления студента в группу
        $stmt = $pdo->prepare("INSERT INTO studentgroupmemberships (StudentID, GroupID) VALUES (?, ?)");

        // Выполняем добавление студента в группу
        if ($stmt->execute([$studentID, $groupID])) {
            header('Location: pages/admin_dashboard.php'); // Возврат на страницу администратора
            exit;
        } else {
            die("Ошибка при добавлении студента в группу");
        }
    }
} else {
    die("Некорректный запрос");
}
?>
