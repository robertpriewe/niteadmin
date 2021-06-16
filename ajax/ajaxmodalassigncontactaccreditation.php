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
                        <label for="contactName">Please select a contact for the show</label>
                        <select class="form-control select2" id="contactName">
                            <option value="">Select</option>
                            <?php
                            if ($_GET['fieldtype'] == 'events') {
                                $employeesearch = 'WHERE EMPLOYEE = 1';
                            } else {
                                $employeesearch = '';
                                $query = mysqli_query($mysqli, 'SELECT * FROM contacts_link JOIN contacts ON contacts_link.CONTACTID = contacts.CONTACTID WHERE LINKTABLE = "artists" AND LINKID = "' . $_GET['artistid'] . '" ORDER BY ORDERID ASC');
                                while($row = $query->fetch_array()) {
                                    echo '<option value="' . $row['CONTACTID'] . '">Team: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . ' (' . $row['ROLE'] . ' @ ' . $row['COMPANY'] . ')</option>';
                                }
                                echo '<option value="NA">N/A</option><option value="Artist">Artist</option><option value="">---</option>';
                            }

                            $query = mysqli_query($mysqli, 'SELECT * FROM contacts ' . $employeesearch . ' ORDER BY FIRSTNAME, LASTNAME ASC');
                            while($row = $query->fetch_array()) {
                                echo '<option value="' . $row['CONTACTID'] . '">' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . ' (' . $row['ROLE'] . ' @ ' . $row['COMPANY'] . ')</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-success waves-effect waves-light" onclick="javascript:addContactAccreditation();">Change</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="javascript:removeContactAccreditation();">Remove</button>
                        <button type="button" class="btn btn-dark waves-effect waves-light m-l-10" onclick="javascript:$('#custom-modal').modal('hide');">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
function addContactAccreditation() {
    var contactId = $("#contactName").val();
    if (contactId == "") {
        alert("Please select the person you contacted");
    } else {
        $.ajax({
            type: "POST",
            data: {'contactId': contactId},
            url: 'ajax/addcontactaccreditation.php?id=<?php echo $_GET['id']; ?>&fieldtype=<?php echo $_GET['fieldtype']; ?>&fieldname=<?php echo $_GET['fieldname']; ?>',
            context: document.body
        }).done(function(response) {
            location.reload();
        }).fail(function() {
            alert("Error");
        });
    }
}



function removeContactAccreditation() {
    $.ajax({
        type: "GET",
        url: 'ajax/removecontactaccreditation.php?id=<?php echo $_GET['id']; ?>&fieldtype=<?php echo $_GET['fieldtype']; ?>&fieldname=<?php echo $_GET['fieldname']; ?>',
        context: document.body
    }).done(function(response) {
        location.reload();
    }).fail(function() {
        alert("Error");
    });
}
</script>
