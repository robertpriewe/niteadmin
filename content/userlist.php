<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <?php
                $query = mysqli_query($mysqli, 'SELECT * FROM users LEFT JOIN permissions_roles ON users.ROLE = permissions_roles.ROLEID');

                if ($query->num_rows > 0) {
                    while($row = $query->fetch_assoc()) {
                        $showsquery[] = $row;
                    }
                } else {
                    $showsquery = array();
                }


                ?>
                <div class="row">
                    <div class="col-lg-12 row">
                        <div class="col-lg-10">
                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Artists</h5>
                        </div>
                        <div class="col-lg-2">
                            <div class="text-lg-right mt-3 mt-lg-0">
                                <a href="#custom-modal" data-toggle="modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Artist','ajax/ajaxmodaladdnewartist.php');"><i class="mdi mdi-plus-circle mr-1"></i> New Artist</a>
                            </div>
                        </div>
                    </div>
                </div>



                <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                    <thead class="bg-light">
                    <tr>
                        <th class="font-weight-medium">Username</th>
                        <th class="font-weight-medium">Name</th>
                        <th class="font-weight-medium">E-Mail</th>
                        <th class="font-weight-medium">Role</th>
                        <th class="font-weight-medium">Last Login</th>
                    </tr>
                    </thead>

                    <tbody class="font-14">


                    <?php
                    if (count($showsquery) > 0) {
                    foreach ($showsquery as $showsrow) {
                        echo '<tr>
                                <td>
                                    <a href="javascript: void(0);" class="text-dark">
                                        <span class="ml-2"><b><a href="?page=usermanagement&userid=' . $showsrow['USERID'] . '">' . $showsrow['USERNAME'] . '</a></b></span>
                                    </a>
                                </td>
                                <td>' . $showsrow['FIRSTNAME'] . ' ' . $showsrow['LASTNAME'] . '</td>
                                <td>' . $showsrow['EMAIL'] . '</td>
                                <td>' . $showsrow['ROLENAME'] . '</td>
                                <td>' . $showsrow['LASTLOGIN'] . '</td>
                                
                            </tr>';
                    }

                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- end col -->
</div>
<!-- end row -->



</div> <!-- container -->
