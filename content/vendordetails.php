<?php
if (!isset($_GET['vendorid'])) {
    echo '<div class="content-page">No vendor ID found</div>';
} else {
    $query = mysqli_query($mysqli, 'SELECT * FROM vendors WHERE vendors.VENDORID = ' . $_GET['vendorid'] . ' LIMIT 0, 1');
    while($row = $query->fetch_array()) {
        $rowvendors = $row;
    }
    $query = mysqli_query($mysqli, 'SELECT * FROM contacts_link JOIN contacts ON contacts_link.CONTACTID = contacts.CONTACTID WHERE LINKTABLE = "vendors" AND LINKID = "' . $_GET['vendorid'] . '" ORDER BY ORDERID ASC');
    $rowcontacts = array();
    while($row = $query->fetch_array()) {
        $rowcontacts[] = $row;
}
?>
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <div class="card">
                    <div class="card-body text-center">
                        <?php //<img src="assets/images/users/avatar-3.jpg" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image"> ?>

                        <h4 class="mb-0"><?php echo $rowvendors['VENDORNAME']; ?></h4>
                        <p class="text-muted">Vendortype: <?php echo $rowvendors['VENDORTYPE']; ?></p>

                        <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Website</button>
                        <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Assign to Event</button>

                        <div class="text-left mt-3">
                            <div class="row">
                                <div class="col-sm-6"><h4 class="font-13 text-uppercase">Vendor Info</h4></div>
                                <div class="col-sm-6 text-right"><button type="button" class="btn btn-primary btn-xs waves-effect mb-2 waves-light" onclick="javascript:clickEdit();">Edit</button></div>
                            </div>
                            <table class="table table-centered table-borderless table-striped mb-0">
                                <tbody>
                                <?php
                                echo '<tr>
                                        <td style="width: 35%;">VENDORNAME</td>
                                        <td><a class="changefield" href="#" data-type="text" data-pk="{id:' . $_GET['vendorid'] . ',page:\'vendors\'}" data-name="VENDORNAME">' . $rowvendors['VENDORNAME'] . '</a></td>
                                    </tr>';
                                echo '<tr>
                                        <td style="width: 35%;">VENUETYPE</td>
                                        <td><a class="changefield" href="#" data-type="text" data-pk="{id:' . $_GET['vendorid'] . ',page:\'vendors\'}" data-name="VENDORTYPE">' . $rowvendors['VENDORTYPE'] . '</a></td>
                                    </tr>';
                                echo '<tr>
                                        <td style="width: 35%;">VENUEPHONE</td>
                                        <td><a class="changefield" href="#" data-type="text" data-pk="{id:' . $_GET['vendorid'] . ',page:\'vendors\'}" data-name="VENDORPHONE">' . $rowvendors['VENDORPHONE'] . '</a></td>
                                    </tr>';
                                ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    </div> <!-- end card-box -->

                    <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Vendor Notes</h4>
                        <?php echo '<p class="mb-3"><a class="changefield" href="#" data-type="textarea" data-pk="{id:' . $_GET['vendorid'] . ',page:\'vendors\'}" data-name="VENDORNOTES">' . $rowvendors['VENDORNOTES'] . '</a></p>'; ?>
                    </div>
                    </div> <!-- end card-box-->

                </div> <!-- end col-->

                <div class="col-lg-6 col-xl-6">
                    <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills navtab-bg">
                            <li class="nav-item">
                                <a href="#teaminfo" data-toggle="tab" aria-expanded="true" class="nav-link active ml-0">
                                    <i class="mdi mdi-face-profile mr-1"></i>Contacts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#events" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="mdi mdi-settings-outline mr-1"></i>Events
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane show active" id="teaminfo">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-briefcase mr-1"></i>
                                            Team Info</h5></div>
                                    <div class="col-sm-6 text-right">
                                        <a href="#custom-modal" class="btn btn-primary btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Assign New Contact','ajax/ajaxmodalassignnewcontact.php?vendorid=<?php echo $_GET['vendorid']; ?>');"><i class="mdi mdi-plus-circle mr-1"></i> Assign New Contact</a>
                                    </div></div>
                                <?php



                                if (count($rowcontacts) > 0) {
                                    foreach ($rowcontacts as $contactrow) {
                                        echo '<div class="card">
                                    <div class="card-header"><div class="row"><div class="col-sm-6"><b>' . $contactrow['ROLE'] . '</b></div><div class="col-sm-6 text-right">
                                    <a href="#custom-modal" class="btn btn-danger btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'Are you sure you want to unassign this contact?\',\'ajax/ajaxmodalconfirmdeletion.php?action=unassigncontact&vendorid=' . $_GET['vendorid'] . '&contactid=' . $contactrow['CONTACTID'] . '\');"><i class="mdi mdi-delete mr-1"></i> Remove</a>
                                    </div></div></div>
                                    <div class="card-body">
                                        <blockquote class="card-bodyquote">
                                            <table>
                                                <tr><td><p class="text-muted mb-2 font-13"><strong>Name</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2">' . $contactrow['FIRSTNAME'] . ' ' . $contactrow['LASTNAME'] . '</span></p></td></tr>
                                                <tr><td><p class="text-muted mb-2 font-13"><strong>Company</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2">' . $contactrow['COMPANY'] . '</span></p></td></tr>
                                                <tr><td><p class="text-muted mb-2 font-13"><strong>Phone</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2">' . $contactrow['PHONE'] . '</span></p></td></tr>
                                                <tr><td><p class="text-muted mb-2 font-13"><strong>Email</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2">' . $contactrow['EMAIL'] . '</span></p></td></tr>
                                                </table>
                                        </blockquote>
                                    </div>
                                </div>';
                                    }
                                }
                                ?>

                            </div>
                            <!-- end timeline content-->
                            <div class="tab-pane" id="events">
                                <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i>
                                    Events</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Project Name</th>
                                            <th>Start Date</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Clients</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Ultra 2020</td>
                                            <td>01/01/2015</td>
                                            <td>10/15/2018</td>
                                            <td><span class="badge badge-info">Work in Progress</span></td>
                                            <td>Halette Boivin</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Lollapalooza</td>
                                            <td>21/07/2016</td>
                                            <td>12/05/2018</td>
                                            <td><span class="badge badge-success">Pending</span></td>
                                            <td>Durandana Jolicoeur</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Coachella</td>
                                            <td>18/03/2018</td>
                                            <td>28/09/2018</td>
                                            <td><span class="badge badge-pink">Done</span></td>
                                            <td>Lucas Sabourin</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Life in Color</td>
                                            <td>02/10/2017</td>
                                            <td>07/05/2018</td>
                                            <td><span class="badge badge-purple">Work in Progress</span></td>
                                            <td>Donatien Brunelle</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Lost Lands</td>
                                            <td>17/01/2017</td>
                                            <td>25/05/2021</td>
                                            <td><span class="badge badge-warning">Coming soon</span></td>
                                            <td>Karel Auberjo</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-- end settings content-->

                        </div> <!-- end tab-content -->
                    </div>
                    </div> <!-- end card-box-->

                </div> <!-- end col -->

    <?php
}
?>