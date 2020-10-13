<?php
/*
$host = 'localhost';
$username = 'youtubed_crmuser';
$password = 'crmuser';
$db_name = 'youtubed_crm';


$con = mysql_connect("$host","$username","$password");
if (!$con)  {   die($sqlerror . mysql_error());   }
mysql_select_db("$db_name", $con);

*/
$mysqli = mysqli_connect("localhost", "root", "root", "crm");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$urlinstall = 'http://localhost:8888';
$urlexternal = 'http://localhost:8888/guestlist_minisite/';
$urlticketallocation = 'http://localhost:8888/ticketalloc/';
$clientname = 'SomePromoter';
$clientemail = 'admin@niteadmin.com';
?>