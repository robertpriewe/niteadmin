<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
if (!isset($_GET['setid'])) {
    echo 'No setid specified';
    die;
}
?>

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
                            onclick="javascript:$('#custom-modal').modal('hide');">Cancel</button>
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
                $('#custom-modal').modal('hide');
            }).fail(function() {
                alert( "Error" );
            });
        }
    }

</script>
