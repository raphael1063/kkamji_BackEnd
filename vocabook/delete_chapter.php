<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];
    $vocabook_title = $_POST['vocabook_title'];
    $chapter_num = $_POST['chapter_num'];
    $chapter_title = $_POST['chapter_title'];

    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("DELETE FROM chapter WHERE user_email = '$user_email' AND vocabook_title = '$vocabook_title' AND chapter_num = '$chapter_num' AND chapter_title = '$chapter_title'");
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':vocabook_title', $vocabook_title);
            $stmt->bindParam(':chapter_num', $chapter_num);
            $stmt->bindParam(':chapter_title', $chapter_title);

            if ($stmt->execute()) {
                $image = urlEncoder($user_email."_".$vocabook_title."_".$chapter_title);
                foreach (glob("./word_images/$image*") as $filename) {
                    echo "디렉토리에서 " . $image . " 삭제";
                    unlink($filename);
                }
                echo $image."\n";
                $stmt2 = $connect->prepare("DELETE FROM words WHERE user_email = '$user_email' AND vocabook_title = '$vocabook_title' AND chapter_title = '$chapter_title'");
                $stmt2->bindParam(':user_email', $user_email);
                $stmt2->bindParam(':vocabook_title', $vocabook_title);
                $stmt2->bindParam(':chapter_num', $chapter_num);
                $stmt2->bindParam(':chapter_title', $chapter_title);
                if ($stmt2->execute()) {
                    $successMSG = "delete words success\n";
                    echo $successMSG;
                } else {
                    $errMSG = "delete words failed\n";
                    echo $errMSG;
                }
                $successMSG = "delete chapter success\n";
                echo $successMSG;
            } else {
                $errMSG = "delete chapter failed\n";
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