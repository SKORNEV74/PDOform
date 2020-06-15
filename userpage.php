<?php
include_once("config.php");
checkLogIn(true);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Day 2 | User page</title>
</head>
<body>

<h1>Привет, <?php echo htmlspecialchars($_SESSION["login"]) ?>!</h1>

<p>Ваш пароль: <?php echo htmlspecialchars($_SESSION["password"]) ?></p>

<a href="logout.php">Выйти</a>

</body>
</html>