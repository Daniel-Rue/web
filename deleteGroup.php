<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['selectedGroups']) && is_array($_POST['selectedGroups'])) {
        $stmt = $pdo->prepare("DELETE FROM StudentGroups WHERE id = ?");
        foreach ($_POST['selectedGroups'] as $groupID) {
            if (!$stmt->execute([$groupID])) {
                die("Ошибка при удалении группы с ID {$groupID}");
            }
        }
    }
    header('Location: pages/admin_dashboard.php'); // Возврат на страницу администратора
} else {
    die("Некорректный запрос");
}
?>
