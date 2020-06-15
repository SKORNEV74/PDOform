<?php
include_once("config.php");

checkLogIn(false);

if (isset($_POST["submit"])) {
    field_validator("Логин", $_POST["login"], "alphanumeric");
    field_validator("Пароль", $_POST["password"], "string");
    field_validator("Подтверждение пароля", $_POST["password2"], "string");

    if (strcmp($_POST["password"], $_POST["password2"])) {
        $messages[] = "Ваши пароли не совпадают";
    }

//    $query = "SELECT login FROM users WHERE login='" . $_POST["login"] . "'";
//    global $link;
//
//    $result = mysqli_query($link, $query) or die("MySQL запрос $query невыполнен. Ошибка: " . mysqli_error($link));
//
//    if ($row = mysqli_fetch_array($result)){
//        $messages[] = "Логин \"" . $_POST["login"] . "\" уже занят, попробуйте другой.";
//    }
    global $DBH;

    $login = $_POST["login"];

    $STH = $DBH -> prepare("SELECT login FROM users WHERE login=?");
    $STH -> bindParam(1, $login);
    $STH -> execute();

    if ($STH -> fetch()){
        $messages[] = "Логин \"$login\" уже занят, попробуйте другой.";
    }

    if (empty($messages)) {
        newUser($_POST["login"], $_POST["password"]);

        logIn($_POST["login"], $_POST["password"]);

        header("Location: userpage.php");
    }
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Day 2 | Sing up</title>
</head>
<body>

<?php

//if (isset($_SESSION['nickname'])) {
//    header('Location: userpage.php');
//} else {
//    if (isset($_POST['nickname']) && isset($_POST['login']) && isset($_POST['password'])) {
//        require('connect.php');
//
//        $nickname = $_POST['nickname'];
//        $login = $_POST['login'];
//        $password = $_POST['password'];
//
//        $_SESSION['nickname'] = $nickname;
//
//        $query = "INSERT INTO users (nickname, login, password) VALUES ('$nickname', '$login', '$password')";
//        $answer = mysqli_query($connection, $query) or die(mysqli_error($connection));
//
//        if ($answer) {
//            $msg = '<div class="luck">Все хорошо!</div>';
//        } else {
//            $msg = '<div class="fail">Все плохо!</div>';
//        }
//    }
//}
?>

<form action="<?php print $_SERVER["PHP_SELF"]; ?>" method="post">
    <h1>Регистрация</h1>
    <?php
        if($messages) { displayErrors($messages); }
    ?>
    <p>
        <label for="login">Логин:</label>
        <input type="text" name="login" required value="<?php print isset($_POST['submit']) ? htmlspecialchars($login) : "" ; ?>">
    </p>
    <p>
        <label for="password">Пароль:</label>
        <input type="password" name="password" required>
    </p>
    <p>
        <label for="password2">Подтвердите пароль:</label>
        <input type="password" name="password2" required>
    </p>
    <p>
        <input name="submit" type="submit" value="Зарегистрироваться">
        <a href="index.php">Авторизация</a>
    </p>
</form>

</body>
</html>