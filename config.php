<?php
session_start();

error_reporting(E_ALL);

include_once("functions.php");

$messages = array();

$host = "localhost";
$dbname = "day2";
$dbuser = "root";
$dbpass = "";

connection();