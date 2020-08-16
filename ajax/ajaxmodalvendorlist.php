<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>

<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <h6>Select Vendor</h6>
            <select class="form-control select2">
                <option>Select</option>
                <?php
                $query = mysqli_query($mysqli, 'SELECT * FROM vendors ORDER BY VENDORNAME, VENDORTYPE ASC');
                while($row = $query->fetch_array()) {
                    echo '<option value="' . $row['VENDORID'] . '">' . $row['VENDORNAME'] . ' (' . $row['VENDORTYPE'] . ')</option>';
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
        var vendorid = $('.select2').val();
        $.ajax({
            type: "GET",
            url: 'ajax/assigneventvendor.php?eventid=<?php echo $_GET['eventid']; ?>&vendorid=' + vendorid,
            context: document.body
        }).done(function(response) {
            alert("Vendor added to event");
            location.reload();
        }).fail(function() {
            alert("Error");
        });
    }

</script>

