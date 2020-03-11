<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];
    $vocabook_title = $_POST['vocabook_title'];
    $image_route = $_POST['image_route'];

    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("DELETE FROM vocabook WHERE user_email = '$user_email' AND vocabook_title = '$vocabook_title'");
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':vocabook_title', $vocabook_title);
            unlink("./vocabook_cover_images/" . $image_route);
            if ($stmt->execute()) {
                $successMSG = "delete vocabook success";
                echo $successMSG;
            } else {
                $errMSG = "delete vocabook failed";
                echo $errMSG;
            }

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());

        }
    }

}
