<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_email = $_POST['user_email'];

    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("UPDATE user SET user_profile_image = :user_profile_image WHERE user_email = :user_email");
            $stmt->bindParam(':user_email', $user_email);
            foreach (glob("./profile_images/$user_email*") as $filename) {
                echo "디렉토리에서 " . $user_email . " 삭제";
                unlink($filename);
            }
            if ($stmt->execute()) {
                $successMSG = "user_profile_image has updated";
                echo $successMSG;
            } else {
                $errMSG = "user_profile_image update has failed";
                echo $errMSG;
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

}