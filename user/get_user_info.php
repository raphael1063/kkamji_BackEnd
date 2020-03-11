<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];


    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("SELECT * FROM user WHERE user_email = '$user_email'");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    array_push($data,
                        array('user_name' => $row['user_name'],
                            'user_nickname' => $row['user_nickname'],
                            'user_email' => $row['user_email'],
                            'user_profile_image' => $row['user_profile_image']
                        ));
                }

                header('Content-Type: application/json; charset=utf8');
                $json = json_encode(array("webnautes" => $data), JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
                echo $json;
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

}


