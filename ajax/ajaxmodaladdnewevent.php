<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>
<link rel="stylesheet" href="../assets/libs/bootstrap-clockpicker/bootstrap4-clockpicker.min.css">

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
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <input type="text" id="eventStartDate" class="form-control" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group clockpicker1">
                                        <input class="form-control" type="text" placeholder="" id="eventStartTime">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="ri-time-fill"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date"">Event Start Date</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <input type="text" id="eventEndDate" class="form-control" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group clockpicker2">
                                        <input class="form-control" type="text" placeholder="" id="eventEndTime">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="ri-time-fill"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="venue">Event Status</label>
                            <select class="form-control select2" id="eventStatus">
                                <option value="Confirmed">Confirmed</option>
                                <option value="Pending">Pending</option>
                                <option value="Hold">Hold</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>




                        <br>
                        <div class="text-right">
                            <button type="button" class="btn btn-success waves-effect waves-light" onclick="javscript:addEvent();">Add</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                                    onclick="javascript:$('#custom-modal').modal('hide');">Cancel</button>
                        </div>
                    </form>
            </div>
        </div>
    </div> <!-- end card-box -->

<script type="text/javascript">
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }


    function addEvent() {
        var eventName = $("#eventName").val();
        var venueId = $("#venueName").val();
        var eventStartDate = $("#eventStartDate").val();
        var eventEndDate = $("#eventEndDate").val();
        var eventStartTime = $("#eventStartTime").val();
        var eventEndTime = $("#eventEndTime").val();
        var eventStatus = $("#eventStatus").val();



        if (eventName == "") {
            alert("Please enter a name");
        } else if (venueId == "") {
            alert("Please select a venue");
        } else if (eventStartDate == "") {
            alert("Please enter a start date");
        } else if (eventEndDate == "") {
            alert("Please enter end date");
        } else if (eventStartTime == "") {
            alert("Please enter end date");
        } else if (eventEndTime == "") {
            alert("Please enter end date");
        } else {
            var fullEventStart = moment(eventStartDate, ["MM:DD:YYYY"]).format("YYYY-MM-DD") + ' ' + moment(eventStartTime, ["h:mmA"]).format("HH:mm") + ':00';
            var fullEventEnd = moment(eventEndDate, ["MM:DD:YYYY"]).format("YYYY-MM-DD") + ' ' + moment(eventEndTime, ["h:mmA"]).format("HH:mm") + ':00';


            $.ajax({
                type: "POST",
                data: {'eventname':eventName, 'venueid':venueId, 'startdate': fullEventStart, 'enddate': fullEventEnd, 'eventstatus': eventStatus},
                url: 'ajax/addevent.php',
                context: document.body
            }).done(function(response) {
                alert('Event added');
                location.reload();
            }).fail(function() {
                alert( "Error" );
            });
        }
    }

    $(document).ready(function() {
        $('.clockpicker1').clockpicker({
            'default': 'now',
            vibrate: true,
            placement: "top",
            align: "left",
            autoclose: true,
            twelvehour: true
        });
        $('.clockpicker2').clockpicker({
            'default': 'now',
            vibrate: true,
            placement: "top",
            align: "left",
            autoclose: true,
            twelvehour: true
        });
    });

    function timeConversion(s) {
        let output = '';
        const timeSeparator = ':'
        const timeTokenType = s.substr(s.length - 2 , 2).toLowerCase();
        const timeArr = s.split(timeSeparator).map((timeToken) => {
            const isTimeTokenType =
                timeToken.toLowerCase().indexOf('am') > 0 ||
                timeToken.toLowerCase().indexOf('pm');
            if(isTimeTokenType){
                return timeToken.substr(0, 2);
            } else {
                return timeToken;
            }
        });
        const hour = timeArr[0];
        const minutes = timeArr[1];
        const seconds = timeArr[2];
        const hourIn24 = (timeTokenType === 'am') ? parseInt(hour) - 12 :
            parseInt(hour) + 12;
        return hourIn24.toString()+ timeSeparator + minutes + timeSeparator + seconds;
    }
</script>


<script src="../assets/libs/bootstrap-clockpicker/bootstrap4-clockpicker.min.js">
