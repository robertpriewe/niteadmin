<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');

if(isset($_GET['taskid'])) {
    $result = mysqli_query($mysqli, 'UPDATE shows_riders SET ITEMDELETED = 1 WHERE RIDERITEMID = ' . $_GET['taskid']);

}