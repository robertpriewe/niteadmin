<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');
$target_dir = "../files/" . md5(date("YmdHis") . rand(10000, 99999)) . "/";
$target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["upload_file"]["tmp_name"]);
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
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["upload_file"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "pdf" ) {
    echo "Sorry, only PDF, JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
        $result = mysqli_query($mysqli, "UPDATE shows_fields SET " . urldecode($_GET['fieldname']) . " = '" . $target_file . "' WHERE SHOWID = '" . $_GET['setid'] . "'");
        addToLog($_SESSION['USERID'], 'uploaded_file', $page, '', '', urldecode($_GET['fieldname']), basename( $_FILES["upload_file"]["name"]), 'Uploaded file ' . basename( $_FILES["upload_file"]["name"]) . ' for field ' . urldecode($_GET['fieldname']) . ' in show ID ' . $_GET['setid']);

        echo "The file ". basename( $_FILES["upload_file"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>