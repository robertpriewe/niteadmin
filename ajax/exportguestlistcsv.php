<?php
session_start();
error_reporting(E_ALL);
include('../modules/sql.php');


if (isset($_GET['eventid'])) {
    // output headers so that the file is downloaded rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Guestlist.csv');

// create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

// output the column headings
    fputcsv($output, array('FIRSTNAME', 'LASTNAME', 'EMAIL', 'ACCESSLEVEL', 'COUNT', 'NOTES'));


    $rows = mysqli_query($mysqli,"SELECT FIRSTNAME, LASTNAME, EMAIL, ACCESSLEVEL, COUNT(guestlist.ID) AS GUESTLISTCOUNT, NOTES FROM guestlist JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID WHERE EVENTID = '" . $_GET['eventid'] . "' GROUP BY GROUPHASH, ACCESSLEVEL ORDER BY FIRSTNAME, LASTNAME ASC");

// loop over the rows, outputting them
    while ($row = mysqli_fetch_assoc($rows)) fputcsv($output, $row);


}
