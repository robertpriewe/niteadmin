<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');
error_log('assigncontact.....
    ', 3, 'log.txt');


if (isset($_GET['contactid'])) {
    if (isset($_GET['artistid'])) {

        if (isset($_GET['action'])) {
            if ($_GET['action'] == "change") {
                $result = mysqli_query($mysqli, 'UPDATE artists SET MANAGERID = ' . $_GET['contactid'] . ' WHERE ARTISTID = ' . $_GET['artistid']);
                echo 'UPDATE artists SET MANAGERID = ' . $_GET['contactid'] . ' WHERE ARTISTID = ' . $_GET['artistid'];
            }
        } else {

            $result = mysqli_query($mysqli, 'INSERT INTO contacts_link (CONTACTID, LINKTABLE, LINKID) VALUES ("' . $_GET['contactid'] . '", "artists", "' . $_GET['artistid'] . '")');
            echo 'INSERT INTO contacts_link (CONTACTID, LINKTABLE, LINKID) VALUES ("' . $_GET['contactid'] . '", "artists", "' . $_GET['artistid'] . '")';
        }
    }
    elseif (isset($_GET['vendorid'])) {
        $result = mysqli_query($mysqli, 'INSERT INTO contacts_link (CONTACTID, LINKTABLE, LINKID) VALUES ("' . $_GET['contactid'] . '", "vendors", "' . $_GET['vendorid'] . '")');
        echo 'INSERT INTO contacts_link (CONTACTID, LINKTABLE, LINKID) VALUES ("' . $_GET['contactid'] . '", "vendors", "' . $_GET['vendorid'] . '"';
    } elseif (isset($_GET['venueid'])) {
        $result = mysqli_query($mysqli, 'INSERT INTO contacts_link (CONTACTID, LINKTABLE, LINKID) VALUES ("' . $_GET['contactid'] . '", "venues", "' . $_GET['venueid'] . '")');
    }

    addToLog($_SESSION['USERID'], 'assign', 'contacts', '', '', $_GET['contactid'], '', 'Assigned contact id ' . $_GET['contactid']);

}
?>