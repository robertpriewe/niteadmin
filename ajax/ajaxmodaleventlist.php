<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>

<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <h6>Select Upcoming Event</h6>
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
            <button class="btn btn-success" onclick="javascript:runQuery();">Assign to event</button>
        </div>
    </div>
</div> <!-- end card-box -->

<?php
$getvars = "";
foreach($_GET as $key => $value) {
    $getvars .= '&' . $key . '=' . $value;
}
if (isset($_GET['artistid'])) {
    $targeturl = 'assignartist.php';
} elseif (isset($_GET['vendorid'])) {
    $targeturl = 'assigneventvendor.php';
} elseif (isset($_GET['sponsorid'])) {
    $targeturl = 'assigneventsponsor.php';
}
?>

<script type="text/javascript">
    function runQuery() {
        var eventid = $('.select2').val();
        $.ajax({
            type: "GET",
            url: 'ajax/<?php echo $targeturl; ?>?eventid=' + eventid + '<?php echo $getvars; ?>',
            context: document.body
        }).done(function(response) {
            alert(response);
            location.reload();
        }).fail(function() {
            alert("Error");
        });
    }
</script>
