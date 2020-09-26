<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');

if (isset($_GET['artistid'])) {
    $timestamp = date("Y-m-d H:i:s", strtotime($_POST['contactDate'] . ' ' . $_POST['contactTime']));

    mysqli_query($mysqli, 'INSERT INTO contact_activity (TIMESTAMP, CONTACTEDTYPE, CONTACTEDNOTE, CONTACTEDUSERID, CONTACTEDLINKID, CONTACTEDEVENTID, CONTACTEDARTISTID) VALUES ("' . $timestamp . '", "' . $_POST['contactType'] . '", "' . $_POST['activityDetails'] . '", "' . $_SESSION['USERID'] . '", "' . $_POST['contactId'] . '", "' . $_POST['eventid'] . '", "' . $_GET['artistid'] . '")');

    addToLog($_SESSION['USERID'], 'new', 'contact_activity', '', $_GET['artistid'], '', '', 'Added contact activity for artist: ' . $_GET['artistid']);

}