<?php
require 'config.php';

if (!isset($_POST['selectedStudents'])) {
    header('Location: ../pages/admin_dashboard.php');
    exit();
}

$selectedStudents = $_POST['selectedStudents'];

foreach ($selectedStudents as $studentID) {
    $stmt = $pdo->prepare("DELETE FROM StudentGroupMemberships WHERE StudentID = ?");
    $stmt->execute([$studentID]);
}

header('Location: pages/admin_dashboard.php');
exit();
?>