<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];
    $vocabook_title = $_POST['vocabook_title'];

    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("SELECT * FROM words WHERE user_email = '$user_email' AND vocabook_title = '$vocabook_title'");
            $stmt->execute();
            $num_of_words = $stmt->rowCount();
            echo $num_of_words;
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

}