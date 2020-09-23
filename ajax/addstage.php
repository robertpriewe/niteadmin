<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');

if (isset($_GET['venueid']) && isset($_POST['name'])) {

    $result = mysqli_query($mysqli, 'INSERT INTO stages (VENUEID, STAGENAME) VALUES ("' . $_GET['venueid'] . '", "' . $_POST['name'] . '")');
    echo 'INSERT INTO stages (VENUEID, STAGENAME) VALUES ("' . $_GET['venueid'] . '", "' . $_POST['name'] . '")';
    addToLog($_SESSION['USERID'], 'new', 'stages', 'VenueID ' . $_GET['venueid'], '', 'STAGENAME', $_POST['name'], 'Added new stage: ' . $_POST['name']);
}