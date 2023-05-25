<?php
require 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// Создаем подготовленное выражение для добавления пользователя
$stmt = $pdo->prepare("INSERT INTO users (Name, Password, RoleID) VALUES (?, ?, ?)");

if ($stmt->execute([$username, $password, $role])) {
    $userID = $pdo->lastInsertId(); // Получаем ID только что добавленного пользователя

    if ($role == 3) {
        // Добавляем пользователя в таблицу студентов
        $stmt = $pdo->prepare("INSERT INTO students (UserID) VALUES (?)");
        $stmt->execute([$userID]);
    } elseif ($role == 4) {
        $passport = $_POST['passport']; // Получаем значение паспорта из формы

        // Добавляем пользователя в таблицу сотрудников
        $stmt = $pdo->prepare("INSERT INTO employees (UserID, Passport) VALUES (?, ?)");
        $stmt->execute([$userID, $passport]);

        // Получаем ID только что добавленного сотрудника
        $employeeID = $pdo->lastInsertId();

        // Добавляем учителя в таблицу учителей
        $stmt = $pdo->prepare("INSERT INTO teachers (EmployeeID) VALUES (?)");
        $stmt->execute([$employeeID]);
    }

    header('Location: pages/cabinet.php');
    exit();
} else {
    echo 'Ошибка при регистрации пользователя';
}
?>
