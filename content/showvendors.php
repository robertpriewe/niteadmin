            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                        <?php
                        $query = mysqli_query($mysqli, 'SELECT * FROM vendors ORDER BY VENDORNAME ASC');

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
                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Vendors</h5>
                                </div>
                                <div class="col-lg-2">
                                    <div class="text-lg-right mt-3 mt-lg-0">
                                        <a href="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Vendor','ajax/ajaxmodaladdnewvendor.php');"><i class="mdi mdi-plus-circle mr-1"></i> New Vendor</a>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                            <thead class="bg-light">
                            <tr>
                                <th class="font-weight-medium">Vendor Name</th>
                                <th class="font-weight-medium">Type</th>
                                <th class="font-weight-medium">Phone</th>
                                <th class="font-weight-medium">Action</th>
                            </tr>
                            </thead>

                            <tbody class="font-14">


                            <?php
                            if (count($showsquery) > 0) {
                                foreach ($showsquery as $showsrow) {

                                    echo '<tr>
                                <td><b><a href="?page=vendordetails&vendorid=' . $showsrow['VENDORID'] . '">' . $showsrow['VENDORNAME'] . '</a></b></td>
                                <td>' . $showsrow['VENDORTYPE'] . '</td>
                                <td>' . $showsrow['VENDORPHONE'] . '</td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Edit</a>
                                            <a class="dropdown-item" href="#"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Resend Ticket</a>
                                            <a class="dropdown-item" href="#"><i class="mdi mdi-delete mr-2 text-muted font-18 vertical-middle"></i>Remove</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>';
                                }
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>

                </div><!-- end col -->
            </div>
            <!-- end row -->



        </div> <!-- container -->
    </div> <!-- content -->
