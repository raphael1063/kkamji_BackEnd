<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("UPDATE user SET user_password = :user_password WHERE user_email = :user_email");
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':user_password', $user_password);

            if ($stmt->execute()) {
                $successMSG = "user_password has updated";
                echo $successMSG;
            } else {
                $errMSG = "user_password update has failed";
                echo $errMSG;
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
}