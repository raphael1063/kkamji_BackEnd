<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_nickname = $_POST['user_nickname'];


    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("SELECT * FROM user WHERE user_nickname = '$user_nickname'");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    array_push($data,
                        array(
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


