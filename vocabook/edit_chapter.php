<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['user_email'];
    $vocabook_title = $_POST['vocabook_title'];
    $chapter_title = $_POST['chapter_title'];
    $word = $_POST['word'];
    if (isset($_POST['meaning1'])) {
        $meaning1 = $_POST['meaning1'];
    }
    if (isset($_POST['meaning2'])) {
        $meaning2 = $_POST['meaning2'];
    }
    if (isset($_POST['meaning3'])) {
        $meaning3 = $_POST['meaning3'];
    }
    if (isset($_POST['meaning4'])) {
        $meaning4 = $_POST['meaning4'];
    }
    if (isset($_POST['meaning5'])) {
        $meaning5 = $_POST['meaning5'];
    }
    $word_image_file_name = null;
    if (isset($_POST['word_image_file_name'])) {
        $word_image_file_name = $_POST['word_image_file_name'];
        echo "기존 이미지 파일명 : " . $word_image_file_name . "\n";
    }

    if (isset($_POST['new_word_image_uri'])) {
        $word_image_uri = $_POST['new_word_image_uri'];
        echo "클라이언트로 받은 이미지 URI : " . $word_image_uri . "\n";
    }


    if (!isset($errMSG)) {
        try {
            $stmt = $connect->prepare('INSERT INTO words(user_email, vocabook_title, chapter_title, word, meaning1, meaning2, meaning3, meaning4, meaning5, word_image_uri) 
                                                VALUES(:user_email, :vocabook_title, :chapter_title, :word, :meaning1, :meaning2, :meaning3, :meaning4, :meaning5, :word_image_uri)');
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':vocabook_title', $vocabook_title);
            $stmt->bindParam(':chapter_title', $chapter_title);
            $stmt->bindParam(':word', $word);
            $stmt->bindParam(':meaning1', $meaning1);
            $stmt->bindParam(':meaning2', $meaning2);
            $stmt->bindParam(':meaning3', $meaning3);
            $stmt->bindParam(':meaning4', $meaning4);
            $stmt->bindParam(':meaning5', $meaning5);
            $stmt->bindParam(':word_image_uri', $word_image_uri);
            if(file_exists("./word_images/" . $word_image_file_name)){
                unlink("./word_images/" . $word_image_file_name);
            }
            if ($stmt->execute()) {
                $successMSG = "chapter has updated";
                echo $successMSG;
            } else {
                $errMSG = "chapter update has failed";
                echo $errMSG;
            }

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());

        }
    }
}

function startsWith($haystack, $needle)
{
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}