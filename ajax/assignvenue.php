<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');
error_log('log..
    ', 3, 'log.txt');


if (isset($_GET['eventid'])) {
    $result = mysqli_query($mysqli, 'UPDATE events SET VENUEID = "' . $_GET['venueid'] . '" WHERE EVENTID = "' . $_GET['eventid'] . '"');
    addToLog($_SESSION['USERID'], 'assign', 'venue', '', '', $_GET['venueid'], '', 'Assigned venue id ' . $_GET['venueid'] . ' to event ' . $_GET['eventid']);

}
?>