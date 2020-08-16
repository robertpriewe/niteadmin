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
        <a href="#custom-modal" class="btn btn-success waves-effect waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModalRider('Import tasks','ajax/ajaxmodaladdtorider.php?setid=<?php echo $_GET['setid']; ?>');"><i class="mdi mdi-import mr-1"></i>Import</a>
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
        $('#modalContent').html('<div class="spinner-border avatar-lg text-primary m-2" role="status"></div>');
        var title;
        var ajaxfilename;
        $('#modalTitle').html(title);
        $.ajax({
            type: "GET",
            url: ajaxfilename,
            context: document.body
        }).done(function(response) {
            $('#modalContent').html(response);
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
