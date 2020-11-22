<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
include ('addtolog.php');
error_log('assigningartist..
    ', 3, 'log.txt');


if (isset($_GET['eventid']) && isset($_GET['showid'])) {
    if (!isset($_GET['b2bid'])) {
        $result = mysqli_query($mysqli, "SELECT * FROM shows_b2b ORDER BY B2BID DESC LIMIT 0, 1");
        while ($row = $result->fetch_array()) {
            $B2BID = $row['B2BID'] + 1;
        }
        //b2bid, showid, eventid

        $result = mysqli_query($mysqli, 'INSERT INTO shows_b2b (B2BID, B2BEVENTID, B2BSETID, B2BMAIN) VALUES ("' . $B2BID . '", "' . $_GET['eventid'] . '", "' . $_GET['showidmain'] . '", "1")');
        $result = mysqli_query($mysqli, 'INSERT INTO shows_b2b (B2BID, B2BEVENTID, B2BSETID) VALUES ("' . $B2BID . '", "' . $_GET['eventid'] . '", "' . $_GET['showid'] . '")');

        echo 'INSERT INTO shows_b2b (B2BEVENTID, B2BSETID, B2BMAIN) VALUES ("' . $_GET['eventid'] . '", "' . $_GET['showidmain'] . '", "1")';
    } else {
        $result = mysqli_query($mysqli, 'INSERT INTO shows_b2b (B2BID, B2BEVENTID, B2BSETID) VALUES ("' . $_GET['b2bid'] . '", "' . $_GET['eventid'] . '", "' . $_GET['showid'] . '")');
    }
    addToLog($_SESSION['USERID'], 'assign', 'b2bid', '', '', '', '', 'Edited b2b set for show ' . $_GET['showid']);

}
?>