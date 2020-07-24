<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');


if (isset($_GET['venueid']) && isset($_POST['name'])) {

    $result = mysqli_query($mysqli, 'INSERT INTO stages (VENUEID, STAGENAME) VALUES ("' . $_GET['venueid'] . '", "' . $_POST['name'] . '")');
    echo 'INSERT INTO stages (VENUEID, STAGENAME) VALUES ("' . $_GET['venueid'] . '", "' . $_POST['name'] . '")';
}