<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');

if (isset($_GET['shiftid']) && isset($_GET['employeeid'])) {
    mysqli_query($mysqli, 'INSERT INTO shifts_users_link (SHIFTID, USERID) VALUES ("' . $_GET['shiftid'] . '", "' . $_GET['employeeid'] . '")');
    echo 'INSERT INTO shifts_users_link (SHIFTID, USERID) VALUES ("' . $_GET['shiftid'] . '", "' . $_GET['employeeid'] . '")';
    addToLog($_SESSION['USERID'], 'assign', 'shifts', '', '', $_GET['shiftid'], '', 'Assigned employee id ' . $_GET['employeeid'] . ' to shift ' . $_GET['shiftid']);

} else {
    echo 'Error';
}
?>