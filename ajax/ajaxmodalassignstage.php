<?php
session_start();
include ('../modules/sql.php');
if (!isset($_GET['setid'])) {
    echo 'no setid specified';
    die;
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="stageSelect">Assign Stage</label>
                        <select class="form-control select2" id="stageSelect">
                        <?php
                        $query = mysqli_query($mysqli, 'SELECT stages.STAGENAME, stages.STAGEID, VENUEID FROM shows JOIN stages ON shows.STAGEID = stages.STAGEID WHERE shows.SHOWID = ' . $_GET['setid']);
                        while($row = $query->fetch_array()) {
                            echo '<option value="' . $row['STAGEID'] . '">' . $row['STAGENAME'] . '</option>';
                            $venueid = $row['VENUEID'];
                        }

                        $query = mysqli_query($mysqli, 'SELECT * FROM stages WHERE VENUEID = ' . $venueid . ' ORDER BY STAGENAME ASC');
                        while($row = $query->fetch_array()) {
                            echo '<option value="' . $row['STAGEID'] . '">' . $row['STAGENAME'] . '</option>';
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
                            <button type="button" class="btn btn-success waves-effect waves-light" type="submit" onclick="javascript:assignStage();">Assign</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                                    onclick="javascript:$('#custom-modal').modal('hide');javascript:disableKey();">Cancel</button>

                        </div>
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
    function disableKey() {
        document.onkeydown=function() {
            if (window.event.keyCode == '13') {
            }
        }
    }

    document.onkeydown=function(){
        if(window.event.keyCode=='13'){
            addShift();
        }
    }

    function assignStage() {
        var stageSelect = $("#stageSelect").val();
        if (stageSelect == "") {
            alert("Please select an stage");
        } else {
            $.ajax({
                type: "GET",
                url: 'ajax/assignstage.php?setid=<?php echo $_GET['setid']; ?>&stageid=' + stageSelect,
                context: document.body
            }).done(function(response) {
                alert('Stage assigned');
                location.reload();
            }).fail(function() {
                alert( "Error" );
            });
        }
    }
</script>

