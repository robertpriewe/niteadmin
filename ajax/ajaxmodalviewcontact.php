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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- Plugins css-->

    <link href="../assets/libs/x-editable/bootstrap-editable.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />


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
                                onclick="Custombox.modal.close();">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end card-box -->



<!-- Vendor js -->
<script src="../assets/js/vendor.min.js"></script>

<!-- Plugins Js -->
<script src="../assets/libs/select2/select2.min.js"></script>
<script src="../assets/libs/bootstrap-select/bootstrap-select.min.js"></script>

<script src="../assets/libs/x-editable/bootstrap-editable.min.js"></script>


<!-- App js -->
<script src="../assets/js/app.min.js"></script>


<script type="text/javascript">
$(document).ready(function () {
    $(".select2").select2({
        maximumSelectionLength: 2
    });

    $.fn.editable.defaults.mode = 'inline';
    $.fn.combodate.defaults.maxYear = <?php echo date("Y") + 2; ?>;
    $.fn.combodate.defaults.minYear = <?php echo date("Y") - 1; ?>;

    $('.changefield').editable({
        url: 'ajax/updateshowfield.php?page=contacts',
        disabled: true
    });


});

function clickEdit() {
    $('.changefield').editable('toggleDisabled');
}


$(function(){$.fn.editableform.buttons='<button type="submit" class="btn btn-primary editable-submit btn-sm waves-effect waves-light"><i class="mdi mdi-check"></i></button><button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect"><i class="mdi mdi-close"></i></button>',$("#inline-username").editable({type:"text",pk:1,name:"username",title:"Enter username",mode:"inline",inputclass:"form-control-sm"}),$("#inline-firstname").editable({validate:function(e){if(""==$.trim(e))return"This field is required"},mode:"inline",inputclass:"form-control-sm"}),$("#inline-sex").editable({prepend:"not selected",mode:"inline",inputclass:"form-control-sm",source:[{value:1,text:"Male"},{value:2,text:"Female"}],display:function(t,e){var n=$.grep(e,function(e){return e.value==t});n.length?$(this).text(n[0].text).css("color",{"":"gray",1:"green",2:"blue"}[t]):$(this).empty()}}),$("#inline-group").editable({showbuttons:!1,mode:"inline",inputclass:"form-control-sm"}),$("#inline-status").editable({mode:"inline",inputclass:"form-control-sm"}),$("#inline-dob").editable({mode:"inline",inputclass:"form-control-sm"}),$("#inline-event").editable({placement:"right",mode:"inline",combodate:{firstItem:"name"},inputclass:"form-control-sm"}),$("#inline-comments").editable({showbuttons:"bottom",mode:"inline",inputclass:"form-control-sm"}),$("#inline-fruits").editable({pk:1,limit:3,mode:"inline",inputclass:"form-control-sm",source:[{value:1,text:"Banana"},{value:2,text:"Peach"},{value:3,text:"Apple"},{value:4,text:"Watermelon"},{value:5,text:"Orange"}]})});

</script>

</body>
</html>