<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>
<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <h6>Select Event to Export</h6>
            <select class="form-control select2">
                <option>Select</option>
                <?php
                $query = mysqli_query($mysqli, "SELECT * FROM events WHERE STR_TO_DATE(EVENTSTARTDATE,'%m/%d/%Y') > NOW() ORDER BY EVENTSTARTDATE ASC");
                while($row = $query->fetch_array()) {
                    echo '<option value="' . $row['EVENTID'] . '">' . $row['EVENTNAME'] . ' (' . $row['EVENTSTARTDATE'] . ')</option>';
                }
                ?>
            </select>
        </div><br>
        <div class="row">
            <button class="btn btn-success" onclick="javascript:runQuery();">Export to CSV</button>
        </div>
    </div>
</div> <!-- end card-box -->
<iframe id="divresult" style="display:none;"></iframe>
<script type="text/javascript">
    function runQuery() {
        var eventid = $('.select2').val();
        $('#divresult').attr('src', 'ajax/exportguestlistcsv.php?eventid=' + eventid);
    }
    function runQuery2() {
        var eventid = $('.select2').val();
        $.ajax({
            type: "GET",
            url: 'ajax/exportguestlistcsv.php?eventid=' + eventid,
            context: document.body
        }).done(function(response) {
            $('#divresult').html(response);
        }).fail(function() {
            alert("Error");
        });
    }
</script>

