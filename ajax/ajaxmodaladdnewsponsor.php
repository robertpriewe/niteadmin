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
                    <label for="name">Sponsor Name</label>
                    <input type="text" class="form-control" id="sponsorname" placeholder="Enter sponsor name">
                </div>
                <div class="form-group">
                    <label for="name">Select Sponsor type</label>
                    <select class="form-control select2" id="sponsortype">
                        <option value="">Select</option>
                        <option value="Corporation">Corporation</option>
                        <option value="Non-Profit">Non-Profit</option>
                        <option value="City">City</option>
                    </select>
                </div>

                <div class="text-right">
                    <button type="button" class="btn btn-success waves-effect waves-light" onclick="javscript:addSponsor();">Add</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                            onclick="Custombox.modal.close();javascript:disableKey();">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
    function disableKey() {
        document.onkeydown=function() {
            if (window.event.keyCode == '13') {
            }
        }
    }

    document.onkeydown=function(){
        if(window.event.keyCode=='13'){
            addSponsor();
        }
    }


    function addSponsor() {
        var sponsorname = $("#sponsorname").val();
        var sponsortype = $("#sponsortype").val();
        if (sponsorname == "") {
            alert("Please enter a name");
        } else if (sponsortype == "") {
            alert("Please select a sponsor type")
        } else {
            $.ajax({
                type: "POST",
                data: { 'sponsorname': sponsorname, 'sponsortype': sponsortype },
                url: 'ajax/addsponsor.php',
                context: document.body
            }).done(function(response) {
                alert("Sponsor added!");
                location.reload();
            }).fail(function() {
                alert( "Error" );
            });
        }
    }
</script>
