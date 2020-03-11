<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];
    $vocabook_title = $_POST['vocabook_title'];
    $chapter_num = $_POST['chapter_num'];
    $chapter_title = $_POST['chapter_title'];
    if(isset($_POST['recent_study_date'])){
        $recent_study_date = $_POST['recent_study_date'];
    }



    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare('INSERT INTO chapter(user_email, vocabook_title, chapter_num, chapter_title, recent_study_date) 
                                                VALUES(:user_email, :vocabook_title, :chapter_num, :chapter_title, :recent_study_date)');
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':vocabook_title', $vocabook_title);
            $stmt->bindParam(':chapter_num', $chapter_num);
            $stmt->bindParam(':chapter_title', $chapter_title);
            $stmt->bindParam(':recent_study_date', $recent_study_date);
            if ($stmt->execute()) {
                $successMSG = "chapter save success";
                echo $successMSG;
            } else {
                $errMSG = "chapter save failed";
                echo $errMSG;
            }

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());

        }
    }

} else {
    echo "deny";
}