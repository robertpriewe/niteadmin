<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');

if (isset($_POST['venueid']) && isset($_POST['eventname']) && isset($_POST['startdate']) && isset($_POST['enddate'])) {

    $result = mysqli_query($mysqli, 'INSERT INTO events (EVENTNAME, EVENTSTARTDATE, EVENTENDDATE) VALUES ("' . $_POST['eventname'] . '", "' . $_POST['startdate'] . '", "' . $_POST['enddate'] . '")');
    $eventid = mysqli_insert_id($mysqli);
    addToLog($_SESSION['USERID'], 'new', 'events', $_POST['eventname'], '', 'EVENTNAME', $_POST['eventname'], 'Added new event: ' . $_POST['eventname']);

    $result = mysqli_query($mysqli, 'SELECT STAGEID FROM venues JOIN stages ON venues.VENUEID = stages.VENUEID WHERE venues.VENUEID = ' . $_POST['venueid'] . ' AND UNASSIGNEDSTAGE = 1');
    while($row = $result->fetch_array()) {
        $stageid = $row['STAGEID'];
    }

    echo 'INSERT INTO shows (ARTISTPLAYINGID, STAGEID, EVENTID) VALUES ("0", "' . $stageid . '", "' . $eventid . '")';
    $result = mysqli_query($mysqli, 'INSERT INTO shows (ARTISTPLAYINGID, STAGEID, EVENTID) VALUES ("0", "' . $stageid . '", "' . $eventid . '")');
}