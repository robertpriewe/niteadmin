<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
error_log('addingsponsor..
    ', 3, 'log.txt');

if (isset($_POST['sponsorname'])) {
    $result = mysqli_query($mysqli, 'INSERT INTO sponsors (SPONSORNAME, SPONSORTYPE) VALUES("' . $_POST['sponsorname'] . '", "' . $_POST['sponsortype'] . '")');
}
?>