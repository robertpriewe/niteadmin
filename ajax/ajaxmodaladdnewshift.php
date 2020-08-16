<?php
session_start();
include ('../modules/sql.php');
if (!isset($_GET['eventid'])) {
    echo 'no eventid specified';
    die;
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group">
                    <label for="shiftname">Shift Name</label>
                    <input class="form-control" type="text" id="shiftname" required="" placeholder="">
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="example-time">Shift start</label>
                    <div class="row">
                        <div class="col-lg-6">
                            <input class="form-control" type="date" id="datestart">
                        </div>
                        <div class="col-lg-6">
                            <input class="form-control" type="time" id="timestart">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="example-time">Shift End</label>
                    <div class="row">
                        <div class="col-lg-6">
                            <input class="form-control" type="date" id="dateend">
                        </div>
                        <div class="col-lg-6">
                            <input class="form-control" type="time" id="timeend">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <button class="btn btn-primary" onclick="javascript:addShift();">Save</button>
                        </div>
                        <div class="col-lg-6">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
    $(document).ready(function () {
        $(".select2").select2({
            maximumSelectionLength: 2
        });
    });
    function disableKey() {
        document.onkeydown=function() {
            if (window.event.keyCode == '13') {
            }
        }
    }

    document.onkeydown=function(){
        if(window.event.keyCode=='13'){
            addShift();
        }
    }

    function addShift() {
        var datestart = $("#datestart").val();
        var timestart = $("#timestart").val();
        var dateend = $("#dateend").val();
        var timeend = $("#timeend").val();
        var shiftName = $("#shiftname").val();
        if (shiftName == "") {
            alert("Please enter a shift name");
        } else if (datestart == "") {
            alert("Please enter a start date");
        } else if (timestart == "") {
            alert("Please enter a start time");
        } else if (dateend == "") {
            alert("Please enter a end date");
        } else if (timeend == "") {
            alert("Please enter a end time");
        } else {
            $.ajax({
                type: "POST",
                data: { 'shiftname': shiftName, 'datestart': datestart, 'timestart': timestart, 'dateend': dateend, 'timeend': timeend },
                url: 'ajax/addeventshift.php?eventid=<?php echo $_GET['eventid']; ?>',
                context: document.body
            }).done(function(response) {
                alert("Shift added!");
                location.reload();
            }).fail(function() {
                alert( "Error" );
            });
        }
    }
</script>

