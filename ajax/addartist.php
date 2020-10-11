<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');

if (isset($_POST['artistname'])) {
    $result = mysqli_query($mysqli, 'INSERT INTO artists (ARTISTNAME) VALUES("' . $_POST['artistname'] . '")');

    echo mysqli_insert_id($mysqli);
    addToLog($_SESSION['USERID'], 'new', 'artists', '', $_POST['artistname'], 'ARTISTNAME', $_POST['artistname'], 'Added new artist ' . $_POST['artistname']);


}
include('../modules/maintenance/artistprofilepictures.php')
?>