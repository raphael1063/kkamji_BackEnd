<?php

$result = array("success" => $_FILES["file"]["name"]);
$file_path = './profile_images/' . basename($_FILES['file']['name']);
if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
    $result = array("success" => "Image File successfully uploaded");
} else {
    $result = array("error" => $_FILES["file"]["error"] . "error uploading file. file_path : " . $file_path);
}
echo json_encode($result, JSON_PRETTY_PRINT);


