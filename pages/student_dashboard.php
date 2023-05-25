<?php
ini_set('display_errors', '0');
error_reporting(0);
require '../config.php';
session_start();

if (!isset($_SESSION['userid']) || $_SESSION['role'] != 3) {
    header('Location: ../index.php');
    exit();
}

// Получение информации о студенте
$stmt = $pdo->prepare("CALL getStudentInfo(?)");
$stmt->execute([$_SESSION['userid']]);
$studentInfo = $stmt->fetch();
$stmt->closeCursor();

// Получение списка групп студента
$stmt = $pdo->prepare("CALL getStudentGroups(?)");
$stmt->execute([$studentInfo['id']]);
$studentGroups = $stmt->fetchAll();
$stmt->closeCursor();

// Получение списка занятий студента
$stmt = $pdo->prepare("CALL getStudentClasses(?)");
$stmt->execute([$studentInfo['id']]);
$studentClasses = $stmt->fetchAll();
$stmt->closeCursor();

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Студентский кабинет</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        footer{
            position: inherit;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <header>
        <h1>Ваши группы и классы</h1>
    </header>

    <main>
        <section>
            <h2>Ваши группы</h2>
            <?php if (!empty($studentGroups)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Номер группы</th>
                            <th>Тип активности</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($studentGroups as $group) : ?>
                            <tr>
                                <td><?php echo $group['ID']; ?></td>
                                <td><?php echo $group['ActivityType']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>Вы не записаны в группы.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Ваши занятия</h2>
            <?php if (!empty($studentClasses)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Время начала</th>
                            <th>Время окончания</th>
                            <th>Кабинет</th>
                            <th>Тип занятия</th>
                            <th>Номер группы</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($studentClasses as $class) : ?>
                            <tr>
                                <td><?php echo $class['ClassDate']; ?></td>
                                <td><?php echo $class['StartTime']; ?></td>
                                <td><?php echo $class['EndTime']; ?></td>
                                <td><?php echo $class['RoomID']; ?></td>
                                <td><?php echo $class['ActivityType']; ?></td>
                                <td><?php echo $class['id']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>У вас нет занятий.</p>
            <?php endif; ?>
        </section>
        <button onclick="window.location.href='../index.php';">Вернуться на главную</button>
    </main>

    <footer>
        <p>&copy; 2023 Дом Детского Творчества</p>
    </footer>
</body>

</html>

