<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
error_log('assignstage..
    ', 3, 'log.txt');


if (isset($_GET['setid']) && isset($_GET['stageid'])) {

    echo 'UPDATE shows SET STAGEID = ' . $_GET['stageid'] . ' WHERE SHOWID = ' . $_GET['setid'];
    $result = mysqli_query($mysqli, 'UPDATE shows SET STAGEID = ' . $_GET['stageid'] . ' WHERE SHOWID = ' . $_GET['setid']);
}
?>

