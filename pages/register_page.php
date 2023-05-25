<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #e6f0ff;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        main {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 200px;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 200px;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #3399ff;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0080ff;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #3399ff;
            font-weight: bold;
        }

        .back-link:hover {
            color: #0080ff;
        }

        footer {
            text-align: center;
            margin-top: 20px;
        }

        .passport-field {
            display: none;
        }
    </style>
</head>

<body>
    <header>
        <h1>Регистрация</h1>
    </header>

    <main>
        <form action="../register.php" method="post">
            <label for="username">Имя пользователя:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="role">Роль:</label><br>
            <select id="role" name="role" onchange="togglePassportField()">
                <option value="3">Студент</option>
                <option value="4">Учитель</option>
            </select><br>
            <div id="passportField" class="passport-field">
                <label for="passport">Паспорт:</label><br>
                <input type="text" id="passport" name="passport">
            </div>
            <input type="submit" value="Регистрация">
        </form>
        <a class="back-link" href="cabinet.php">Вернуться назад</a>
    </main>

    <footer>
        <p>&copy; 2023 Дом Детского Творчества</p>
    </footer>

    <script>
        function togglePassportField() {
            var roleSelect = document.getElementById('role');
            var passportField = document.getElementById('passportField');
            if (roleSelect.value == 4) {
                passportField.style.display = 'block';
            } else {
                passportField.style.display = 'none';
            }
        }
    </script>
</body>

</html>
