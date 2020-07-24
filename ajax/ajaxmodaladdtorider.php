<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
if (!isset($_GET['setid'])) {
    echo 'No setid specified';
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Plugins css-->
    <link href="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/multiselect/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />


    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

<br>
<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <form>
                <div class="form-group">
                    <label for="name">Add rider tasks</label>
                    <textarea class="form-control" id="ridertasks" placeholder="Split up multiple by new line"></textarea>
                </div>

                <div class="text-right">
                    <button type="button" class="btn btn-success waves-effect waves-light" onclick="javscript:addToRider();">Add</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                            onclick="Custombox.modal.close();">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
    function addToRider() {
        var ridertasks = $("#ridertasks").val();
        if (ridertasks == "") {
            alert("Please add tasks");
        } else {
            $.ajax({
                type: "POST",
                data: { 'tasks': ridertasks },
                url: 'ajax/importrider.php?setid=<?php echo $_GET['setid']; ?>',
                context: document.body
            }).done(function(response) {
                alert("Tasks added!");
                loadRider(<?php echo $_GET['setid']; ?>);
                Custombox.modal.close();
            }).fail(function() {
                alert( "Error" );
            });
        }
    }
</script>

<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>

<!-- Plugins Js -->
<script src="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="assets/libs/switchery/switchery.min.js"></script>
<script src="assets/libs/multiselect/jquery.multi-select.js"></script>
<script src="assets/libs/jquery-quicksearch/jquery.quicksearch.min.js"></script>
<script src="assets/libs/select2/select2.min.js"></script>
<script src="assets/libs/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>

<!-- init js -->
<script src="assets/js/pages/form-advanced.init.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>

</body>
</html>