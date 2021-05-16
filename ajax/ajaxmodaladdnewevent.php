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
                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date"">Event End Date</label>
                            <div class="input-group">
                                <input type="text" id="eventEndDate" class="form-control" data-provide="datepicker" data-date-autoclose="true">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
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
        var eventStatus = $("#eventStatus").val();
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
                data: {'eventname':eventName, 'venueid':venueId, 'startdate': formatDate(eventStartDate), 'enddate': formatDate(eventEndDate), 'eventstatus': eventStatus},
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
