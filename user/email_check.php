<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include('../db_config.php');
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $user_email=$_POST['user_email'];


    if(!isset($errMSG))
    {
        try{

            $stmt = $connect->prepare("SELECT * FROM user WHERE user_email='$user_email'");
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

