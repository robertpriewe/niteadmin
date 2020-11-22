<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body col-xl-6">
                <?php
                if (isset($_GET['userid']) && !isset($_GET['action'])) {
                   ?>
                   <div class="text-right">
                    <a href="#custom-modal" class="btn btn-danger waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Are you sure you want to delete this user?','ajax/ajaxmodalconfirmdeletion.php?deleteuser=true&userid=<?php echo $_GET['userid']; ?>');"><i class="mdi mdi-delete mr-1"></i> Delete User</a>
                </div>
                <?php
                }
                ?>

                <div class="mt-3">
                    <?php
                    if (isset($_GET['action'])) {
                        if ($_GET['action'] == "new") {
                            mysqli_query($mysqli, "INSERT INTO users (EMAIL, PASSWORD, USERNAME, ROLE, FIRSTNAME, LASTNAME) VALUES ('" . $_POST['email'] . "', '" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "', '" . $_POST['username'] . "', '" . $_POST['role'] . "', '" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "')");
                            echo 'User ' . $_POST['username'] . ' added!';
                            echo '<br><br><a href="?page=userlist" class="btn btn-primary">Return to list</a>';
                        } elseif ($_GET['action'] == "edit") {
                            if ($_POST['password'] != "") {
                                mysqli_query($mysqli, "UPDATE users SET EMAIL = '" . $_POST['email'] . "', PASSWORD = '" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "', USERNAME = '" . $_POST['username'] . "', ROLE = '" . $_POST['role'] . "', FIRSTNAME = '" . $_POST['firstname'] . "', LASTNAME = '" . $_POST['lastname'] . "' WHERE USERID = " . $_GET['userid']);
                                echo 'Updated with password';
                                echo '<br><br><a href="?page=userlist" class="btn btn-primary">Return to list</a>';
                            } else {
                                mysqli_query($mysqli, "UPDATE users SET EMAIL = '" . $_POST['email'] . "', USERNAME = '" . $_POST['username'] . "', ROLE = '" . $_POST['role'] . "', FIRSTNAME = '" . $_POST['firstname'] . "', LASTNAME = '" . $_POST['lastname'] . "' WHERE USERID = " . $_GET['userid']);
                                echo 'Updated without password';
                                echo '<br><br><a href="?page=userlist" class="btn btn-primary">Return to list</a>';
                            }
                        }

                    } else {
                        if (isset($_GET['userid'])) {
                            $url = "?page=usermanagement&action=edit&userid=" . $_GET['userid'];
                            $button = 'Edit';
                            $query = mysqli_query($mysqli, 'SELECT * FROM users LEFT JOIN permissions_roles ON users.ROLE = permissions_roles.ROLEID WHERE users.USERID = ' . $_GET['userid']);

                            if ($query->num_rows > 0) {
                                while ($row = $query->fetch_assoc()) {
                                    $userfield = $row;

                                }
                            }
                        } else {
                            $url = "?page=usermanagement&action=new";
                            $userfield['FIRSTNAME'] = "";
                            $userfield['LASTNAME'] = "";
                            $userfield['USERNAME'] = "";
                            $userfield['EMAIL'] = "";
                            $userfield['ROLEID'] = "";
                            $userfield['ROLENAME'] = "";
                            $button = 'Add';
                        }

                        ?>
                        <form class="form-horizontal" role="form" method="POST" action="<?php echo $url; ?>">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="simpleinput">Name</label>
                                <div class="col-sm-5">
                                    <input type="text" id="simpleinput" class="form-control" placeholder="First Name" name="firstname" value="<?php echo $userfield['FIRSTNAME']; ?>">
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" id="simpleinput" class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $userfield['LASTNAME']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="simpleinput">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" id="simpleinput" class="form-control" placeholder="Username" name="username" value="<?php echo $userfield['USERNAME']; ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="example-email">E-Mail</label>
                                <div class="col-sm-10">
                                    <input type="email" id="example-email" class="form-control" placeholder="E-Mail" name="email" value="<?php echo $userfield['EMAIL']; ?>">
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
                                        if (isset($userfield['ROLEID'])) {
                                            echo '<option value="' . $userfield['ROLEID'] . '">' . $userfield['ROLENAME'] . '</option>';

                                        }
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
                                    <input type="submit" class="form-control btn btn-primary" value="<?php echo $button; ?>">
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
