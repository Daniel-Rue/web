<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Дом Детского Творчества - Личный кабинет</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Дом Детского Творчества</h1>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Главная</a></li>
            <li><a href="contacts.php">Контакты</a></li>
            <li><a href="cabinet.php">Личный кабинет</a></li>
        </ul>
    </nav>

    <main>
        <section id="content">
            <div id="loginForm">
                <form action="../login.php" method="post">
                    <label for="username">Имя пользователя:</label>
                    <input type="text" id="username" name="username">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="password">
                    <input type="submit" value="Войти">
                </form>
                <?php
                session_start();
                if (isset($_SESSION['login_error']) && $_SESSION['login_error']) {
                    echo '<p class="error">Неверные данные</p>';
                    unset($_SESSION['login_error']);
                }
                ?>
                <p>или <a href="register_page.php">Регистрация</a></p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Дом Детского Творчества</p>
    </footer>
</body>
</html>
