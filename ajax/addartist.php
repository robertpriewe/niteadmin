<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
error_log('adding artist..
    ', 3, 'log.txt');

if (isset($_POST['artistname'])) {
    $result = mysqli_query($mysqli, 'INSERT INTO artists (ARTISTNAME) VALUES("' . $_POST['artistname'] . '")');
    //$artistid = mysqli_insert_id($mysqli);

    //$result = mysqli_query($mysqli, 'INSERT INTO contacts_link (CONTACTID, LINKTABLE, LINKID) VALUES("0", "artists", "' . $artistid . '")');
}
include('../modules/maintenance/artistprofilepictures.php')
?>