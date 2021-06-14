<?php
session_start();
error_reporting(E_ALL);
include ('../../modules/sql.php');

/*
offer: offer, OFFER RENAME INFOSHEET
guarantee: guarantee, RENAME GUARANTEE
hotel: hotel, CREATE HOTELCOST
buyouthotelcheck: buyouthotelcheck, CREATEHOTELBUYOUT
hotelnotes: hotelnotes, HOTEL
groundtransportation: groundtransportation, CREATE TRANSPORTATIONCOST
buyoutgroundcheck: buyoutgroundcheck, CREATE TRANSPORTATIONBUYOUT
groundnotes: groundnotes, CREATE TRANSPORTATIONNOTES
hospitality: hospitality, HOSPITALITYCOST
buyouthospitalitycheck: buyouthospitalitycheck, HOSPITALITYBUYOUT
hospitalitynotes: hospitalitynotes, HOSPITALITYNOTES
setduration: setduration SETDURATIONMINUMUM
 */
var_dump($_POST);
if (isset($_GET['showid'])) {
    mysqli_query($mysqli, "UPDATE shows_fields SET PERFORMANCEFEE = '" . $_POST['guarantee'] . "', HOTEL =  WHERE SHOWID = " . $_GET['showid']);

}
?>


