<?php
session_start();
error_reporting(E_ALL);
include ('../../modules/sql.php');
?>
<h6>Select Event</h6>
<select class="form-control select2" id="selectEventAjax">
    <option>Select</option>
    <?php
    $query = mysqli_query($mysqli, 'SELECT EVENTNAME, EVENTID, EVENTSTARTDATE FROM events WHERE EVENTSTARTDATE > NOW() ORDER BY EVENTSTARTDATE ASC');
    while($row = $query->fetch_array()) {
        echo '<option value="' . $row['EVENTID'] . '">' . $row['EVENTNAME'] . ' (' . $row['EVENTSTARTDATE'] . ')</option>';
    }
    ?>
</select>