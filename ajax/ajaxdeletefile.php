<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
$result = mysqli_query($mysqli, "SELECT * FROM shows_fields WHERE SHOWID = '" . $_GET['setid'] . "' LIMIT 0, 1");
while($row = $result->fetch_array()) {
    unlink("../files/" . $row[urldecode($_GET['fieldname'])]);
    mysqli_query($mysqli, "UPDATE shows_fields SET " . urldecode($_GET['fieldname']) . " = '' WHERE SHOWID = '" . $_GET['setid'] . "'");
}

