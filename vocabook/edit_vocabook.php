<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];
    $vocabook_num = $_POST['vocabook_num'];
    $vocabook_title_original = $_POST['vocabook_title_original'];
    $vocabook_title = $_POST['vocabook_title'];
    $original_image_route = $_POST['original_image_route'];
    $new_vocabook_cover_image = $_POST['new_vocabook_cover_image'];
    $change = true;

    if ($new_vocabook_cover_image == "none") {
        echo $vocabook_title . "// 이미지 제거";
        $vocabook_cover_image = "default_cover_image";
    } else if($new_vocabook_cover_image == "no change"){
        echo $vocabook_title . "// 이미지변화 없음";
        $change =false;
    } else  {
        $path = "http://13.124.111.245/android/vocabook/vocabook_cover_images/";
        $vocabook_cover_image = $path . $new_vocabook_cover_image;
    }

    if (!isset($errMSG)) {
        try {
            $stmt = $connect->prepare("UPDATE vocabook SET vocabook_title = :vocabook_title WHERE user_email = :user_email AND vocabook_title = :vocabook_title_original");
            $stmt->bindParam(':vocabook_title', $vocabook_title);
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':vocabook_title_original', $vocabook_title_original);

            if (file_exists("./vocabook_cover_images/" . $original_image_route)) {
                unlink("./vocabook_cover_images/" . $original_image_route);
                echo $original_image_route . "디렉토리에서 삭제됨\n";
            }
            if ($stmt->execute()) {
                $successMSG = "vocabook has updated // vocabookTitle : " . $vocabook_title . "\n";
                echo $successMSG;
                try {
                    $stmt = $connect->prepare("UPDATE chapter SET vocabook_title = :vocabook_title WHERE user_email = :user_email AND vocabook_title = :vocabook_title_original");
                    $stmt->bindParam(':vocabook_title', $vocabook_title);
                    $stmt->bindParam(':vocabook_title_original', $vocabook_title_original);
                    $stmt->bindParam(':user_email', $user_email);
                    if ($stmt->execute()) {
                        $successMSG = "chapter has updated // original title" . $vocabook_title_original . " to " . $vocabook_title . "\n";
                        echo $successMSG;

                        try {
                            $stmt = $connect->prepare("UPDATE words SET vocabook_title = :vocabook_title WHERE user_email = :user_email AND vocabook_title = :vocabook_title_original");
                            $stmt->bindParam(':vocabook_title', $vocabook_title);
                            $stmt->bindParam(':vocabook_title_original', $vocabook_title_original);
                            $stmt->bindParam(':user_email', $user_email);
                            if ($stmt->execute()) {
                                $successMSG = "words has updated // original title" . $vocabook_title_original . " to " . $vocabook_title . "\n";
                                echo $successMSG;
                                if($change == true){
                                    try {
                                        $stmt = $connect->prepare("UPDATE vocabook SET vocabook_cover_image = :vocabook_cover_image WHERE user_email = :user_email AND vocabook_title = :vocabook_title_original");
                                        $stmt->bindParam(':vocabook_cover_image', $vocabook_cover_image);
                                        $stmt->bindParam(':vocabook_title_original', $vocabook_title_original);
                                        $stmt->bindParam(':user_email', $user_email);
                                        if ($stmt->execute()) {
                                            $successMSG = "vocabook_cover_image updated // vocabook_cover_image : " . $vocabook_cover_image . "\n";

                                            echo $successMSG;
                                        } else {
                                            $errMSG = "vocabook_cover_image update has failed";
                                            echo $errMSG;
                                        }

                                    } catch (PDOException $e) {
                                        die("Database error: " . $e->getMessage());

                                    }
                                }


                            } else {
                                $errMSG = "words update has failed";
                                echo $errMSG;
                            }

                        } catch (PDOException $e) {
                            die("Database error: " . $e->getMessage());

                        }

                    } else {
                        $errMSG = "chapter update has failed";
                        echo $errMSG;
                    }

                } catch (PDOException $e) {
                    die("Database error: " . $e->getMessage());

                }


            } else {
                $errMSG = "vocabook update has failed";
                echo $errMSG;
            }

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());

        }
    }


}