<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_email = $_POST['user_email'];
    $user_name = $_POST['user_name'];

    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("UPDATE user SET user_name = :user_name WHERE user_email = :user_email");
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':user_name', $user_name);

            if ($stmt->execute()) {
                $successMSG = "user_name has updated";
                echo $successMSG;
            } else {
                $errMSG = "user_name update has failed";
                echo $errMSG;
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
}