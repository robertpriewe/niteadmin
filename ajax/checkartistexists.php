<?php
session_start();
include ('../modules/sql.php');

if(isset($_POST['newArtistName'])) {
    $result = mysqli_query($mysqli, "SELECT ARTISTID FROM artists WHERE LOWER(ARTISTNAME) = '" . strtolower($_POST['newArtistName']) . "' LIMIT 0, 1");
    if ($result->num_rows != 0) {
        while($row = $result->fetch_array()) {
            echo $row['ARTISTID'];
        }
    } else {
        echo "new";
    }
}