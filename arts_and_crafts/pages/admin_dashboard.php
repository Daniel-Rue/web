<?php
require '../config.php';
session_start();

if (!isset($_SESSION['userid']) || $_SESSION['role'] != 1) {
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

// Получение всех номеров кабинетов
$stmt = $pdo->prepare("CALL getAllClassrooms()");
$stmt->execute();
$classrooms = $stmt->fetchAll();
$stmt->closeCursor();

// Получение информации о всех группах
$stmt = $pdo->prepare("CALL getAllGroups()");
$stmt->execute();
$groups = $stmt->fetchAll();
$stmt->closeCursor();

// Получение информации об активностях
$stmt = $pdo->prepare("SELECT * FROM activities");
$stmt->execute();
$activityInfo = $stmt->fetchAll();
$stmt->closeCursor();

?>



<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Страница Администратора</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9f1f6;
            color: #333;
        }

        header {
            background-color: #2980b9;
            text-align: center;
            padding: 20px;
        }

        h1 {
            color: #fff;
            margin: 0;
        }

        main {
            padding: 20px;
            margin-bottom: 70px;
            /* Добавляем отступ снизу для футера */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            /* Добавляем отступ снизу */
        }

        th,
        td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ecf0f1;
        }

        section {
            margin-bottom: 30px;
        }

        h2 {
            color: #2980b9;
            margin-top: 0;
        }

        form label {
            color: #333;
            display: block;
            margin-bottom: 10px;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"],
        form input[type="date"],
        form input[type="time"],
        form select {
            padding: 5px;
            border-radius: 5px;
            border: none;
            width: 100%;
            margin-bottom: 10px;
            background-color: #fff;
            color: #333;
        }

        form select option {
            background-color: #ecf0f1;
        }

        form input[type="submit"],
        form button {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: #2980b9;
            color: #fff;
            cursor: pointer;
        }

        form input[type="submit"]:hover,
        form button:hover {
            background-color: #2471a3;
        }

        form table {
            width: 100%;
            border-collapse: collapse;
        }

        form th,
        form td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        form th {
            background-color: #ecf0f1;
        }

        button {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: #2980b9;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #2471a3;
        }

        footer {
            background-color: #2980b9;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <header>
        <h1>Информация о школе</h1>
    </header>

    <main>


        <form action="../deleteStudentFromGroup.php" method="post">
            <section>
                <h2>Ученики</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Выбрать</th>
                            <th>Имя студента</th>
                            <th>Группы</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($studentsInfo as $student) : ?>
                            <tr>
                                <td><input type="checkbox" name="selectedStudents[]" value="<?php echo $student['id']; ?>"></td>
                                <td><?php echo htmlspecialchars($student['StudentName']); ?></td>
                                <td>
                                    <?php
                                    if ($student['StudentGroups'] != null) {
                                        echo htmlspecialchars($student['StudentGroups']);
                                    } else {
                                        echo "";  // выводим пустую строку, если StudentGroups равно null
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
                <input type="submit" value="Удалить группы выбранных учеников"> <!-- Кнопка для удаления -->
            </section>
        </form>
        <section>
            <h2>Добавить ученика в группу</h2>
            <form action="../addStudentToGroup.php" method="post">
                <label for="student_id">Студент:</label>
                <select id="student_id" name="student_id" required>
                    <?php foreach ($studentsInfo as $student) : ?>
                        <option value="<?php echo $student['id']; ?>">
                            <?php echo $student['StudentName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="group_id">Группа:</label>
                <select id="group_id" name="group_id" required>
                    <?php foreach ($groups as $group) : ?>
                        <option value="<?php echo $group['GroupID']; ?>">
                            <?php echo $group['ActivityType'] . ' (' . $group['GroupID'] . ')'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Добавить">
            </form>
        </section>
        <section>
            <h2>Учителя</h2>

            <form action="../deleteTeacherFromGroup.php" method="post">
                <table>
                    <thead>
                        <tr>
                            <th>Выбрать</th>
                            <th>Имя учителя</th>
                            <th>Паспорт</th>
                            <th>Группы</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teachersInfo as $teacher) : ?>
                            <tr>
                                <td><input type="checkbox" name="selectedTeachers[]" value="<?php echo $teacher['id']; ?>"></td>
                                <td><?php echo htmlspecialchars($teacher['TeacherName']); ?></td>
                                <td><?php echo htmlspecialchars($teacher['Passport']); ?></td>
                                <td>
                                    <?php
                                    if ($teacher['TeacherGroups'] != null) {
                                        echo htmlspecialchars($teacher['TeacherGroups']);
                                    } else {
                                        echo "";  // выводим пустую строку, если TeacherGroups равно null
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <input type="submit" value="Удалить группы выбранных учителей"> <!-- Кнопка для удаления -->
            </form>
        </section>

        <section>
            <h2>Добавить учителя в группу</h2>
            <form action="../addTeacherToGroup.php" method="post">
                <label for="teacher_id">Учитель:</label>
                <select id="teacher_id" name="teacher_id" required>
                    <?php foreach ($teachersInfo as $teacher) : ?>
                        <option value="<?php echo $teacher['id']; ?>">
                            <?php echo $teacher['TeacherName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="group_id">Группа:</label>
                <select id="group_id" name="group_id" required>
                    <?php foreach ($groups as $group) : ?>
                        <option value="<?php echo $group['GroupID']; ?>">
                            <?php echo $group['ActivityType'] . ' (' . $group['GroupID'] . ')'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Добавить">
            </form>
        </section>


        <section>
            <h2>Добавить занятие</h2>
            <form action="../addClass.php" method="post">
                <label for="class_date">Дата:</label>
                <input type="date" id="class_date" name="class_date" required>

                <label for="start_time">Время начала:</label>
                <input type="time" id="start_time" name="start_time" required>

                <label for="end_time">Время окончания:</label>
                <input type="time" id="end_time" name="end_time" required>

                <label for="classroom">Кабинет:</label>
                <select id="classroom" name="classroom">
                    <?php foreach ($classrooms as $classroom) : ?>
                        <option value="<?php echo $classroom['id']; ?>">
                            <?php echo $classroom['ClassroomNumber']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="group">Группа:</label>
                <select id="group" name="group">
                    <?php foreach ($groups as $group) : ?>
                        <option value="<?php echo $group['GroupID']; ?>">
                            <?php echo $group['GroupID']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Добавить">
            </form>
        </section>
        <section>
            <h2>Занятия</h2>
            <form action="../deleteClass.php" method="post"> <!-- Начало формы -->
                <table>
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Время начала</th>
                            <th>Время окончания</th>
                            <th>Кабинет</th>
                            <th>Тип занятия</th>
                            <th>Номер группы</th>
                            <th></th> <!-- Заголовок для столбца чекбоксов -->
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
                                <td>
                                    <input type="checkbox" name="selectedClasses[]" value="<?php echo $class['id']; ?>"> <!-- Чекбокс -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <input type="submit" value="Удалить выбранное"> <!-- Кнопка для удаления -->
            </form> <!-- Конец формы -->
        </section>

        <section>
            <h2>Добавить группу</h2>
            <form action="../addGroup.php" method="post">

                <label for="activity_id">Тип активности:</label>
                <select id="activity_id" name="activity_id" required>
                    <?php foreach ($activityInfo as $activity) : ?>
                        <option value="<?php echo $activity['id']; ?>"><?php echo $activity['ActivityType']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="teacher_id">Учитель:</label>
                <select id="teacher_id" name="teacher_id" required>
                    <?php foreach ($teachersInfo as $teacher) : ?>
                        <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['TeacherName']; ?></option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Добавить">
            </form>
        </section>


        <section>
            <h2>Группы</h2>
            <form action="../deleteGroup.php" method="post">
                <table>
                    <thead>
                        <tr>
                            <th>Выбрать</th>
                            <th>Номер группы</th>
                            <th>Тип активности</th>
                            <th>Учитель</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groups as $group) : ?>
                            <tr>
                                <td><input type="checkbox" name="selectedGroups[]" value="<?php echo $group['GroupID']; ?>"></td>
                                <td><?php echo $group['GroupID']; ?></td>
                                <td><?php echo $group['ActivityType']; ?></td>
                                <td><?php echo $group['TeacherName']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <input type="submit" value="Удалить выбранное">
            </form>
        </section>


        <button onclick="window.location.href='../index.php';">Вернуться на главную</button>
    </main>

    <footer>
        <p>&copy; 2023 Дом Детского Творчества</p>
    </footer>
</body>

</html>
