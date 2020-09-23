<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');
error_log('addingsponsor..
    ', 3, 'log.txt');

if (isset($_POST['sponsorname'])) {
    $result = mysqli_query($mysqli, 'INSERT INTO sponsors (SPONSORNAME, SPONSORTYPE) VALUES("' . $_POST['sponsorname'] . '", "' . $_POST['sponsortype'] . '")');
    addToLog($_SESSION['USERID'], 'new', 'sponsors', '', '', 'SPONSORNAME', $_POST['sponsorname'], 'Added new sponsor ' . $_POST['sponsorname']);

}
?>