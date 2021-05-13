<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');
error_log('assigning field..
    ', 3, 'log.txt');


if (isset($_GET['idtype']) && isset($_GET['userid']) && isset($_GET['fieldid'])) {
    echo 'INSERT INTO shows_assigned_users (SHOWID, FIELDID, USERID) VALUES ("", "", "")';
    if ($_GET['table'] == "shows") {
        $result = mysqli_query($mysqli, 'INSERT INTO shows_assigned_users (SHOWID, FIELDID, USERID) VALUES ("'. $_GET['idtype'] . '", "'. $_GET['fieldid'] . '", "'. $_GET['userid'] . '")');
        addToLog($_SESSION['USERID'], 'assign', 'field', '', '', $_GET['fieldid'], '', 'Assigned field id ' . $_GET['fieldid'] . ' in show: '. $_GET['idtype'] .' . to user ' . $_GET['userid']);
    } else {
        $result = mysqli_query($mysqli, 'INSERT INTO events_assigned_users (EVENTID, FIELDID, USERID) VALUES ("'. $_GET['idtype'] . '", "'. $_GET['fieldid'] . '", "'. $_GET['userid'] . '")');
        addToLog($_SESSION['USERID'], 'assign', 'field', '', '', $_GET['fieldid'], '', 'Assigned field id ' . $_GET['fieldid'] . ' in event: '. $_GET['idtype'] .' . to user ' . $_GET['userid']);
    }

}
?>

