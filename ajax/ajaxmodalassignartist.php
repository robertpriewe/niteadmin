<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>
<div class="col-lg-12">
    <div class="card-box">
        <div class="row" id="divSelectArtist">
            <h6>Select Artist</h6>
            <select class="form-control select2" id="selectArtists">
                <option>Select</option>
                <?php
                $query = mysqli_query($mysqli, 'SELECT ARTISTNAME, ARTISTID FROM artists ORDER BY ARTISTNAME ASC');
                while($row = $query->fetch_array()) {
                    echo '<option value="' . $row['ARTISTID'] . '">' . $row['ARTISTNAME'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="row" style="display:none;" id="divNewArtist">
            <h6>Add new artist</h6><input type="text" class="form-control" id="newArtistName">
        </div>
        <div class="row"><a href="javascript:toggleArtists();" id="artistText">Artist not found? Click to create</a></div>
        <br>
        <div class="row">
            <button class="btn btn-success" onclick="javascript:checkArtist();">Add to event</button>
        </div>
    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
    function checkArtist() {
        if (displayList == "newArtist") {
            var newArtistName = $('#newArtistName').val();
            if (newArtistName == "") {
                alert ("Please type in a new artist name");
            } else {
                $.ajax({
                    type: "POST",
                    data: {newArtistName: newArtistName},
                    url: 'ajax/checkartistexists.php',
                    context: document.body
                }).done(function (response) {
                    artistStatus = response;
                    if (artistStatus == "new") {
                        addNewArtist(newArtistName)
                    } else {
                        alert('Artist ' + newArtistName + ' already exists, please select from dropdown!');
                        toggleArtists();
                        $('#selectArtists').val(artistStatus); // Select the option with a value of '1'
                        $('#selectArtists').trigger('change'); // Notify any JS components that the value changed
                    }
                }).fail(function () {
                    alert("Error");
                });
            }
        } else {
            assignToEvent("");
        }
    }

    function addNewArtist(newArtistName) {
        $.ajax({
            type: "POST",
            data: {artistname: newArtistName},
            url: 'ajax/addartist.php',
            context: document.body
        }).done(function (response) {
            artistid = response;
            if (artistid != "") {
                assignToEvent(artistid);
            } else {
                alert('Error generating artistid');
            }
        }).fail(function () {
            alert("Error");
        });
    }

    function assignToEvent(artistidFunct) {
        if (artistidFunct != "") {
            var artistid = artistidFunct;
        } else {
            var artistid = $('.select2').val();
        }
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

    var displayList = "artistList"
    function toggleArtists() {
        $('#divSelectArtist').slideToggle();
        $('#divNewArtist').slideToggle(function(){
            if ($('#divNewArtist').is(":visible") == true) {
                $('#artistText').html("Pick existing artist from list");
                displayList = "newArtist";
            } else {
                $('#artistText').html("Artist not found? Click to create");
                displayList = "artistList";
            }
        });
    }
</script>

