<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');
error_log('assignngsponsor..
    ', 3, 'log.txt');


if (isset($_GET['sponsorid']) && isset($_GET['eventid'])) {
    $result = mysqli_query($mysqli, 'INSERT INTO events_sponsors_link (EVENTID, SPONSORID) VALUES ("' . $_GET['eventid'] . '", "' . $_GET['sponsorid'] . '")');

    $eventsponsorid = mysqli_insert_id($mysqli);

    $result = mysqli_query($mysqli, 'INSERT INTO events_sponsors_fields (EVENTSPONSORID) VALUES ("' . $eventsponsorid . '")');
    addToLog($_SESSION['USERID'], 'assign', 'sponsors', '', '', $_GET['sponsorid'], '', 'Assigned sponsor id ' . $_GET['sponsorid'] . ' to eventid ' . $_GET['eventid']);

}
?>