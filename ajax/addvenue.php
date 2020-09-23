<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');


if (isset($_POST['venuename'])) {
    $result = mysqli_query($mysqli, 'INSERT INTO venues (VENUENAME) VALUES("' . $_POST['venuename'] . '")');
    addToLog($_SESSION['USERID'], 'new', 'venues', '', '', 'VENUENAME', $_POST['venuename'], 'Added new venue: ' . $_POST['venuename']);

    //echo 'INSERT INTO venues (VENUENAME) VALUES ("' . $_POST['venuename'] . '")';

    $result = mysqli_query($mysqli, 'INSERT INTO stages (STAGENAME, VENUEID, UNASSIGNEDSTAGE) VALUES ("Stage Unassigned", "' . mysqli_insert_id($mysqli) . '", "1")');
}
?>