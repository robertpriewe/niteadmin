<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');

if (isset($_POST['firstname'])) {
    $result = mysqli_query($mysqli, 'INSERT INTO contacts (FIRSTNAME, LASTNAME, EMAIL, PHONE, ROLE, COMPANY, CONFIDENTIAL) VALUES("' . $_POST['firstname'] . '", "' . $_POST['lastname'] . '", "' . $_POST['email'] . '", "' . $_POST['phone'] . '", "' . $_POST['role'] . '", "' . $_POST['company'] . '", "' . $_POST['confidential'] . '")');
    addToLog($_SESSION['USERID'], 'new', 'contacts', '', '', 'LASTNAME', $_POST['firstname'] . " " . $_POST['lastname'], 'Added new contact: ' . $_POST['firstname'] . " " . $_POST['lastname']);

    echo 'INSERT INTO contacts (FIRSTNAME, LASTNAME, EMAIL, PHONE, ROLE, COMPANY) VALUES("' . $_POST['firstname'] . '", "' . $_POST['lastname'] . '", "' . $_POST['email'] . '", "' . $_POST['phone'] . '", "' . $_POST['role'] . '", "' . $_POST['company'] . '")';
}
?>