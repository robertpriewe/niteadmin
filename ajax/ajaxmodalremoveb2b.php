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
                                onclick="Custombox.modal.close();javascript:disableKey();">Cancel</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end card-box -->


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
            url: 'ajax/removeb2b.php?id=<?php echo $_GET['id']; ?>',
            context: document.body
        }).done(function(response) {
            alert(response);
            disableKey();
            location.reload();
        }).fail(function() {
            alert( "Error" );
        });
    }
</script>

