<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');

if (isset($_GET['id'])) {
    if ($_GET['fieldtype'] == 'shows') {
        $fieldtype = 'SHOWID';
        $fields = 'shows_fields';
    } else {
        $fieldtype = 'EVENTID';
        $fields = 'events';
    }
    mysqli_query($mysqli, 'UPDATE ' . $fields . ' SET ' . $_GET['fieldname'] . ' = "" WHERE ' . $fieldtype . ' = ' . $_GET['id']);
    addToLog($_SESSION['USERID'], 'update', $fields, '', $_GET['artistid'], '', '', 'Removed contact accreditation ' . $_GET['fieldname'] . ' - for show: ' . $_GET['id']);
}