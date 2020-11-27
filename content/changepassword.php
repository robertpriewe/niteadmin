<?php
if (isset($_GET['action'])) {
    $query = mysqli_query($mysqli, "SELECT * FROM users WHERE USERID = '" . $_SESSION['USERID'] . "' LIMIT 0, 1");

    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $hashed_password = $row['PASSWORD'];
        }

        if (password_verify($_POST['oldpassword'], $hashed_password)) {
            include('ajax/addtolog.php');
            mysqli_query($mysqli, "UPDATE users SET PASSWORD = '" . password_hash($_POST['newpassword1'], PASSWORD_DEFAULT) . "' WHERE USERID = '" . $_SESSION['USERID'] . "'");
            addToLog($_SESSION['USERID'], 'update', 'users', '', '', 'Password', '', 'Password changed by user ' . $_SESSION['USERID']);

            echo 'Password saved!';
            echo '<br><br><a href="?" class="btn btn-primary">Return to home</a>';
            die;
        } else {
            echo '<div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Password is wrong!
                    </div>
                </div>
            </div>
        </div>';
        }

    }
}

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body col-xl-6">
                <div class="mt-3">
                        <form class="form-horizontal" role="form" method="POST" id="pwform" action="?page=changepassword&action=changepw">

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="password">Old Password</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="oldpassword" class="form-control" placeholder="Enter password" name="oldpassword">
                                        <div class="input-group-append" data-password="false">
                                            <div class="input-group-text">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="password">New Password</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password1" class="form-control" placeholder="New Password" name="newpassword1">
                                        <div class="input-group-append" data-password="false">
                                            <div class="input-group-text">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="password">Repeat New Password</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password2" class="form-control" placeholder="Repeat New Password" name="newpassword2">
                                        <div class="input-group-append" data-password="false">
                                            <div class="input-group-text">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <input type="button" class="form-control btn btn-primary" value="Change" onclick="javascript:checkPassword();">
                                </div>
                            </div>


                        </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function checkPassword() {
        var oldpassword = $('#oldpassword').val();
        var newpassword1 = $('#password1').val();
        var newpassword2 = $('#password2').val();
        if (oldpassword == '') {
            alert('Please enter your old password!');
        } else if (newpassword1 == '' || newpassword2 == '') {
            alert('Please type in a new password');
        } else if (newpassword1 != newpassword2) {
            alert('The new password doesnt match!');
        } else {
            $('#pwform').submit();
        }
    }
</script>