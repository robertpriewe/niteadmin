<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');
error_log('assignngvendor..
    ', 3, 'log.txt');


if (isset($_GET['vendorid']) && isset($_GET['eventid'])) {
    $result = mysqli_query($mysqli, 'INSERT INTO events_vendors_link (EVENTID, VENDORID) VALUES ("' . $_GET['eventid'] . '", "' . $_GET['vendorid'] . '")');

    $eventvendorid = mysqli_insert_id($mysqli);

    $result = mysqli_query($mysqli, 'INSERT INTO events_vendors_fields (EVENTVENDORID) VALUES ("' . $eventvendorid . '")');
    addToLog($_SESSION['USERID'], 'assign', 'vendors', '', '', $_GET['vendorid'], '', 'Assigned vendor id ' . $_GET['vendorid'] . ' to eventid ' . $_GET['eventid']);

}
?>