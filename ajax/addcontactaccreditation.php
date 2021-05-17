<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');

if (isset($_GET['setid'])) {
    mysqli_query($mysqli, 'UPDATE shows_fields SET ' . $_GET['fieldname'] . ' = ' . $_POST['contactId'] . ' WHERE SHOWID = ' . $_GET['setid']);

    addToLog($_SESSION['USERID'], 'update', 'shows_fields', '', $_GET['artistid'], '', '', 'Changed contact accreditation ' . $_GET['fieldname'] . ' - for show: ' . $_GET['setid']);

}