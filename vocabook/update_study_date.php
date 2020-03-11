<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_email = $_POST['user_email'];
    $vocabook_title = $_POST['vocabook_title'];
    $chapter_title = $_POST['chapter_title'];
    $recent_study_date = $_POST['recent_study_date'];

    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("UPDATE chapter SET recent_study_date = :recent_study_date WHERE user_email = :user_email AND vocabook_title = :vocabook_title AND chapter_title = :chapter_title");
            $stmt->bindParam(':vocabook_title', $vocabook_title);
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':chapter_title', $chapter_title);
            $stmt->bindParam(':recent_study_date', $recent_study_date);

            if ($stmt->execute()) {
                $successMSG = "chapter has updated // recentStudyDate : ". $recent_study_date . "\n";
                echo $successMSG;
            } else {
                $errMSG = "recentStudyDate update has failed";
                echo $errMSG;
            }

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());

        }
    }

}