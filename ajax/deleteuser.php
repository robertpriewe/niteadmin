<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');

if (isset($_SESSION['ACCESS']['ADMIN'])) {

    if (isset($_GET['userid'])) {

        $result = mysqli_query($mysqli, 'DELETE FROM users WHERE USERID = ' . $_GET['userid']);
        addToLog($_SESSION['USERID'], 'delete', 'users', '', '', '', '', 'Deleted user ' . $_GET['userid']);
        echo "User deleted";
    }
}
?>