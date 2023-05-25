<?php
require '../config.php';
session_start();

if (!isset($_SESSION['userid']) || $_SESSION['role'] != 2) {
    header('Location: ../index.php');
    exit();
}

// Получение информации о студентах
$stmt = $pdo->prepare("CALL getStudents()");
$stmt->execute();
$studentsInfo = $stmt->fetchAll();
$stmt->closeCursor();

// Получение информации о учителях
$stmt = $pdo->prepare("CALL getTeachers()");
$stmt->execute();
$teachersInfo = $stmt->fetchAll();
$stmt->closeCursor();

// Получение списка всех занятий
$stmt = $pdo->prepare("CALL getAllClasses()");
$stmt->execute();
$classesInfo = $stmt->fetchAll();
$stmt->closeCursor();

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Страница Директора</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        footer {
            position: inherit;
        }

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
    </style>
</head>

<body>
    <header>
        <h1>Информация о школе</h1>
    </header>

    <main>
        <section>
            <h2>Студенты</h2>
            <table>
                <thead>
                    <tr>
                        <th>Имя студента</th>
                        <th>Группы</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($studentsInfo as $student) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['StudentName']); ?></td>
                            <td><?php echo !empty($student['StudentGroups']) ? htmlspecialchars($student['StudentGroups']) : ''; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Учителя</h2>
            <table>
                <thead>
                    <tr>
                        <th>Имя учителя</th>
                        <th>Паспорт</th>
                        <th>Группы</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teachersInfo as $teacher) : ?>
                        <tr>
                            <td><?php echo $teacher['TeacherName']; ?></td>
                            <td><?php echo $teacher['Passport']; ?></td>
                            <td><?php echo $teacher['TeacherGroups']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Занятия</h2>
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
                    <?php foreach ($classesInfo as $class) : ?>
                        <tr>
                            <td><?php echo $class['ClassDate']; ?></td>
                            <td><?php echo $class['StartTime']; ?></td>
                            <td><?php echo $class['EndTime']; ?></td>
                            <td><?php echo $class['ClassroomNumber']; ?></td>
                            <td><?php echo $class['ActivityType']; ?></td>
                            <td><?php echo $class['GroupID']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <button onclick="window.location.href='../index.php';">Вернуться на главную</button>
    </main>

    <footer>
        <p>&copy; 2023 Дом Детского Творчества</p>
    </footer>
</body>

</html>