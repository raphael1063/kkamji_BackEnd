<?php


$host = '13.124.111.245';
$username = 'admin'; # MySQL 계정 아이디
$password = '13th.Usshortterm'; # MySQL 계정 패스워드
$dbname = 'app_data';  # DATABASE 이름


$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try {

    $connect = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password);
} catch (PDOException $e) {

    die("Failed to connect to the database: " . $e->getMessage());
}


$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
    function undo_magic_quotes_gpc(&$array)
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                undo_magic_quotes_gpc($value);
            } else {
                $value = stripslashes($value);
            }
        }
    }

    undo_magic_quotes_gpc($_POST);
    undo_magic_quotes_gpc($_GET);
    undo_magic_quotes_gpc($_COOKIE);
}

header('Content-Type: text/html; charset=utf-8');