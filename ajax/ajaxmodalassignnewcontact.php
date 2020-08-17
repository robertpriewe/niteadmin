<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>

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
                                onclick="javascript:$('#custom-modal').modal('hide');javascript:disableKey();">Cancel</button>

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
