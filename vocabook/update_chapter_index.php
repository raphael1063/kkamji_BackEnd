<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];
    $vocabook_title = $_POST['vocabook_title'];
    $chapter_title = $_POST['chapter_title'];
    $new_chapter_num = $_POST['new_chapter_num'];

    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("UPDATE chapter SET chapter_num = :chapter_num WHERE user_email = :user_email AND vocabook_title = :vocabook_title AND chapter_title = :chapter_title");
            $stmt->bindParam(':chapter_num', $new_chapter_num);
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':vocabook_title', $vocabook_title);
            $stmt->bindParam(':chapter_title', $chapter_title);
            if ($stmt->execute()) {
                $successMSG = "index has updated // chapter_title : " . $chapter_title . " // newIndex : " . $new_chapter_num;
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