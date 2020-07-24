<?php
error_log('running..
', 3, 'log.txt');
session_start();
include ('../modules/sql.php');

$pk = $_POST['pk']['id'];
$page = $_POST['pk']['page'];
$name = $_POST['name'];
$value = $_POST['value'];
$dump = var_export($_POST, true);
error_log($pk . ' - ' . $page . ' - ' . $name . ' - ' . $value . '......', 3, 'log.txt');
error_log($dump, 3, 'log.txt');

if(!empty($value)) {
    if ($page=='shows_fields') {
        error_log('UPDATE ' . $page . ' SET '.mysqli_escape_string($mysqli, $name).'="'.mysqli_escape_string($mysqli, $value).'" WHERE SHOWID = "'.mysqli_escape_string($mysqli, $pk).'"', 3, 'log.txt');
     $result = mysqli_query($mysqli, 'UPDATE ' . $page . ' SET '.mysqli_escape_string($mysqli, $name).'="'.mysqli_escape_string($mysqli, $value).'" WHERE SHOWID = "'.mysqli_escape_string($mysqli, $pk).'"');
} elseif ($page=='stages') {
    $result = mysqli_query($mysqli, 'UPDATE ' . $page . ' SET '.mysqli_escape_string($mysqli, $name).'="'.mysqli_escape_string($mysqli, $value).'" WHERE STAGEID = "'.mysqli_escape_string($mysqli, $pk).'"');
} elseif ($page=='artists') {
    $result = mysqli_query($mysqli, 'UPDATE ' . $page . ' SET '.mysqli_escape_string($mysqli, $name).'="'.mysqli_escape_string($mysqli, $value).'" WHERE ARTISTID = "'.mysqli_escape_string($mysqli, $pk).'"');
} elseif ($page=='vendors') {
        $result = mysqli_query($mysqli, 'UPDATE ' . $page . ' SET '.mysqli_escape_string($mysqli, $name).'="'.mysqli_escape_string($mysqli, $value).'" WHERE VENDORID = "'.mysqli_escape_string($mysqli, $pk).'"');
} elseif ($page=='events_vendors_fields') {
        $result = mysqli_query($mysqli, 'UPDATE ' . $page . ' SET '.mysqli_escape_string($mysqli, $name).'="'.mysqli_escape_string($mysqli, $value).'" WHERE EVENTVENDORID = "'.mysqli_escape_string($mysqli, $pk).'"');
} elseif ($page=='sponsors') {
        $result = mysqli_query($mysqli, 'UPDATE ' . $page . ' SET '.mysqli_escape_string($mysqli, $name).'="'.mysqli_escape_string($mysqli, $value).'" WHERE SPONSORID = "'.mysqli_escape_string($mysqli, $pk).'"');
} elseif ($page=='events_sponsors_fields') {
    $result = mysqli_query($mysqli, 'UPDATE ' . $page . ' SET '.mysqli_escape_string($mysqli, $name).'="'.mysqli_escape_string($mysqli, $value).'" WHERE EVENTSPONSORID = "'.mysqli_escape_string($mysqli, $pk).'"');
} elseif ($page=='events') {
    $result = mysqli_query($mysqli, 'UPDATE ' . $page . ' SET '.mysqli_escape_string($mysqli, $name).'="'.mysqli_escape_string($mysqli, $value).'" WHERE EVENTID = "'.mysqli_escape_string($mysqli, $pk).'"');
} elseif ($page=='contacts') {
        $result = mysqli_query($mysqli, 'UPDATE ' . $page . ' SET '.mysqli_escape_string($mysqli, $name).'="'.mysqli_escape_string($mysqli, $value).'" WHERE CONTACTID = "'.mysqli_escape_string($mysqli, $pk).'"');
    }

        
} else {
    header('HTTP/1.0 400 Bad Request', true, 400);
    echo "This field is required!";
}
?>