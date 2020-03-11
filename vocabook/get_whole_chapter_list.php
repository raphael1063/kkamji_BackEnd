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
            $stmt = $connect->prepare("SELECT * FROM chapter WHERE user_email = '$user_email'");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    array_push($data,
                        array(
                            'vocabook_title' => $row['vocabook_title'],
                            'chapter_title' => $row['chapter_title'],
                            'recent_study_date' => $row['recent_study_date']
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


