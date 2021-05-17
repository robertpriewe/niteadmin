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

                    <div class="text-right">
                        <button type="button" class="btn btn-success waves-effect waves-light" onclick="javascript:removeContactAccreditation();">Remove</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="javascript:$('#custom-modal').modal('hide');">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
    function removeContactAccreditation() {
        $.ajax({
                type: "GET",
                url: 'ajax/removecontactaccreditation.php?setid=<?php echo $_GET['setid']; ?>&fieldname=<?php echo $_GET['fieldname']; ?>',
                context: document.body
            }).done(function(response) {
                location.reload();
            }).fail(function() {
                alert("Error");
            });
        }
</script>
