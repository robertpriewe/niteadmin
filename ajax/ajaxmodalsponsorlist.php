<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>


<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <h6>Select Sponsor</h6>
            <select class="form-control select2">
                <option>Select</option>
                <?php
                $query = mysqli_query($mysqli, 'SELECT * FROM sponsors ORDER BY SPONSORNAME, SPONSORTYPE ASC');
                while($row = $query->fetch_array()) {
                    echo '<option value="' . $row['SPONSORID'] . '">' . $row['SPONSORNAME'] . ' (' . $row['SPONSORTYPE'] . ')</option>';
                }
                ?>
            </select>
        </div><br>
        <div class="row">
            <button class="btn btn-success" onclick="javascript:runQuery();">Add to event</button>
        </div>
    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
    function runQuery() {
        var sponsorid = $('.select2').val();
        $.ajax({
            type: "GET",
            url: 'ajax/assigneventsponsor.php?eventid=<?php echo $_GET['eventid']; ?>&sponsorid=' + sponsorid,
            context: document.body
        }).done(function(response) {
            alert("Sponsor added to event");
            location.reload();
        }).fail(function() {
            alert("Error");
        });
    }

</script>

