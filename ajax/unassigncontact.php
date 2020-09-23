<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');
error_log('unassigncontact.....
    ', 3, 'log.txt');


if (isset($_GET['contactid'])) {
    if (isset($_GET['artistid'])) {
        $linktable = 'artists';
        $id = $_GET['artistid'];
    } elseif (isset($_GET['vendorid'])) {
        $linktable = 'vendors';
        $id = $_GET['vendorid'];
    } elseif (isset($_GET['venueid'])) {
        $linktable = 'venues';
        $id = $_GET['venueid'];
    }
    $result = mysqli_query($mysqli, 'DELETE FROM contacts_link WHERE CONTACTID = ' . $_GET['contactid'] . ' AND LINKID = ' . $id . ' AND LINKTABLE = "' . $linktable . '"');
    echo 'DELETE FROM contacts_link WHERE CONTACTID = ' . $_GET['contactid'] . ' AND LINKID = ' . $id . ' AND LINKTABLE = "' . $linktable . '"';
    addToLog($_SESSION['USERID'], 'unassign', 'contacts', '', '', $_GET['contactid'], '', 'Unassigned contact id ' . $_GET['contactid'] . ' from ' . $linktable);

}
?>