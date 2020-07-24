<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');

if(isset($_GET['setid'])) {
    $text = $_POST['tasks'];

    $arr = explode("\n-", $text);
    if (count($arr) <= 1) {
        $arr = explode("\n", $text);
        if (count($arr) <= 1) {
            $arr = explode("-", $text);
        }
    }

    foreach ($arr as $val) {
        $val = ltrim($val, "-");
        $result = mysqli_query($mysqli, 'INSERT INTO shows_riders (SETID, ITEMNAME) VALUES ("' . $_GET['setid'] . '", "' . $val . '")');

    }
}
else {
    echo 'No setid specified';
}