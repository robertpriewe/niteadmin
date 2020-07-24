<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');

/*
SELECT ARTISTNAME AS 'RESULT', 'ARTIST' AS 'TABLE' FROM artists WHERE ARTISTNAME LIKE '%nghtm%'
UNION ALL
SELECT EVENTNAME AS 'RESULT', 'EVENT' AS 'TABLE' FROM events WHERE EVENTNAME LIKE '%dead%'
UNION ALL
SELECT CONCAT(FIRSTNAME, ' ', LASTNAME, ' ', '(', ROLE, ')') AS RESULT, 'CONTACT' AS 'TABLE' FROM contacts WHERE CONCAT(FIRSTNAME, ' ', LASTNAME) LIKE '%Sam%'
UNION ALL
SELECT CONCAT(VENDORNAME, ' (', VENDORTYPE, ')') AS RESULT, 'VENDOR' AS 'TABLE' FROM vendors WHERE VENDORNAME LIKE '%Dri%'
UNION ALL
SELECT CONCAT(SPONSORNAME, ' (', SPONSORTYPE, ')') AS RESULT, 'SPONSOR' AS 'TABLE' FROM sponsors WHERE SPONSORNAME LIKE '%ban%'
 */


if (isset($_POST['query'])) {
    $searchterm = str_replace(" ", "%", $_POST['query']);
    $query = "SELECT ARTISTNAME AS 'RESULT', 'ARTIST' AS 'TABLE', ARTISTID AS 'ID', ARTISTPHOTO AS 'PHOTO' FROM artists WHERE ARTISTNAME LIKE '%" . $searchterm . "%'
UNION ALL
SELECT EVENTNAME AS 'RESULT', 'EVENT' AS 'TABLE', EVENTID AS 'ID', '' AS 'PHOTO' FROM events WHERE EVENTNAME LIKE '%" . $searchterm . "%'
UNION ALL
SELECT CONCAT(FIRSTNAME, ' ', LASTNAME, ' ', '(', ROLE, ')') AS RESULT, 'CONTACT' AS 'TABLE', CONTACTID AS 'ID', '' AS 'PHOTO' FROM contacts WHERE CONCAT(FIRSTNAME, ' ', LASTNAME) LIKE '%" . $searchterm . "%'
UNION ALL
SELECT CONCAT(VENDORNAME, ' (', VENDORTYPE, ')') AS RESULT, 'VENDOR' AS 'TABLE', VENDORID AS 'ID', '' AS 'PHOTO' FROM vendors WHERE VENDORNAME LIKE '%" . $searchterm . "%'
UNION ALL
SELECT CONCAT(SPONSORNAME, ' (', SPONSORTYPE, ')') AS RESULT, 'SPONSOR' AS 'TABLE', SPONSORID AS 'ID', '' AS 'PHOTO' FROM sponsors WHERE SPONSORNAME LIKE '%" . $searchterm . "%'
UNION ALL
SELECT CONCAT(VENUENAME, ' (', VENUETYPE, ')') AS RESULT, 'VENUE' AS 'TABLE', VENUEID AS 'ID', '' AS 'PHOTO' FROM venues WHERE VENUENAME LIKE '%" . $searchterm . "%'";
    $result = mysqli_query($mysqli, $query);
    $numberofrecords = $result->num_rows;
    if ($numberofrecords == 0) {
        echo '<a href="javascript:void(0);" class="dropdown-item notify-item">
            <div class="media">
                <div class="media-body">
                    <h5 class="m-0 font-14">Nothing found</h5>
                </div>
            </div>
        </a>';
    } else {
        echo '<div class="dropdown-header noti-title"><h5 class="text-overflow mb-2" id="searchTitle">Results found: ' . $numberofrecords . '</h5></div>';
        while ($row = $result->fetch_array()) {
            if ($row['TABLE'] == 'ARTIST') {
                $photo = $row['PHOTO'];
            } else {
                $photo = "assets/images/users/avatar-generic.png";
            }
            echo '<a href="?page=artistdetails&artistid=' . $row['ID'] . '" class="dropdown-item notify-item">
            <div class="media">
                <img class="d-flex mr-2 rounded-circle" src="' . $photo . '" alt="Generic placeholder image" width="32" height="32">
                <div class="media-body">
                    <h5 class="m-0 font-14">' . $row['RESULT'] . '</h5>
                    <span class="font-12 mb-0">' . $row['TABLE'] . '</span>
                </div>
            </div>
        </a>';
        }
    }
}