<?php
session_start();
error_reporting(E_ALL);
include ('../../modules/sql.php');
include('../addtolog.php');


$target_dir = "../../files/" . md5(date("YmdHis") . rand(10000, 99999)) . "/";
$target_file = $target_dir . basename($_FILES["offer"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["offer"]["tmp_name"]);
    if ($check !== false) {
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
if ($_FILES["offer"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "pdf") {
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
    if (move_uploaded_file($_FILES["offer"]["tmp_name"], $target_file)) {
        $offerpath = $target_file;
    } else {
        $offerpath = '';
    }
}

$offerpath = str_ireplace("../../files/", "", $offerpath);

if ($_POST['buyouthotelcheck'] == "true") {
    $_POST['buyouthotelcheck'] = "Yes";
} else {
    $_POST['buyouthotelcheck'] = "No";
}
if ($_POST['buyoutgroundcheck'] == "true") {
    $_POST['buyoutgroundcheck'] = "Yes";
} else {
    $_POST['buyoutgroundcheck'] = "No";
}
if ($_POST['buyouthospitalitycheck'] == "true") {
    $_POST['buyouthospitalitycheck'] = "Yes";
} else {
    $_POST['buyouthospitalitycheck'] = "No";
}



if (isset($_GET['showid']) && $_GET['showid'] != "undefined") {

    mysqli_query($mysqli, "UPDATE shows_fields SET 
    GUARANTEE = '" . $_POST['guarantee'] . "', 
    OFFER = '" . $offerpath . "', 
    HOTELCOST = '" . $_POST['hotel'] . "', 
    HOTELBUYOUT = '" . $_POST['buyouthotelcheck'] . "', 
    HOTEL = '" . $_POST['hotelnotes'] . "', 
    TRANSPORTATIONCOST = '" . $_POST['groundtransportation'] . "', 
    TRANSPORTATIONBUYOUT = '" . $_POST['buyoutgroundcheck'] . "', 
    TRANSPORTATIONNOTES = '" . $_POST['groundnotes'] . "', 
    HOSPITALITYCOST = '" . $_POST['hospitality'] . "', 
    HOSPITALITYBUYOUT = '" . $_POST['buyouthospitalitycheck'] . "', 
    HOSPITALITYNOTES = '" . $_POST['hospitalitynotes'] . "',     
    SETDURATIONMINUMUM = '" . $_POST['setduration'] . "' 
    WHERE SHOWID = '" . $_GET['showid'] . "'");


} else {
    echo 'No showid';
}
?>


