<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include('../db_config.php');
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $user_nickname=$_POST['user_nickname'];


    if(!isset($errMSG))
    {
        try{

            $stmt = $connect->prepare("SELECT * FROM user WHERE user_nickname='$user_nickname'");
            $stmt->execute();
            if ($stmt->rowCount() == 0)
            {
                $successMSG = "Enable";
                echo $successMSG;
            } else {
                $errMSG = "Disable";
                echo $errMSG;
            }

        } catch(PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

}

