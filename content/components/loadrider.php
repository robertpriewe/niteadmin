<?php
session_start();
error_reporting(E_ALL);
include('../../modules/sql.php');
if (isset($_GET['setid'])) {
    $result = mysqli_query($mysqli, "SELECT * FROM shows_riders WHERE SETID = '" . $_GET['setid'] . "' AND ITEMDELETED = 0 ORDER BY ITEMDONE, ITEMPOSITION, RIDERITEMID ASC");
    $totalrows = $result->num_rows;
    if ($totalrows > 0) {
        while ($row = $result->fetch_array()) {
            $itemname[] = $row['ITEMNAME'];
            $itemid[] = $row['RIDERITEMID'];
            $itemdone[] = $row['ITEMDONE'];
        }
        $counts = array_count_values($itemdone);
    }
} else {
    echo 'No setid supplied';
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Plugins css-->
    <link href="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/multiselect/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="assets/libs/custombox/custombox.min.css" rel="stylesheet">


    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="row align-items-center">
    <div class="col-sm-6">
    <?php
    if ($totalrows > 0) {
        echo '
        <h5 id="todo-message"><span id="todo-remaining">' . $counts['0'] . '</span> of <span id="todo-total">' . count($itemdone) . '</span> remaining</h5>
        ';
    } else {
        echo '<h5 id="todo-message"> No items added to rider</h5><br><br>';
    }
    ?>
    </div>
    <div class="col-sm-6 text-right">
        <a href="#custom-modal-rider" class="btn btn-success waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlayColor="#38414a" onclick="javascript:openModalRider('Import tasks','ajax/ajaxmodaladdtorider.php?setid=<?php echo $_GET['setid']; ?>');"><i class="mdi mdi-import mr-1"></i>Import</a>
        <button class="btn btn-danger" onclick="javascript:toggleDeleteBtn();"><i class="mdi mdi-trash-can mr-1"></i>Remove tasks</button>
    </div>
</div>

<?php
if ($totalrows > 0) {
        echo '<div><ul class="list-group list-group-flush todo-list" style="" id="todo-list">';
            for ($i = 0; $i < count($itemid); $i++) {
                if ($itemdone[$i] == "1") {
                    $checked = ' CHECKED';
                } else {
                    $checked = '';
                }
                echo '<li class="list-group-item border-0 pl-1"><div class="checkbox checkbox-primary"><b class="taskDeleteBtn" style="display:none;"><button class="btn btn-danger btn-xs" onclick="javascript:deleteRiderTask(' . $itemid[$i] . ');"><i class="mdi mdi-trash-can mr-1"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;</b><input onclick="javascript:setRiderTask(' . $itemid[$i] . ');" class="todo-done" id="taskid-' . $itemid[$i] . '" type="checkbox"' . $checked . '><label for="taskid-' . $itemid[$i] . '">' . $itemname[$i] . '</label></div></li>';
            }
    echo '</ul>
</div>';
    }
?>

<form name="todo-form" id="todo-form" role="form" class="m-t-20">
    <div class="row">
        <div class="col-sm-9 todo-inputbar">
            <input type="text" id="rider-input-text" name="rider-input-text" class="form-control" placeholder="Add new item to rider">
        </div>
        <div class="col-sm-3 todo-send">
            <button class="btn-primary btn-md btn-block btn waves-effect waves-light" type="button" id="todo-btn-submit" onclick="javascript:addToRider();">Add</button>
        </div>
    </div>
</form>


<div id="custom-modal-rider" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title" id="modalTitleRider"></h4>
    <div class="custom-modal-text text-left" id="modalContentRider">

    </div>
</div>

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

<!-- Modal-Effect -->
<script src="assets/libs/custombox/custombox.min.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>

<script type="text/javascript">
    function setRiderTask(taskid) {
        $.ajax({
            type: "GET",
            url: 'ajax/checkuncheckridertask.php?taskid=' + taskid + '&checked=' + $('#taskid-' + taskid).prop("checked"),
            context: document.body
        }).done(function(response) {
        }).fail(function() {
            alert( "Error" );
        });
    }
    function deleteRiderTask(taskid) {
        $.ajax({
            type: "GET",
            url: 'ajax/deleteridertask.php?taskid=' + taskid ,
            context: document.body
        }).done(function(response) {
            alert('Task deleted');
            loadRider(<?php echo $_GET['setid']; ?>);
        }).fail(function() {
            alert( "Error" );
        });
    }

    function openModalRider(title, ajaxfilename) {
        $('#modalContentRider').html('<div class="spinner-border avatar-lg text-primary m-2" role="status"></div>');
        var title;
        var ajaxfilename;
        $('#modalTitleRider').html(title);
        $.ajax({
            type: "GET",
            url: ajaxfilename,
            context: document.body
        }).done(function(response) {
            $('#modalContentRider').html(response);
            $(".select2").select2();
            document.styleSheets[0].insertRule('.select2-container--open { z-index: 999999; }', 0);
        }).fail(function() {
            alert( "Error" );
        });
    }

    function addToRider() {
        var ridertext = $("#rider-input-text").val();
        if (ridertext == "") {
            alert("Please add a task name");
        } else {
            $.ajax({
                type: "POST",
                data: { 'tasks': ridertext },
                url: 'ajax/importrider.php?setid=<?php echo $_GET['setid']; ?>',
                context: document.body
            }).done(function(response) {
                alert("Task added!");
                loadRider(<?php echo $_GET['setid']; ?>);
            }).fail(function() {
                alert( "Error" );
            });
        }
    }

    function toggleDeleteBtn() {
        $('.taskDeleteBtn').toggle();
    }
</script>

</body>
</html>