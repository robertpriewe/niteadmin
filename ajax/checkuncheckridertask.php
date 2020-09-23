<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');

if(isset($_GET['taskid']) && isset($_GET['checked'])) {
    if ($_GET['checked'] == 'true') {
        $done = '1';
    } else {
        $done = '0';
    }
    $result = mysqli_query($mysqli, 'UPDATE shows_riders SET ITEMDONE = ' . $done . ' WHERE RIDERITEMID = ' . $_GET['taskid']);
    addToLog($_SESSION['USERID'], 'change', 'ridertaskid', '', '', $_GET['taskid'], '', 'Changed rider task id ' . $_GET['taskid'] . ' to ' . $done);


}