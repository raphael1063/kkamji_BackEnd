<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];
    $vocabook_title = $_POST['vocabook_title'];
    $vocabook_num = $_POST['vocabook_num'];
    $vocabook_cover_image = $_POST['vocabook_cover_image'];



    if($vocabook_cover_image == "none"){
        $vocabook_cover_image = "default_cover_image";
    }else{
        $path = "http://13.124.111.245/android/vocabook/vocabook_cover_images/";
        $vocabook_cover_image = $path.$vocabook_cover_image;
    }

    if (!isset($errMSG)) // 회원정보가 모두 입력이 되었다면
    {
        try {
            $stmt = $connect->prepare('INSERT INTO vocabook(user_email, vocabook_num, vocabook_title, vocabook_cover_image) 
VALUES(:user_email, :vocabook_num, :vocabook_title, :vocabook_cover_image)');
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':vocabook_num', $vocabook_num);
            $stmt->bindParam(':vocabook_title', $vocabook_title);
            $stmt->bindParam(':vocabook_cover_image', $vocabook_cover_image);
            if ($stmt->execute()) {
                $successMSG = "vocabook save success";
                echo $successMSG;
            } else {
                $errMSG = "vocabook save failed";
                echo $errMSG;
            }

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());

        }
    }

} else {
    echo "deny";
}