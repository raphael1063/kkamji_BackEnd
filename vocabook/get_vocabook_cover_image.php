<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];
    $vocabook_title = $_POST['vocabook_title'];



    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("SELECT * FROM vocabook WHERE user_email = '$user_email' AND vocabook_title = '$vocabook_title'");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    array_push($data,
                        array(
                            'vocabook_cover_image' => $row['vocabook_cover_image']
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


