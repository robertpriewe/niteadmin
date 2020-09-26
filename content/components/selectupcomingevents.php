<select class="form-control select2" id="selectUpcomingEvents">
    <option>Select</option>
    <?php
    $query = mysqli_query($mysqli, "SELECT * FROM events LEFT JOIN shows ON shows.EVENTID = events.EVENTID LEFT JOIN stages ON shows.STAGEID = stages.STAGEID LEFT JOIN venues ON stages.VENUEID = venues.VENUEID WHERE STR_TO_DATE(EVENTSTARTDATE,'%m/%d/%Y') > NOW() GROUP BY EVENTNAME ORDER BY EVENTSTARTDATE ASC");
    while($row = $query->fetch_array()) {
        echo '<option value="' . $row['EVENTID'] . '">' . $row['EVENTNAME'] . ' @ ' . $row['VENUENAME'] . ' (' . $row['EVENTSTARTDATE'] . ')</option>';
    }
    ?>
</select>