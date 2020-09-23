<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');

error_log('removeartistfromshow.....
    ', 3, 'log.txt');


if (isset($_GET['artistid']) && isset($_GET['eventid'])) {

    $result = mysqli_query($mysqli, 'DELETE FROM shows WHERE ARTISTPLAYINGID = ' . $_GET['artistid'] . ' AND EVENTID = ' . $_GET['eventid']);
    echo 'DELETE FROM shows WHERE ARTISTPLAYINGID = ' . $_GET['artistid'] . ' AND EVENTID = ' . $_GET['eventid'];
    addToLog($_SESSION['USERID'], 'delete', 'artists', $_GET['eventid'], $_GET['artistid'], '', '', 'Delete artist ' . $_GET['artistid'] . ' from event ' . $_GET['eventid']);

}
?>