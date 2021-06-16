<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');

if (!isset($_GET['contactid'])) {
    echo 'No contact ID found';
    die;
}

$query = mysqli_query($mysqli, "SELECT * FROM contacts WHERE CONTACTID = '" . $_GET['contactid'] . "' LIMIT 0, 1");

include ('../content/components/getFieldConfidential.php');

while($row = $query->fetch_array()) {
    $rowresults = $row;
}
?>


<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <div class="col-sm-12 text-right">
                <button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="javascript:clickEdit();"><i class="mdi mdi-pencil"></i> Edit</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">First Name</label><br>
                    <a class="changefield" href="#" data-type="text" data-pk="{id:<?php echo $_GET['contactid']; ?>,page:'contacts'}" data-name="FIRSTNAME"><?php echo $rowresults['FIRSTNAME']; ?></a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Last Name</label><br>
                    <a class="changefield" href="#" data-type="text" data-pk="{id:<?php echo $_GET['contactid']; ?>,page:'contacts'}" data-name="LASTNAME"><?php echo $rowresults['LASTNAME']; ?></a>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Phone</label><br>
                    <?php echo getFieldConfidential('PHONE', $rowresults['PHONE'], $_GET['contactid'], $rowresults['CONFIDENTIAL']); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Email</label><br>
                    <?php echo getFieldConfidential('EMAIL', $rowresults['EMAIL'], $_GET['contactid'], $rowresults['CONFIDENTIAL']); ?></div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Company</label><br>
                    <a class="changefield" href="#" data-type="text" data-pk="{id:<?php echo $_GET['contactid']; ?>,page:'contacts'}" data-name="COMPANY"><?php echo $rowresults['COMPANY']; ?></a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Select Role</label><br>
                    <a class="changefield" href="#" data-type="text" data-pk="{id:<?php echo $_GET['contactid']; ?>,page:'contacts'}" data-name="ROLE"><?php echo $rowresults['ROLE']; ?></a>
                    <?php
                    /*
                        <select class="form-control select2" id="role">
                        <option value="">Select</option>
                        <option value="Manager">Manager</option>
                        <option value="Tour Manager">Tour Manager</option>
                        <option value="VJ">VJ</option>
                        <option value="Vendor">Vendor</option>
                        </select>
                     */
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="name">Notes</label><br>
                    <a class="changefield" href="#" data-type="textarea" data-pk="{id:<?php echo $_GET['contactid']; ?>,page:'contacts'}" data-name="CONTACTNOTES"><?php echo $rowresults['CONTACTNOTES']; ?></a>
                </div>
            </div>
        </div>

        <?php
        if (isset($_SESSION['ACCESS']['CONFIDENTIALCONTACT'])) {
            if ($rowresults['CONFIDENTIAL'] == "1") {
                $confidentialchecked = " CHECKED";
            } else {
                $confidentialchecked = "";
            }
            echo '<div class="row">
                <div class="col-sm-12">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" onclick="javascript:checkConfidential();"' . $confidentialchecked . '>
                        <label class="custom-control-label" for="customSwitch1">Make contact info confidential?</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    &nbsp;
                </div>
            </div>';
        }
        ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="javascript:$('#custom-modal').modal('hide');">Close</button>
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

    $('.changefield').editable({
        url: 'ajax/updateshowfield.php',
        disabled: true
    });
});

function checkConfidential() {
    if ($('#customSwitch1').prop('checked') == false) {
        var confidential = 0;
    } else {
        var confidential = 1;
    }
    $.ajax({
        type: "GET",
        url: 'ajax/changeconfidentialcontact.php?contactid=<?php echo $_GET['contactid']; ?>&confidential=' + confidential,
        context: document.body
    }).done(function(response) {
    }).fail(function() {
        alert( "Error" );
    });
}

</script>

<script src="../assets/js/app.min.js"></script>