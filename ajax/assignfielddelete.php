<?php
session_start();
error_reporting(E_ALL);
include('../modules/sql.php');
include('addtolog.php');
error_log('deleting field..
    ', 3, 'log.txt');

if (isset($_GET['idtype']) && isset($_GET['userid']) && isset($_GET['fieldid'])) {
    if ($_GET['table'] == "shows") {
        $result = mysqli_query($mysqli, 'DELETE FROM shows_assigned_users WHERE SHOWID = "' . $_GET['idtype'] . '" AND FIELDID = "' . $_GET['fieldid'] . '" AND USERID = "' . $_GET['userid'] . '"');
        addToLog($_SESSION['USERID'], 'unassign', 'field', '', '', $_GET['fieldid'], '', 'Unassigned field id ' . $_GET['fieldid'] . ' in show: ' . $_GET['idtype'] . ' . to user ' . $_GET['userid']);
    } else {
        $result = mysqli_query($mysqli, 'DELETE FROM events_assigned_users WHERE EVENTID = "' . $_GET['idtype'] . '" AND FIELDID = "' . $_GET['fieldid'] . '" AND USERID = "' . $_GET['userid'] . '"');
        addToLog($_SESSION['USERID'], 'unassign', 'field', '', '', $_GET['fieldid'], '', 'Unassigned field id ' . $_GET['fieldid'] . ' in event: ' . $_GET['idtype'] . ' . to user ' . $_GET['userid']);

    }
}


