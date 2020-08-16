<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
?>
<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">First Name</label>
                    <input type="text" class="form-control" id="firstName" placeholder="Enter first name">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Last Name</label>
                    <input type="text" class="form-control" id="lastName" placeholder="Enter last name">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Phone</label>
                    <input type="text" class="form-control" id="phone" placeholder="Enter phone">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Email</label>
                    <input type="text" class="form-control" id="email" placeholder="Enter email">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Company</label>
                    <input type="text" class="form-control" id="company" placeholder="Enter company">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Select Role</label>
                    <input type="text" class="form-control" id="role" placeholder="Enter Role">
                    <?php
                    /*
                        <select class="form-control select2" id="role">
                        <option value="">Select</option>
                        <option value="Manager">Manager</option>
                        <option value="Tour Manager">Tour Manager</option>
                        <option value="VJ">VJ</option>
                        <option value="Vendor">Vendor</option>
                        </select>
                     */
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="text-right">
                    <div class="form-group">
                        <button type="button" class="btn btn-success waves-effect waves-light" type="submit" onclick="javascript:addContact();">Add</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                                onclick="Custombox.modal.close();javascript:disableKey();">Cancel</button>

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
            addContact();
        }
    }

    function addContact() {
        var firstName = $("#firstName").val();
        var lastName = $("#lastName").val();
        var role = $("#role").val();
        var company = $("#company").val();
        if (firstName == "") {
            alert("Please enter a first name");
        } else if (lastName == "") {
            alert("Please enter a last name");
        } else if (role == "") {
            alert("Please select a role");
        } else if (company == "") {
            alert("Please enter a company or type self-employed");
        }
        else {
            $.ajax({
                type: "POST",
                data: {'firstname':firstName, 'lastname':lastName, 'role':role, 'company':company, 'email':$("#email").val(), 'phone':$("#phone").val()},
                url: 'ajax/addcontact.php',
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