<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
error_log('addingvenue..
    ', 3, 'log.txt');

if (isset($_POST['firstname'])) {
    $result = mysqli_query($mysqli, 'INSERT INTO contacts (FIRSTNAME, LASTNAME, EMAIL, PHONE, ROLE, COMPANY) VALUES("' . $_POST['firstname'] . '", "' . $_POST['lastname'] . '", "' . $_POST['email'] . '", "' . $_POST['phone'] . '", "' . $_POST['role'] . '", "' . $_POST['company'] . '")');
    echo 'INSERT INTO contacts (FIRSTNAME, LASTNAME, EMAIL, PHONE, ROLE, COMPANY) VALUES("' . $_POST['firstname'] . '", "' . $_POST['lastname'] . '", "' . $_POST['email'] . '", "' . $_POST['phone'] . '", "' . $_POST['role'] . '", "' . $_POST['company'] . '")';
}
?>