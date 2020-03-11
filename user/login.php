<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include('../db_config.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email=$_POST['user_email'];
    $pw = $_POST['pw'];

    if(!isset($errMSG)) {
        try{

            $stmt = $connect->prepare("SELECT * FROM user WHERE user_email ='$user_email' AND user_password = '$pw'");
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                $successMSG = "login success";
            } else {
                $errMSG = "login failed";
            }

        } catch(PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    } else {
        echo "error";
    }

}
if (isset($errMSG)) echo $errMSG;
if (isset($successMSG)) echo $successMSG;