<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');

if (isset($_GET['shiftid']) && isset($_GET['employeeid'])) {
    mysqli_query($mysqli, 'INSERT INTO shifts_users_link (SHIFTID, USERID) VALUES ("' . $_GET['shiftid'] . '", "' . $_GET['employeeid'] . '")');
    echo 'INSERT INTO shifts_users_link (SHIFTID, USERID) VALUES ("' . $_GET['shiftid'] . '", "' . $_GET['employeeid'] . '")';
} else {
    echo 'Error';
}
?>