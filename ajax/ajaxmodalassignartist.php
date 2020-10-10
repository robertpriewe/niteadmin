<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>
<div class="col-lg-12">
    <div class="card-box">
        <div class="row" id="divSelectArtist">
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
        </div>
        <div class="row">Artist not found? <a href="javascript:toggleArtists();"> Click to create</a></div>
        <div class="row" style="display:none;" id="divNewArtist">
            <h6>Add new artist</h6><input type="text" class="form-control" id="newArtistName">
        </div>
        <br>
        <div class="row">
            <button class="btn btn-success" onclick="javascript:assignToEvent();">Add to event</button>
        </div>
    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
    function assignToEvent() {
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

    function toggleArtists() {
        alert($('#divSelectArtist').is(":visible"));
        $('#divSelectArtist').slideToggle();
        $('#divNewArtist').slideToggle();
    }
</script>

