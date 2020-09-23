<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');


if (isset($_POST['vendorname'])) {
    $result = mysqli_query($mysqli, 'INSERT INTO vendors (VENDORNAME, VENDORTYPE) VALUES("' . $_POST['vendorname'] . '", "' . $_POST['vendortype'] . '")');
    addToLog($_SESSION['USERID'], 'new', 'vendors', '', '', 'VENDORNAME', $_POST['vendorname'], 'Added new vendor ' . $_POST['vendorname']);
}
?>