<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
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
        <div class="card-box">
            <div class="row">
                    <form>
                        <div class="form-group">
                            <label for="name">Event Name</label>
                            <input type="text" class="form-control" id="eventName" placeholder="Enter event name">
                        </div>
                        <div class="form-group">
                            <label for="venue">Venue</label>
                            <select class="form-control select2" id="venueName">
                                <option value="">Select</option>
                                <?php
                                $query = mysqli_query($mysqli, 'SELECT VENUENAME, VENUEID FROM venues ORDER BY VENUENAME ASC');
                                while($row = $query->fetch_array()) {
                                    echo '<option value="' . $row['VENUEID'] . '">' . $row['VENUENAME'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date"">Event Start Date</label>
                            <div class="input-group">
                                <input type="text" id="eventStartDate" class="form-control" data-provide="datepicker" data-date-autoclose="true">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date"">Event End Date</label>
                            <div class="input-group">
                                <input type="text" id="eventEndDate" class="form-control" data-provide="datepicker" data-date-autoclose="true">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="text-right">
                            <button type="button" class="btn btn-success waves-effect waves-light" onclick="javscript:addEvent();">Add</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                                    onclick="Custombox.modal.close();">Cancel</button>
                        </div>
                    </form>
            </div>
        </div>
    </div> <!-- end card-box -->

<script type="text/javascript">
    function addEvent() {
        var eventName = $("#eventName").val();
        var venueId = $("#venueName").val();
        var eventStartDate = $("#eventStartDate").val();
        var eventEndDate = $("#eventEndDate").val();
        if (eventName == "") {
            alert("Please enter a name");
        } else if (venueId == "") {
            alert("Please select a venue");
        } else if (eventStartDate == "") {
            alert("Please enter a start date");
        } else if (eventEndDate == "") {
            alert("Please enter end date");
        } else {
            $.ajax({
                type: "POST",
                data: {'eventname':eventName, 'venueid':venueId, 'startdate': eventStartDate, 'enddate': eventEndDate},
                url: 'ajax/addevent.php',
                context: document.body
            }).done(function(response) {
                alert(response);
                location.reload();
            }).fail(function() {
                alert( "Error" );
            });
        }
    }
</script>

    <!-- Vendor js -->
    <script src="../assets/js/vendor.min.js"></script>

    <!-- Plugins Js -->
    <script src="../assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="../assets/libs/switchery/switchery.min.js"></script>
    <script src="../assets/libs/multiselect/js/jquery.multi-select.js"></script>
    <script src="../assets/libs/jquery.quicksearch/jquery.quicksearch.min.js"></script>
    <script src="../assets/libs/select2/js/select2.min.js"></script>
    <script src="../assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="../assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="../assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>

    <!-- init js -->
    <script src="../assets/js/pages/form-advanced.init.js"></script>

    <!-- App js -->
    <script src="../assets/js/app.min.js"></script>

</body>
</html>