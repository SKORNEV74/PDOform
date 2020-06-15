<?php
include_once("config.php");
checkLogIn(true);
clearSession();
header("Location: index.php");