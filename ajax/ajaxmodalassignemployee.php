<?php
session_start();
include ('../modules/sql.php');
if (!isset($_GET['shiftid'])) {
    echo 'no shiftid specified';
    die;
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="name">Select Employee (use search bar)</label>
                        <select class="form-control select2" id="employeeid">
                            <option value="">Select</option>
                            <?php
                            $query = mysqli_query($mysqli, 'SELECT * FROM users LEFT JOIN permissions_roles ON users.ROLE = permissions_roles.ROLEID ORDER BY USERNAME ASC');
                            while($row = $query->fetch_array()) {
                                echo '<option value="' . $row['USERID'] . '">' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . ' ' . '(' . $row['ROLENAME'] . ')</option>';
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
                            <button type="button" class="btn btn-success waves-effect waves-light" type="submit" onclick="javascript:assignEmployee();">Assign</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                                    onclick="Custombox.modal.close();javascript:disableKey();">Cancel</button>

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

    function assignEmployee() {
        var employeeid = $("#employeeid").val();
        if (employeeid == "") {
            alert("Please select an employee");
        } else {
            $.ajax({
                type: "GET",
                url: 'ajax/assignshiftemployee.php?shiftid=<?php echo $_GET['shiftid']; ?>&employeeid=' + employeeid,
                context: document.body
            }).done(function(response) {
                alert('Employee assigned to shift');
                location.reload();
            }).fail(function() {
                alert( "Error" );
            });
        }
    }
</script>

