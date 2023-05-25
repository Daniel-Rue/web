<?php
ini_set('display_errors', '0');
error_reporting(0);
require '../config.php';
session_start();

if (!isset($_SESSION['userid']) || $_SESSION['role'] != 4) { // Предполагается, что роль учителя = 2
    header('Location: ../index.php');
    exit();
}

// Получение информации о учителе
$stmt = $pdo->prepare("CALL GetTeacherInfo(?)");
$stmt->execute([$_SESSION['userid']]);
$teacherInfo = $stmt->fetch();
$stmt->closeCursor();

// Получение списка групп учителя
$stmt = $pdo->prepare("CALL GetTeacherGroups(?)");
$stmt->execute([$teacherInfo['id']]);
$teacherGroups = $stmt->fetchAll();
$stmt->closeCursor();

// Получение списка занятий учителя
$stmt = $pdo->prepare("CALL GetTeacherClasses(?)");
$stmt->execute([$teacherInfo['id']]);
$teacherClasses = $stmt->fetchAll();
$stmt->closeCursor();

// Получение списка учеников для каждой группы учителя
$teacherStudents = [];
foreach ($teacherGroups as $group) {
    $stmt = $pdo->prepare("CALL GetStudentsInGroup(?)");
    $stmt->execute([$group['GroupID']]);
    $studentsInGroup = $stmt->fetchAll();
    $stmt->closeCursor();
    $teacherStudents[$group['GroupID']] = $studentsInGroup;
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Кабинет учителя</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .students-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .students-list li {
            display: inline-block;
            margin-right: 10px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
            <?php if (!empty($teacherGroups)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Номер группы</th>
                            <th>Тип активности</th>
                            <th>Студенты</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teacherGroups as $group) : ?>
                            <tr>
                                <td><?php echo $group['GroupID']; ?></td>
                                <td><?php echo $group['ActivityType']; ?></td>
                                <td>
                                    <?php if (isset($teacherStudents[$group['GroupID']]) && !empty($teacherStudents[$group['GroupID']])) : ?>
                                        <ul class="students-list">
                                            <?php foreach ($teacherStudents[$group['GroupID']] as $student) : ?>
                                                <li><?php echo $student['StudentName']; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else : ?>
                                        <p>Нет студентов в группе</p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>У вас нет групп.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Ваши занятия</h2>
            <?php if (!empty($teacherClasses)) : ?>
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
                        <?php foreach ($teacherClasses as $class) : ?>
                            <tr>
                                <td><?php echo $class['ClassDate']; ?></td>
                                <td><?php echo $class['StartTime']; ?></td>
                                <td><?php echo $class['EndTime']; ?></td>
                                <td><?php echo $class['RoomID']; ?></td>
                                <td><?php echo $class['ActivityType']; ?></td>
                                <td><?php echo $class['GroupID']; ?></td>
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
