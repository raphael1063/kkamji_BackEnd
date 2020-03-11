<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];
    $image = urlEncoder($user_email);
    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("DELETE FROM user WHERE user_email = '$user_email'");
            $stmt->bindParam(':user_email', $user_email);
            foreach (glob("./profile_images/$user_email*") as $filename) {
                echo "디렉토리에서 " . $user_email . " 삭제";
                unlink($filename);
            }
            if ($stmt->execute()) {
                $successMSG = "delete user success";

                try {
                    $stmt = $connect->prepare("DELETE FROM vocabook WHERE user_email = '$user_email'");
                    $stmt->bindParam(':user_email', $user_email);
                    foreach (glob("../vocabook/vocabook_cover_images/$image*") as $filename) {
                        echo "디렉토리에서 " . $user_email . " 삭제";
                        unlink($filename);
                    }
                    if ($stmt->execute()) {
                        $successMSG = "delete vocabook success";

                        try {
                            $stmt = $connect->prepare("DELETE FROM chapter WHERE user_email = '$user_email'");
                            $stmt->bindParam(':user_email', $user_email);
                            if ($stmt->execute()) {
                                $successMSG = "delete chapter success";

                                try {
                                    $stmt = $connect->prepare("DELETE FROM words WHERE user_email = '$user_email'");
                                    $stmt->bindParam(':user_email', $user_email);
                                    foreach (glob("../vocabook/word_images/$image*") as $filename) {
                                        echo "디렉토리에서 " . $user_email . " 삭제";
                                        unlink($filename);
                                    }
                                    if ($stmt->execute()) {
                                        $successMSG = "delete words success";
                                        echo $successMSG;
                                    } else {
                                        $errMSG = "delete words failed";
                                        echo $errMSG;
                                    }

                                } catch (PDOException $e) {
                                    die("Database error: " . $e->getMessage());

                                }

                                echo $successMSG;
                            } else {
                                $errMSG = "delete chapter failed";
                                echo $errMSG;
                            }

                        } catch (PDOException $e) {
                            die("Database error: " . $e->getMessage());

                        }

                        echo $successMSG;
                    } else {
                        $errMSG = "delete vocabook failed";
                        echo $errMSG;
                    }

                } catch (PDOException $e) {
                    die("Database error: " . $e->getMessage());

                }

                echo $successMSG;
            } else {
                $errMSG = "delete user failed";
                echo $errMSG;
            }

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());

        }
    }

}
function urlEncoder($str){
    $str = rawurlencode($str);
    return $str;
}
