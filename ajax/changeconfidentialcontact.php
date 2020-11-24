<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');
mysqli_query($mysqli, "UPDATE contacts SET CONFIDENTIAL = '" . $_GET['confidential'] . "' WHERE CONTACTID = '" . $_GET['contactid'] . "'");
addToLog($_SESSION['USERID'], 'update', 'contacts', '', '', 'CONFIDENTIAL', $_GET['confidential'], 'Updated confidential to: ' . $_GET['confidential'] . ' for contact id: ' . $_GET['contactid']);

?>