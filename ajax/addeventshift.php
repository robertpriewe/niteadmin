<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');


if (isset($_GET['eventid']) && isset($_POST['shiftname']) && isset($_POST['datestart']) && isset($_POST['timestart']) && isset($_POST['dateend']) && isset($_POST['timeend'])) {

    $starttime = $_POST['datestart'] . " " . $_POST['timestart'];
    $endtime = $_POST['dateend'] . " " . $_POST['timeend'];
    echo 'INSERT INTO shifts (EVENTID, DESCRIPTION, STARTTIME, ENDTIME) VALUES ("' . $_GET['eventid'] . '", "' . $_POST['shiftname'] . '", "' . $starttime . '", "' . $endtime . '")';
    $result = mysqli_query($mysqli, 'INSERT INTO shifts (EVENTID, DESCRIPTION, STARTTIME, ENDTIME) VALUES ("' . $_GET['eventid'] . '", "' . $_POST['shiftname'] . '", "' . $starttime . '", "' . $endtime . '")');

}
else {
    echo 'error';
}