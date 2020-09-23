<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');

if (isset($_POST['artistname'])) {
    $result = mysqli_query($mysqli, 'INSERT INTO artists (ARTISTNAME) VALUES("' . $_POST['artistname'] . '")');

    addToLog($_SESSION['USERID'], 'new', 'artists', '', $_POST['artistname'], 'ARTISTNAME', $_POST['artistname'], 'Added new artist ' . $_POST['artistname']);

    //$result = mysqli_query($mysqli, 'INSERT INTO contacts_link (CONTACTID, LINKTABLE, LINKID) VALUES("0", "artists", "' . $artistid . '")');
}
include('../modules/maintenance/artistprofilepictures.php')
?>