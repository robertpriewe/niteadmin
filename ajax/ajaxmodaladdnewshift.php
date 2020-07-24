<?php
session_start();
include ('../modules/sql.php');
if (!isset($_GET['eventid'])) {
    echo 'no eventid specified';
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- Plugins css-->
    <link href="../assets/libs/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />


    <!-- App css -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

<br>
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

<!-- Vendor js -->
<script src="../assets/js/vendor.min.js"></script>

<!-- Plugins Js -->
<script src="../assets/libs/select2/js/select2.min.js"></script>
<script src="../assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="../assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="../assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>

<!-- init js -->
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
<!-- App js -->
<script src="../assets/js/app.min.js"></script>

</body>
</html>
