<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];
    $vocabook_title = $_POST['vocabook_title'];
    $new_vocabook_num = $_POST['new_vocabook_num'];

    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("UPDATE vocabook SET vocabook_num = :vocabook_num WHERE user_email = :user_email AND vocabook_title = :vocabook_title");
            $stmt->bindParam(':vocabook_num', $new_vocabook_num);
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':vocabook_title', $vocabook_title);
            if ($stmt->execute()) {
                $successMSG = "index has updated // vocabookTitle : " . $vocabook_title . " // newIndex : " . $new_vocabook_num;
                echo $successMSG;
            } else {
                $errMSG = "index update has failed";
                echo $errMSG;
            }

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());

        }
    }

}