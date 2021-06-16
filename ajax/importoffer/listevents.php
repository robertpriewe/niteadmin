<?php
session_start();
error_reporting(E_ALL);
include ('../../modules/sql.php');
?>
<h6>Select Event</h6>
<select class="form-control select2" id="selectEventAjax">
    <option>Select</option>
    <?php
        $query = mysqli_query($mysqli, 'SELECT EVENTNAME, events.EVENTID AS EVENTID, EVENTSTARTDATE, VENUENAME FROM shows JOIN events ON shows.EVENTID = events.EVENTID JOIN stages ON shows.STAGEID = stages.STAGEID JOIN venues ON stages.VENUEID = venues.VENUEID WHERE EVENTSTARTDATE > NOW() GROUP BY events.EVENTID ORDER BY EVENTSTARTDATE ASC');
    while($row = $query->fetch_array()) {
        echo '<option value="' . $row['EVENTID'] . '">' . $row['EVENTNAME'] . ' @ ' . $row['VENUENAME'] . ' (' . date("D, m/d/Y, ga", strtotime($row['EVENTSTARTDATE'])) . ')</option>';
    }
    ?>
</select>