<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php
                $query = mysqli_query($mysqli, "SELECT * FROM events_users_link LEFT JOIN users ON events_users_link.USERID = users.USERID RIGHT JOIN events ON events_users_link.EVENTID = events.EVENTID WHERE events_users_link.EVENTID = " . $_GET['eventid']);

                if ($query->num_rows > 0) {
                    while($row = $query->fetch_assoc()) {
                        $queryarray[] = $row;
                    }
                    $eventname = $queryarray[0]['EVENTNAME'];
                } else {
                    $queryarray = array();
                    $eventnamequery = mysqli_query($mysqli, "SELECT EVENTNAME FROM events WHERE EVENTID = '" . $_GET['eventid'] . "'");
                    while($row2 = $eventnamequery->fetch_assoc()) {
                        $eventname = $row2['EVENTNAME'];
                    }
                }

                ?>
                <div class="row">
                    <div class="col-lg-12 row">
                        <div class="col-lg-9">
                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Employee list for: <?php echo $eventname; ?></h5>
                        </div>
                        <div class="col-lg-3">
                            <div class="text-lg-right mt-3 mt-lg-0">
                                <a href="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Assign Employee','ajax/ajaxmodalsponsorlist.php?eventid=<?php echo $_GET['eventid']; ?>');"><i class="mdi mdi-plus-circle mr-1"></i> Assign Employee</a>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="text-center mb-2">
                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="card-box">
                                <i class="fe-tag font-24"></i>
                                <h3><?php echo '99'; ?></h3>
                                <p class="text-uppercase mb-1 font-13 font-weight-medium">Total Employees</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card-box">
                                <i class="fe-archive font-24"></i>
                                <h3><?php echo '99'; ?></h3>
                                <p class="text-uppercase mb-1 font-13 font-weight-medium"># of Staff</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card-box">
                                <i class="fe-shield font-24"></i>
                                <h3 class="text-success">8 </h3>
                                <p class="text-uppercase mb-1 font-13 font-weight-medium">Paid</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card-box">
                                <i class="fe-delete font-24"></i>
                                <h3 class="text-danger">0</h3>
                                <p class="text-uppercase mb-1 font-13 font-weight-medium">Payment Overdue</p>
                            </div>
                        </div>
                    </div>
                </div>


                <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                    <thead class="bg-light">
                    <tr>
                        <th class="font-weight-medium">ID</th>
                        <th class="font-weight-medium">Employee Name</th>
                        <th class="font-weight-medium">Type</th>
                        <th class="font-weight-medium">Phone</th>
                        <th class="font-weight-medium">Contract</th>
                        <th class="font-weight-medium">Payment</th>
                        <th class="font-weight-medium">Action</th>
                    </tr>
                    </thead>

                    <tbody class="font-14">


                    <?php
                    if (count($queryarray) > 0) {
                        foreach ($queryarray as $rowquery) {

                            echo '                            <tr>
                                <td><a href="?page=eventsponsordetails&eventsponsorid=' . $rowquery['USERID'] . '"><b>' . $rowquery['USERID'] . '</b></a></td>
                                <td>
                                    <a href="javascript: void(0);" class="text-dark">
                                        <span class="ml-2">' . $rowquery['USERNAME'] . '</span>
                                    </a>
                                </td>

                                <td>' . $rowquery['ROLE'] . '</td>
                                
                                <td>' . $rowquery['EMAIL'] . '</td>
                                
                                <td>
                                    <span class="badge badge-success">Signed</span>
                                </td>

                                <td>
                                    <span class="badge badge-success">Complete</span>
                                </td>


                                <td>
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Edit</a>
                                            <a class="dropdown-item" href="#"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Close</a>
                                            <a class="dropdown-item" href="#"><i class="mdi mdi-delete mr-2 text-muted font-18 vertical-middle"></i>Remove</a>
                                            <a class="dropdown-item" href="#"><i class="mdi mdi-star mr-2 font-18 text-muted vertical-middle"></i>Mark as Unread</a>
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
        </div>

    </div><!-- end col -->
</div>
<!-- end row -->



</div> <!-- container -->
