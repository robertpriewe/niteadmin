<?php
if (isset($_GET['eventid']) || isset($_GET['setid'])) {
    if (isset($_GET['eventid'])) {
        $query = mysqli_query($mysqli, "SELECT EVENTNAME, events.EVENTID AS EVENTIDSQL, VENUENAME, venues.VENUEID AS VENUEIDSQL FROM events LEFT JOIN shows ON shows.EVENTID = events.EVENTID LEFT JOIN stages ON shows.STAGEID = stages.STAGEID LEFT JOIN venues ON venues.VENUEID = stages.VENUEID WHERE events.EVENTID = " . $_GET['eventid'] . " GROUP BY venues.VENUENAME");
    } else {
        $query = mysqli_query($mysqli, "SELECT EVENTNAME, events.EVENTID AS EVENTIDSQL, VENUENAME, venues.VENUEID AS VENUEIDSQL, ARTISTNAME FROM shows LEFT JOIN events ON shows.EVENTID = events.EVENTID LEFT JOIN stages ON shows.STAGEID = stages.STAGEID LEFT JOIN venues ON venues.VENUEID = stages.VENUEID LEFT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID WHERE shows.SHOWID = " . $_GET['setid'] . " GROUP BY venues.VENUENAME");
    }
    while ($row = $query->fetch_assoc()) {
        $eventname = $row['EVENTNAME'];
        $eventid = $row['EVENTIDSQL'];
        $venuename = $row['VENUENAME'];
        $venueid = $row['VENUEIDSQL'];
        if (isset($_GET['setid'])) {
            $artistname = $row['ARTISTNAME'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Nite Admin - <?php include('content/components/getTitle.php'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nite Admin Venue Management & Nightlife System." name="description" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- third party css -->


    <link href="assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/x-editable/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css" />
    <!-- Custom box css -->
    <link href="assets/libs/custombox/custombox.min.css" rel="stylesheet">

    <!-- Plugin css -->
    <link href="assets/libs/@fullcalendar/core/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/@fullcalendar/daygrid/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/@fullcalendar/bootstrap/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/@fullcalendar/timegrid/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/@fullcalendar/list/main.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />


    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- icons -->

    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="" data-layout='{"sidebar": { "color": "dark", "size": "default", "showuser": false}, "topbar": {"color": "brand"} }'>

<!-- Begin page -->
<div id="wrapper">
