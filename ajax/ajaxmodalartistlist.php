<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>
<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <h6>Select Artist</h6>
            <select class="form-control select2">
                <option>Select</option>
                <?php
                $query = mysqli_query($mysqli, 'SELECT ARTISTNAME, ARTISTID FROM artists ORDER BY ARTISTNAME ASC');
                while($row = $query->fetch_array()) {
                    echo '<option value="' . $row['ARTISTID'] . '">' . $row['ARTISTNAME'] . '</option>';
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
        var artistid = $('.select2').val();
        $.ajax({
            type: "GET",
            url: 'ajax/assignartist.php?eventid=<?php echo $_GET['eventid']; ?>&artistid=' + artistid,
            context: document.body
        }).done(function(response) {
            alert("Artist added to event");
            location.reload();
        }).fail(function() {
            alert("Error");
        });
    }

</script>

