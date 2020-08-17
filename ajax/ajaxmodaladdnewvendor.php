<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>

<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <form>
                <div class="form-group">
                    <label for="name">Vendor Name</label>
                    <input type="text" class="form-control" id="vendorname" placeholder="Enter vendor name">
                </div>
                <div class="form-group">
                    <label for="name">Select Vendor type</label>
                    <select class="form-control select2" id="vendortype">
                        <option value="">Select</option>
                        <option value="Restaurant">Restaurant</option>
                        <option value="Bar">Bar</option>
                        <option value="Security">Security</option>
                    </select>
                </div>

                <div class="text-right">
                    <button type="button" class="btn btn-success waves-effect waves-light" onclick="javscript:addVendor();">Add</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                            onclick="javascript:$('#custom-modal').modal('hide');javascript:disableKey();">Cancel</button>
                </div>
            </form>
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
            addVendor();
        }
    }


    function addVendor() {
        var vendorname = $("#vendorname").val();
        var vendortype = $("#vendortype").val();
        if (vendorname == "") {
            alert("Please enter a name");
        } else if (vendortype == "") {
            alert("Please select a vendor type")
        } else {
            $.ajax({
                type: "POST",
                data: { 'vendorname': vendorname, 'vendortype': vendortype },
                url: 'ajax/addvendor.php',
                context: document.body
            }).done(function(response) {
                alert("Vendor added!");
                location.reload();
            }).fail(function() {
                alert( "Error" );
            });
        }
    }
</script>

