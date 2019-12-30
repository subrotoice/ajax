<?php
require_once('config.php');
// Highly Secure input handling for SQL Injection
$date = new DateTime();
$lastUpdate = $date->getTimestamp();
// var_dump($_POST);
// var_dump($_FILES["fileToUpload"]["name"]);
// $ext = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
// var_dump($ext);
// // exit;

$id = trim(filter_input(INPUT_POST,"id",FILTER_SANITIZE_NUMBER_INT));
$meaning = trim(filter_input(INPUT_POST,"meaning",FILTER_SANITIZE_STRING));
$word = trim(filter_input(INPUT_POST,"word",FILTER_SANITIZE_STRING));
$synonym = trim(filter_input(INPUT_POST,"synonym",FILTER_SANITIZE_STRING));
$antonym = trim(filter_input(INPUT_POST,"antonym",FILTER_SANITIZE_STRING));
$sentence = trim(filter_input(INPUT_POST,"sentence",FILTER_SANITIZE_STRING));

if( $_FILES["fileToUpload"]["name"] == '' ) { // Without Image
$sql = "UPDATE vocabulary SET
meaning=:meaning,
synonym=:synonym,
antonym=:antonym,
sentence=:sentence,
lastUpdate=:lastUpdate
WHERE id=:id";

$stmt = $pdo->prepare($sql); // Here $stmt is object (Statement Object)

$stmt->bindParam(':meaning', $meaning, PDO::PARAM_STR);
$stmt->bindParam(':synonym', $synonym, PDO::PARAM_STR);
$stmt->bindParam(':antonym', $antonym, PDO::PARAM_STR);
$stmt->bindParam(':sentence', $sentence, PDO::PARAM_STR);
$stmt->bindParam(':lastUpdate', $lastUpdate, PDO::PARAM_INT);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
echo "Succefully Updated";
} else {
echo "Fail To Update";
}
} else {
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $finalUploadFile = $word . '.' . $imageFileType;

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        unlink($target_file);
        // echo "Sorry, file already exists.";
        // $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'images/' . $finalUploadFile)) {
            $image = basename( $_FILES["fileToUpload"]["name"]);
            // echo "The file ". $image . " has been uploaded.";
            $sql = "UPDATE vocabulary SET
            meaning=:meaning,
            synonym=:synonym,
            antonym=:antonym,
            sentence=:sentence,
            image=:image,
            lastUpdate=:lastUpdate
            WHERE id=:id";
            
            $stmt = $pdo->prepare($sql); // Here $stmt is object (Statement Object)
            
            $stmt->bindParam(':meaning', $meaning, PDO::PARAM_STR);
            $stmt->bindParam(':synonym', $synonym, PDO::PARAM_STR);
            $stmt->bindParam(':antonym', $antonym, PDO::PARAM_STR);
            $stmt->bindParam(':sentence', $sentence, PDO::PARAM_STR);
            $stmt->bindParam(':image', $finalUploadFile, PDO::PARAM_STR);
            $stmt->bindParam(':lastUpdate', $lastUpdate, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Succefully Updated";
                } else {
                echo "Fail To Update";
                }

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>
