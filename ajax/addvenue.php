<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');


if (isset($_POST['venuename'])) {
    mysqli_query($mysqli, 'INSERT INTO venues (VENUENAME) VALUES("' . $_POST['venuename'] . '")');
    addToLog($_SESSION['USERID'], 'new', 'venues', '', '', 'VENUENAME', $_POST['venuename'], 'Added new venue: ' . $_POST['venuename']);

    //echo 'INSERT INTO venues (VENUENAME) VALUES ("' . $_POST['venuename'] . '")';
    $query = mysqli_query($mysqli, 'SELECT * FROM venues ORDER BY VENUEID DESC LIMIT 0, 1');
    while($row = $query->fetch_array()) {
        mysqli_query($mysqli, 'INSERT INTO stages (STAGENAME, VENUEID, UNASSIGNEDSTAGE) VALUES ("Stage Unassigned", "' . $row['VENUEID'] . '", "1")');
        echo 'INSERT INTO stages (STAGENAME, VENUEID, UNASSIGNEDSTAGE) VALUES ("Stage Unassigned", "' . $row['VENUEID'] . '", "1")';
    }


}
?>