<?php
function connection() {
//    $dbname = "day2";
//    global $link;
//    $link = mysqli_connect("localhost", "root", "") or die("Нет соединения с MySQL");
//    mysqli_select_db($link, $dbname) or die("Не открывается БД: $dbname. Ошибка: " . mysqli_error($link));
    try {
        global $host, $dbname, $dbuser, $dbpass, $DBH;
        $DBH = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
        $DBH -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch (PDOException $e) {
        echo "Хьюстон, у нас проблемы. ";
        echo $e -> getMessage();
    }
}

function checkLogIn($status) {
    if ($status) {
        if (!isset($_SESSION["logIn"])) {
            header("Location: index.php");
            exit;
        }
    } else {
        if (isset($_SESSION["logIn"]) && $_SESSION["logIn"] === true) {
            header("Location: userpage.php");
        }
    }
    return true;
}

function field_validator($field_descr, $field_data, $field_type) {

    global $messages;

    $field_data = htmlspecialchars($field_data);

    $data_types = array(
        "alphanumeric" => "/^[a-zA-Z0-9]+$/",
        "string" => "/^[\w]+$/"
    );

    if ($field_type == "string") {
        $field_ok = true;
    } else {
        $field_ok = preg_match($data_types[$field_type], $field_data);
    }

    if (!$field_ok) {
        $messages[] = "Пожалуйста введите нормальный $field_descr.";
        return;
    }
}

function checkPass($login, $password) {
//    global $link;
//
//    $query = "SELECT login, password FROM users WHERE login='$login' and password='$password'";
//    $result = mysqli_query($link, $query) or die("checkPassword фатальная ошибка: " . mysqli_error($link));
//
//    if (mysqli_num_rows($result) == 1) {
//        $row = mysqli_fetch_array($result);
//        return $row;
//    }
//    return false;
    global $DBH;

    $data = array($login, $password);

    $STH = $DBH -> prepare("SELECT login, password FROM users WHERE login=? and password=?");
    $STH -> execute($data);

    $STH->setFetchMode(PDO::FETCH_ASSOC);

    if (($STH -> rowCount()) == 1) {
        $row = $STH -> fetch();
        return $row;
    }

    return false;
}

function logIn($login, $password) {
    $_SESSION["login"] = $login;
    $_SESSION["password"] = $password;
    $_SESSION["logIn"] = true;
}

function displayErrors($messages) {
    print("<b>Возникли следующие ошибки:</b>\n<ol>\n");

    foreach($messages as $msg){
        print("<li>$msg</li>\n");
    }
    print("</ol>\n");
}

function newUser($login, $password) {
//    global $link;
//
//    $query = "INSERT INTO users (login, password) VALUES ('$login', '$password')";
//    $result = mysqli_query($link, $query) or die("Данные не загружены в БД. Ошибка: " . mysqli_error($link));
//
//    return true;
    global $DBH;

    $data = array($login, $password);

    $STH = $DBH -> prepare("INSERT INTO users (login, password) VALUES (?, ?)");
    $STH -> execute($data);

    return true;
}

function clearSession() {
    session_unset();
    session_destroy();
    return true;
}