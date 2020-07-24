<?php
session_start();
error_reporting(E_ALL);
include ('../sql.php');

if (isset($_GET['guestid'])) {

    $result = mysqli_query($mysqli, 'UPDATE guestlist SET CHECKIN = now() WHERE ID = "' . $_GET['guestid'] . '"');
    echo 'UPDATE guestlist SET CHECKIN = now() WHERE ID = "' . $_GET['guestid'] . '"';
}
?>