<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
error_log('assigningartist..
    ', 3, 'log.txt');


if (isset($_GET['artistid']) && isset($_GET['eventid'])) {
    $result = mysqli_query($mysqli, 'SELECT stages.STAGEID FROM stages JOIN shows ON stages.STAGEID = shows.STAGEID WHERE EVENTID = ' . $_GET['eventid'] . ' AND UNASSIGNEDSTAGE = 0 GROUP BY STAGENAME');
    if ($result->num_rows == 1) {
        //Only one stage, assign to that stage
        while($row = $result->fetch_array()) {
            $stageid = $row['STAGEID'];
        }
    } else {
        $result = mysqli_query($mysqli, 'SELECT stages.STAGEID FROM stages JOIN shows ON stages.STAGEID = shows.STAGEID WHERE EVENTID = ' . $_GET['eventid'] . ' AND UNASSIGNEDSTAGE = 1');
        while ($row = $result->fetch_array()) {
            $stageid = $row['STAGEID'];
        }
    }
    $result = mysqli_query($mysqli, 'INSERT INTO shows (STAGEID, ARTISTPLAYINGID, EVENTID) VALUES ("' . $stageid . '", "' . $_GET['artistid'] . '", "' . $_GET['eventid'] . '")');
    //echo 'INSERT INTO shows (STAGEID, ARTISTPLAYINGID, EVENTID) VALUES ("' . $stageid . '", "' . $_GET['artistid'] . '", "' . $_GET['eventid'] . '")';

    $showid = mysqli_insert_id($mysqli);
    echo 'INSERT INTO shows_fields (SHOWID) VALUES ("' . $showid . '")';
    $result = mysqli_query($mysqli, 'INSERT INTO shows_fields (SHOWID) VALUES ("' . $showid . '")');
}
?>