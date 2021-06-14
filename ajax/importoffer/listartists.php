<?php
session_start();
error_reporting(E_ALL);
include ('../../modules/sql.php');
?>


<h6>Select Artist</h6>
<select class="form-control select2" id="selectArtistsAjax">
    <option>Select</option>
    <?php
    $query = mysqli_query($mysqli, 'SELECT ARTISTNAME, ARTISTID FROM artists ORDER BY ARTISTNAME ASC');
    while($row = $query->fetch_array()) {
        echo '<option value="' . $row['ARTISTID'] . '">' . $row['ARTISTNAME'] . '</option>';
    }
    ?>
</select>