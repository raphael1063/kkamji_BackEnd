<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_email = $_POST['user_email'];
    $vocabook_title = $_POST['vocabook_title'];
    $chapter_num = $_POST['chapter_num'];
    $chapter_title = $_POST['chapter_title'];

    if (!isset($errMSG)){
        try {
            $stmt = $connect->prepare("DELETE FROM words WHERE user_email = :user_email AND vocabook_title = :vocabook_title AND chapter_title = :chapter_title");
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':vocabook_title', $vocabook_title);
            $stmt->bindParam(':chapter_title', $chapter_title);
            if ($stmt->execute()) {
                $successMSG = "chapter contents deleted";
                echo $successMSG;
            } else {
                $errMSG = "chapter contents delete failed";
                echo $errMSG;
            }

            $stmt2 = $connect->prepare("UPDATE chapter SET chapter_title = :chapter_title WHERE user_email = :user_email AND vocabook_title = :vocabook_title AND chapter_num = :chapter_num");
            $stmt2->bindParam(':vocabook_title', $vocabook_title);
            $stmt2->bindParam(':user_email', $user_email);
            $stmt2->bindParam(':chapter_num', $chapter_num);
            $stmt2->bindParam(':chapter_title', $chapter_title);
            if ($stmt2->execute()) {
                $successMSG = "chapter title has updated";
                echo $successMSG;
            } else {
                $errMSG = "chapter title update has failed";
                echo $errMSG;
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());

        }
    }

}