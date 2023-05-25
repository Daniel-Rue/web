<?php
require 'config.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "CALL getUser(?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username, $password]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION['userid'] = $user['id'];
    $_SESSION['role'] = $user['RoleID'];
    
    switch($_SESSION['role']) {
        case 1: header('Location: pages/admin_dashboard.php'); break;
        case 2: header('Location: pages/director_dashboard.php'); break;
        case 3: header('Location: pages/student_dashboard.php'); break;
        case 4: header('Location: pages/teacher_dashboard.php'); break;
    }
} else {
    $_SESSION['login_error'] = true;
    header('Location: pages/cabinet.php');
    exit;
}
?>
