<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');

if(isset($_GET['taskid']) && isset($_GET['checked'])) {
    if ($_GET['checked'] == 'true') {
        $done = '1';
    } else {
        $done = '0';
    }
    $result = mysqli_query($mysqli, 'UPDATE shows_riders SET ITEMDONE = ' . $done . ' WHERE RIDERITEMID = ' . $_GET['taskid']);

}