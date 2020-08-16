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
                    <label for="name">Venue Name</label>
                    <input type="text" class="form-control" id="venueName" placeholder="Enter venue name">
                </div>

                <div class="text-right">
                    <button type="button" class="btn btn-success waves-effect waves-light" onclick="javscript:addVenue();">Add</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                            onclick="Custombox.modal.close();">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
    function addVenue() {
        var venueName = $("#venueName").val();
        if (venueName == "") {
            alert("Please enter a name");
        } else {
            $.ajax({
                type: "POST",
                data: { 'venuename': venueName },
                url: 'ajax/addvenue.php',
                context: document.body
            }).done(function(response) {
                alert("Venue added!");
            }).fail(function() {
                alert( "Error" );
            });
        }
    }
</script>