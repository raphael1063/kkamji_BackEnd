<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_name = $_POST['user_name'];
    $user_nickname = $_POST['user_nickname'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $marketing = $_POST['marketing'];
    $user_profile_image = $_POST['user_profile_image'];
    $update_date = date("Y-m-d");

    if($user_profile_image==null){
        $user_profile_image = "http://13.124.111.245/android/user/user_profile_images/profile.png";
    }else{
        $path = "http://13.124.111.245/android/user/profile_images/";
        $user_profile_image = $path.$user_profile_image;
    }

    if (!isset($errMSG)) // 회원정보가 모두 입력이 되었다면
    {
        try {
            // SQL문을 실행하여 데이터를 MySQL 서버의 user 테이블에 저장합니다.
            $stmt = $connect->prepare('INSERT INTO user(user_name, user_nickname, user_email, user_password, marketing, user_profile_image, update_date) 
VALUES(:user_name, :user_nickname, :user_email, :user_password, :marketing, :user_profile_image, :update_date)');
            $stmt->bindParam(':user_name', $user_name);
            $stmt->bindParam(':user_nickname', $user_nickname);
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':user_password', $user_password);
            $stmt->bindParam(':marketing', $marketing);
            $stmt->bindParam(':user_profile_image', $user_profile_image);
            $stmt->bindParam(':update_date', $update_date);
            if ($stmt->execute()) {
                $successMSG = "register success";
                echo $successMSG;
            } else {
                $errMSG = "register failed";
                echo $errMSG;
            }

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());

        }
    }

} else {
    echo "deny";
}

?>


<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


?>