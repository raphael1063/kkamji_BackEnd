<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];
    $vocabook_title = $_POST['vocabook_title'];
    $chapter_title = $_POST['chapter_title'];
    $word = $_POST['word'];

    if (!isset($errMSG))
    {
        try {
            $stmt = $connect->prepare("DELETE FROM words WHERE user_email = '$user_email' AND vocabook_title = '$vocabook_title' AND chapter_title = '$chapter_title' AND word = '$word'");
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':vocabook_title', $vocabook_title);
            $stmt->bindParam(':chapter_title', $chapter_title);
            $stmt->bindParam(':word', $word);

            if ($stmt->execute()) {
//                $image = urlEncoder($user_email."_".$vocabook_title."_".$chapter_title."_".$word);
//                   if(file_exists("./word_images/$image")){
//                       unlink("./word_images/$image");
//                       echo "디렉토리에서 " . $image . " 삭제\n";
//                   } else {
//                       echo "그런 파일 없음 ./word_images/$image\n";
//                   }
                $image = urlEncoder($user_email."_".$vocabook_title."_".$chapter_title."_".$word);
                foreach (glob("./word_images/$image.*") as $filename) {
                    echo "디렉토리에서 " . $image . " 삭제";
                    unlink($filename);
                }

                $successMSG = "delete word success\n";
                echo $successMSG;
            } else {
                $errMSG = "delete word failed\n";
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