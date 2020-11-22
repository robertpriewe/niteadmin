<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>

<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    <div class="form-group">
                        <button type="button" class="btn btn-success waves-effect waves-light" type="submit" onclick="javascript:confirmDeletion();">Confirm</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                                onclick="javascript:$('#custom-modal').modal('hide');javascript:disableKey();">Cancel</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end card-box -->


<?php
if (isset($_GET['deleteartistfromevent'])) {
    $url = "'ajax/deleteartistfromevent.php?eventid=" . $_GET['eventid'] . "&artistid=" . $_GET['artistid'] . "'";
    $doneurl = "document.location.href='?page=eventdetails&eventid=" . $_GET['eventid'] . "';";
} else if(isset($_GET['deleteuser'])) {
    $url = "'ajax/deleteuser.php?userid=" . $_GET['userid'] . "'";
    $doneurl = "document.location.href='?page=userlist';";
} else {
    $doneurl = 'location.reload();';
    if (isset($_GET['artistid'])) {
        $query = '&artistid=' . $_GET['artistid'];
        $url = "'ajax/unassigncontact.php?contactid=" . $_GET['contactid'] . $query . "'";
    } elseif (isset($_GET['vendorid'])) {
        $query = '&vendorid=' . $_GET['vendorid'];
        $url = "'ajax/unassigncontact.php?contactid=" . $_GET['contactid'] . $query . "'";
    } elseif (isset($_GET['venueid'])) {
        $query = '&venueid=' . $_GET['venueid'];
        $url = "'ajax/unassigncontact.php?contactid=" . $_GET['contactid'] . $query . "'";
    }
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
            confirmDeletion();
        }
    }

    function confirmDeletion() {
        $.ajax({
            type: "GET",
            url: <?php echo $url; ?>,
            context: document.body
        }).done(function(response) {
            alert(response);
            disableKey();
            <?php echo $doneurl; ?>
        }).fail(function() {
            alert( "Error" );
        });
    }
</script>
