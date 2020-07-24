<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
error_log('removing b2b.....
    ', 3, 'log.txt');


if (isset($_GET['id'])) {

    $result = mysqli_query($mysqli, 'DELETE FROM shows_b2b WHERE id = ' . $_GET['id']);
    echo 'DELETE FROM shows_b2b WHERE id = ' . $_GET['id'];
}
?>