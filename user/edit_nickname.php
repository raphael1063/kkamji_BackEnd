<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_email = $_POST['user_email'];
    $user_nickname = $_POST['user_nickname'];

    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("UPDATE user SET user_nickname = :user_nickname WHERE user_email = :user_email");
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':user_nickname', $user_nickname);

            if ($stmt->execute()) {
                $successMSG = "user_nickname has updated";
                echo $successMSG;
            } else {
                $errMSG = "user_nickname update has failed";
                echo $errMSG;
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
}