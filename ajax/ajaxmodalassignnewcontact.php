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
    <link href="../assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="../assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/multiselect/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
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
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="name">Select Contact (use search bar)</label>
                    <select class="form-control select2" id="contactid">
                        <option value="">Select</option>
                        <?php
                        $query = mysqli_query($mysqli, 'SELECT * FROM contacts WHERE CONTACTID <> 0 ORDER BY FIRSTNAME, LASTNAME ASC');
                        while($row = $query->fetch_array()) {
                            echo '<option value="' . $row['CONTACTID'] . '">' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . ' (' . $row['ROLE'] . ' @ ' . $row['COMPANY'] . ')</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="text-right">
                    <div class="form-group">
                        <button type="button" class="btn btn-success waves-effect waves-light" type="submit" onclick="javascript:assignContact();">Assign</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                                onclick="Custombox.modal.close();javascript:disableKey();">Cancel</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end card-box -->
<?php
if (isset($_GET['action'])) {
    if ($_GET['action'] == "change") {
        $action = "&action=change";
    }
} else {
    $action = "";
}

if (isset($_GET['artistid'])) {
    $query = '&artistid=' . $_GET['artistid'];
} elseif (isset($_GET['vendorid'])) {
    $query = '&vendorid=' . $_GET['vendorid'];
} elseif (isset($_GET['venueid'])) {
    $query = '&venueid=' . $_GET['venueid'];
}
?>

<script type="text/javascript">
    function disableKey() {
        document.onkeydown=function() {
            if (window.event.keyCode == '13') {
            }
        }
    }

    document.onkeydown=function(){
        if(window.event.keyCode=='13'){
            assignContact();
        }
    }

    function assignContact() {
        var contactid = $("#contactid").val();
        if (contactid == "") {
            alert("Please select a contact");
        }
        else {
            $.ajax({
                type: "GET",
                url: 'ajax/assigncontact.php?contactid=' + contactid + '<?php echo $query . $action; ?>',
                context: document.body
            }).done(function(response) {
                alert(response);
                disableKey();
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
<script src="../assets/libs/multiselect/jquery.multi-select.js"></script>
<script src="../assets/libs/jquery-quicksearch/jquery.quicksearch.min.js"></script>
<script src="../assets/libs/select2/select2.min.js"></script>
<script src="../assets/libs/bootstrap-select/bootstrap-select.min.js"></script>
<script src="../assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="../assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>

<!-- init js -->
<script src="../assets/js/pages/form-advanced.init.js"></script>

<!-- App js -->
<script src="../assets/js/app.min.js"></script>

</body>
</html>