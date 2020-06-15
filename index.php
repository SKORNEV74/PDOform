<?php
include_once("config.php");

checkLogIn(false);

if(isset($_POST["submit"])) {
    field_validator("Логин", $_POST["login"], "alphanumeric");
    field_validator("Пароль", $_POST["password"], "string");
    if($messages) {
        doIndex();
        exit;
    }

    if( !($row = checkPass($_POST["login"], $_POST["password"])) ) {
        $messages[] = "Неверный логин или пароль, попробуйте снова";
    }

    if($messages) {
        doIndex();
        exit;
    }

    logIn($row["login"], $row["password"]);

    header("Location: userpage.php");
} else {
    doIndex();
}

function doIndex() {
    global $messages;
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Day 2 | Sing in</title>
</head>
<body>

<?php

//if (isset($_SESSION['nickname'])) {
//    header('Location: userpage.php');
//} else {
//    if (isset($_POST['login']) && isset($_POST['password'])) {
//        require('connect.php');
//
//        $login = $_POST['login'];
//        $password = $_POST['password'];
//
//        $query = "SELECT nickname FROM users WHERE login='$login' AND password='$password'";
//        $answer = mysqli_query($connection, $query) or die(mysqli_error($connection));
//
//        $_SESSION['nickname'] = $answer;
//    }
//}
?>

<form action="<?php print $_SERVER["PHP_SELF"]; ?>" method="post">
    <h1>Вход</h1>
    <?php
        if($messages) { displayErrors($messages); }
    ?>
    <p>
        <label for="login">Логин:</label>
        <input type="text" name="login" required value="<?php print isset($_POST['submit']) ? htmlspecialchars($_POST['login']) : "" ; ?>">
    </p>
    <p>
        <label for="password">Пароль:</label>
        <input type="password" name="password" required>
    </p>
    <p>
        <input name="submit" type="submit" value="Войти">
        <a href="registration.php">Регистрация</a>
    </p>
</form>

</body>
</html>
<?php } ?>