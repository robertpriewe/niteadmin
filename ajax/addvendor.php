<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
error_log('addingvendor..
    ', 3, 'log.txt');

if (isset($_POST['vendorname'])) {
    $result = mysqli_query($mysqli, 'INSERT INTO vendors (VENDORNAME, VENDORTYPE) VALUES("' . $_POST['vendorname'] . '", "' . $_POST['vendortype'] . '")');
}
?>