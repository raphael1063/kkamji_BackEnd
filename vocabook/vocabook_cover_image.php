<?php


$result = array("success" => $_FILES["file"]["name"]);
$file_path = './vocabook_cover_images/' . basename($_FILES['file']['name']);
$uploadOk = 1;
$imageFileType = pathinfo($file_path, PATHINFO_EXTENSION);

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "파일의 크기가 너무 큽니다.\n";
    $uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "JPG, JPEG, PNG 파일만 사용 가능합니다.\n";
    $uploadOk = 0;
} else {
    echo "확장자 이상 없음. 확장자 : " , $imageFileType. "\n";
}
if($uploadOk = 1){
    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
        $result = array("success" => "Image File successfully uploaded");
    } else {
        $result = array("error" => $_FILES["file"]["error"] . "error uploading file. file_path : " . $file_path);
    }
    echo json_encode($result, JSON_PRETTY_PRINT);
} else {
    echo "이미지 업로드 실패\n";
}
