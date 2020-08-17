<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');

if (!isset($_GET['contactid'])) {
    echo 'No contact ID found';
    die;
}

$query = mysqli_query($mysqli, "SELECT * FROM contacts WHERE CONTACTID = '" . $_GET['contactid'] . "' LIMIT 0, 1");


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
                    <a class="changefield" href="#" data-type="text" data-pk="{id:<?php echo $_GET['contactid']; ?>,page:'contacts'}" data-name="PHONE"><?php echo $rowresults['PHONE']; ?></a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Email</label><br>
                    <a class="changefield" href="#" data-type="text" data-pk="{id:<?php echo $_GET['contactid']; ?>,page:'contacts'}" data-name="EMAIL"><?php echo $rowresults['EMAIL']; ?></a>
                </div>
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
        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                                onclick="javascript:$('#custom-modal').modal('hide');">Close</button>
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

</script>

