<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>
<div class="col-sm-12">
    <div class="card-box">
        <div class="row">
            <div class="col-sm-12">
            <form>

                <div class="form-group">
                    <label for="contactType">Type</label>
                    <select class="form-control select2" id="contactType">
                        <option value="">Select</option>
                        <option value="E-Mail">E-Mail</option>
                        <option value="Phone Call">Phone Call</option>
                        <option value="Message">Message</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="activityDetails">Activity Details</label>
                    <textarea class="form-control" id="activityDetails" placeholder="Enter details"></textarea>
                </div>
                <div class="form-group">
                    <label for="contactName">Name Contacted</label>
                    <select class="form-control select2" id="contactName">
                        <option value="">Select</option>
                        <?php
                        $query = mysqli_query($mysqli, 'SELECT * FROM contacts_link JOIN contacts ON contacts_link.CONTACTID = contacts.CONTACTID WHERE LINKTABLE = "artists" AND LINKID = "' . $_GET['artistid'] . '" ORDER BY ORDERID ASC');
                        while($row = $query->fetch_array()) {
                            echo '<option value="' . $row['CONTACTID'] . '">Team: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . ' (' . $row['ROLE'] . ' @ ' . $row['COMPANY'] . ')</option>';
                        }
                        echo '<option value="NA">N/A</option><option value="Artist">Artist</option><option value="">---</option>';
                        $query = mysqli_query($mysqli, 'SELECT * FROM contacts ORDER BY FIRSTNAME, LASTNAME ASC');
                        while($row = $query->fetch_array()) {
                            echo '<option value="' . $row['CONTACTID'] . '">' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . ' (' . $row['ROLE'] . ' @ ' . $row['COMPANY'] . ')</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="contactDate"">Contacted Date</label>
                    <div class="input-group">
                        <input type="text" id="contactDate" class="form-control" data-provide="datepicker" data-date-autoclose="true">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contactTime"">Contacted Time</label>
                    <div class="input-group clockpicker" data-autoclose="true">
                        <input type="text" id="contactTime" class="form-control">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selectUpcomingEvents">Event Contacted About</label>
                    <?php include('../content/components/selectupcomingevents.php'); ?>
                </div>


                <br>
                <div class="text-right">
                    <button type="button" class="btn btn-success waves-effect waves-light" onclick="javscript:addContactActivity();">Add</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="javascript:$('#custom-modal').modal('hide');">Cancel</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
    function addContactActivity() {
        var activityDetails = $("#activityDetails").val();
        var contactType = $("#contactType").val();
        var contactId = $("#contactName").val();
        var contactDate = $("#contactDate").val();
        var contactTime = $("#contactTime").val();
        var selectUpcomingEvents = $("#selectUpcomingEvents").val();
        if (activityDetails == "") {
            alert("Please enter a activity description");
        } else if (contactType == "") {
            alert("Please select a activity type");
        } else if (contactId == "") {
            alert("Please select the person you contacted");
        } else if (contactDate == "") {
            alert("Please select a date");
        } else if (contactTime == "") {
            alert("Please select the time");
        } else {
            $.ajax({
                type: "POST",
                data: {'activityDetails':activityDetails, 'contactType':contactType, 'contactId': contactId, 'contactDate': contactDate, 'contactTime': contactTime, 'eventid': selectUpcomingEvents},
                url: 'ajax/addcontactactivity.php?artistid=<?php echo $_GET['artistid']; ?>',
                context: document.body
            }).done(function(response) {
                alert('Done');
                location.reload();
            }).fail(function() {
                alert("Error");
            });
        }
    }

    $(document).ready(function() {
        $(".clockpicker").clockpicker({
            donetext: "Done"
        });
    });


</script>
