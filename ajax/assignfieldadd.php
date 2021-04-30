<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');
error_log('assigning field..
    ', 3, 'log.txt');


if (isset($_GET['setid']) && isset($_GET['userid']) && isset($_GET['fieldid'])) {
    echo 'INSERT INTO shows_assigned_users (SHOWID, FIELDID, USERID) VALUES ("", "", "")';
    $result = mysqli_query($mysqli, 'INSERT INTO shows_assigned_users (SHOWID, FIELDID, USERID) VALUES ("'. $_GET['setid'] . '", "'. $_GET['fieldid'] . '", "'. $_GET['userid'] . '")');
    addToLog($_SESSION['USERID'], 'assign', 'field', '', '', $_GET['fieldid'], '', 'Assigned field id ' . $_GET['fieldid'] . ' in show: '. $_GET['setid'] .' . to user ' . $_GET['userid']);
}
?>

