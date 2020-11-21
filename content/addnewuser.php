<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body col-xl-6">
                <div class="mt-3">
                    <?php
                    if (isset($_GET['action'])) {
                        mysqli_query($mysqli, "INSERT INTO users (EMAIL, PASSWORD, USERNAME, ROLE, FIRSTNAME, LASTNAME) VALUES ('" . $_POST['email'] . "', '" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "', '" . $_POST['username'] . "', '" . $_POST['role'] . "', '" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "')");
                        echo 'User ' . $_POST['username'] . ' added!';
                    } else {
                    ?>
                    <form class="form-horizontal" role="form" method="POST" action="?page=addnewuser&action=submit">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="simpleinput">Name</label>
                            <div class="col-sm-5">
                                <input type="text" id="simpleinput" class="form-control" placeholder="First Name" name="firstname">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" id="simpleinput" class="form-control" placeholder="Last Name" name="lastname">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="simpleinput">Username</label>
                            <div class="col-sm-10">
                                <input type="text" id="simpleinput" class="form-control" placeholder="Username" name="username">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="example-email">E-Mail</label>
                            <div class="col-sm-10">
                                <input type="email" id="example-email" class="form-control" placeholder="E-Mail" name="email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="password">Password</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" placeholder="Enter password" name="password">
                                    <div class="input-group-append" data-password="false">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="role">
                                    <?php
                                    $query = mysqli_query($mysqli, 'SELECT * FROM permissions_roles');
                                    while($row = $query->fetch_assoc()) {
                                        echo '<option value="' . $row['ROLEID'] . '">' . $row['ROLENAME'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3">
                                <input type="submit" class="form-control btn btn-primary" value="Add">
                            </div>
                        </div>


                    </form>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
