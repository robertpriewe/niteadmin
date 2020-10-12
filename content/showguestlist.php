
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                        <?php
                        $query = mysqli_query($mysqli, "SELECT COUNT(ID) AS TOTALCOUNT, ACCESSLEVEL FROM guestlist RIGHT JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID WHERE EVENTID = " . $_GET['eventid'] . " GROUP BY ACCESSLEVEL ORDER BY TOTALCOUNT DESC");
                        while($row = $query->fetch_assoc()) {
                            $counts[] = $row['TOTALCOUNT'];
                            $countsdesc[] = $row['ACCESSLEVEL'];
                        }

                        $query = mysqli_query($mysqli, "SELECT COUNT(guestlist.ID) AS GUESTLISTCOUNT FROM guestlist JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID WHERE EVENTID = " . $_GET['eventid'] . " AND ACCESSLEVEL = 'GA'");
                        while($row = $query->fetch_assoc()) {
                            $countGA = $row['GUESTLISTCOUNT'];
                        }
                        $query = mysqli_query($mysqli, "SELECT COUNT(guestlist.ID) AS GUESTLISTCOUNT FROM guestlist JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID WHERE EVENTID = " . $_GET['eventid'] . " AND ACCESSLEVEL = 'AAA'");
                        while($row = $query->fetch_assoc()) {
                            $countAAA = $row['GUESTLISTCOUNT'];
                        }
                        $query = mysqli_query($mysqli, "SELECT COUNT(guestlist.ID) AS GUESTLISTCOUNT FROM guestlist JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID WHERE EVENTID = " . $_GET['eventid'] . " AND ACCESSLEVEL = 'VIP'");
                        while($row = $query->fetch_assoc()) {
                            $countVIP = $row['GUESTLISTCOUNT'];
                        }
                        $query = mysqli_query($mysqli, "SELECT COUNT(guestlist.ID) AS GUESTLISTCOUNT FROM guestlist JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID WHERE EVENTID = " . $_GET['eventid'] . " AND ACCESSLEVEL = 'MEDIA'");
                        while($row = $query->fetch_assoc()) {
                            $countMEDIA = $row['GUESTLISTCOUNT'];
                        }


                        $query = mysqli_query($mysqli, "SELECT *, COUNT(guestlist.ID) AS GUESTLISTCOUNT FROM guestlist JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID WHERE EVENTID = '" . $_GET['eventid'] . "' GROUP BY GROUPHASH, ACCESSLEVEL ORDER BY FIRSTNAME, LASTNAME ASC");

                        if ($query->num_rows > 0) {
                            while($row = $query->fetch_assoc()) {
                                $showsquery[] = $row;
                            }
                        } else {
                            $showsquery = array();
                        }
                        $eventnamequery = mysqli_query($mysqli, "SELECT EVENTNAME FROM events WHERE EVENTID = '" . $_GET['eventid'] . "'");
                        while($row2 = $eventnamequery->fetch_assoc()) {
                            $eventname = $row2['EVENTNAME'];
                        }

                        ?>
                        <div class="row">
                            <div class="col-lg-12 row">
                                <div class="col-lg-10">
                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Event Name: <?php echo $eventname; ?></h5>
                                </div>
                                <div class="col-lg-2">
                                    <div class="text-lg-right mt-3 mt-lg-0">
                                        <a href="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Guestlist Allocation','ajax/ajaxmodalguestlistallocation.php?eventid=<?php echo $_GET['eventid']; ?>');"><i class="mdi mdi-plus-circle mr-1"></i> Add Allocation</a>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="text-center mb-2">
                            <div class="row">
                                <div class="col-md-6 col-xl-3">
                                    <div class="card-box">
                                        <i class="fe-tag font-24"></i>
                                        <h3><?php echo $countGA; ?></h3>
                                        <p class="text-uppercase mb-1 font-13 font-weight-medium">Total GA</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card-box">
                                        <i class="fe-archive font-24"></i>
                                        <h3><?php echo $countVIP; ?></h3>
                                        <p class="text-uppercase mb-1 font-13 font-weight-medium">Total VIP</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card-box">
                                        <i class="fe-shield font-24"></i>
                                        <h3><?php echo $countMEDIA; ?></h3>
                                        <p class="text-uppercase mb-1 font-13 font-weight-medium">Total Media</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card-box">
                                        <i class="fe-delete font-24"></i>
                                        <h3><?php echo $countAAA; ?></h3>
                                        <p class="text-uppercase mb-1 font-13 font-weight-medium">Total AAA</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                            <thead class="bg-light">
                            <tr>
                                <th class="font-weight-medium">Name</th>
                                <th class="font-weight-medium">E-Mail</th>
                                <th class="font-weight-medium">Access</th>
                                <th class="font-weight-medium">Slots</th>
                                <th class="font-weight-medium">Notes</th>
                            </tr>
                            </thead>

                            <tbody class="font-14">


                            <?php
                            if (count($showsquery) > 0) {
                                foreach ($showsquery as $showsrow) {

                                    echo '<tr>
                                <td>' . $showsrow['FIRSTNAME'] . ' ' . $showsrow['LASTNAME'] . '</td>
                                <td>' . $showsrow['EMAIL'] . '</td>
                                <td>' . $showsrow['ACCESSLEVEL'] . '</td>
                                <td>' . $showsrow['GUESTLISTCOUNT'] . '</td>
                                <td>' . $showsrow['NOTES'] . '</td>
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
