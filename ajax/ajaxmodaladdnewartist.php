<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>
<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <form>
                <div class="form-group">
                    <label for="name">Artist Name</label>
                    <input type="text" class="form-control" id="artistName" placeholder="Enter artist name">
                </div>

                <div class="text-right">
                    <button type="button" class="btn btn-success waves-effect waves-light" onclick="javscript:addArtist();">Add</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                            onclick="javascript:$('#custom-modal').modal('hide');">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
    function addArtist() {
        var artistName = $("#artistName").val();
        if (artistName == "") {
            alert("Please enter a name");
        } else {
            $.ajax({
                type: "POST",
                data: { 'artistname': artistName },
                url: 'ajax/addartist.php',
                context: document.body
            }).done(function(response) {
                alert("Artist added!");
                location.reload();
            }).fail(function() {
                alert( "Error" );
            });
        }
    }
</script>