<?php
if (!isset($_GET['venueid'])) {
    echo 'No Venue ID found';
    die;
}
$_GET['setid'] = 1;
$query = mysqli_query($mysqli, 'SELECT * FROM venues WHERE VENUEID = "' . $_GET['venueid'] . '" LIMIT 0, 1');
while($row = $query->fetch_array()) {
    $rowvenue = $row;
}
$query = mysqli_query($mysqli, 'SELECT * FROM contacts_link JOIN contacts ON contacts_link.CONTACTID = contacts.CONTACTID WHERE LINKTABLE = "venues" AND LINKID = "' . $_GET['venueid'] . '" ORDER BY ORDERID ASC');
$rowcontacts = array();
while($row = $query->fetch_array()) {
    $rowcontacts[] = $row;
}
?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <ul class="nav nav-pills navtab-bg">
                                    <li class="nav-item">
                                        <a href="#about-me" data-toggle="tab" aria-expanded="true" class="nav-link active ml-0">
                                            <i class="mdi mdi-face-profile mr-1"></i>Venue Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-headphones mr-1"></i>Stage Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#contacts" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-contacts mr-1"></i>Contacts
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <div class="text-lg-right mt-3 mt-lg-0">
                                    <button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="javascript:clickEdit();"><i class="mdi mdi-settings"></i> Edit</button>
                                    <a href="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Stage','ajax/ajaxmodaladdnewstage.php?venueid=<?php echo $_GET['venueid']; ?>');"><i class="mdi mdi-plus-circle mr-1"></i> Add New Stage</a>
                                </div>
                            </div><!-- end col-->
                        </div> <!-- end row -->
                    </div> <!-- end card-box -->
                    </div>
                </div><!-- end col-->
            </div>
            <!-- end row -->


            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                    <div class="card-body">

                        <div class="tab-content">

                        <div class="tab-pane show active" id="about-me">

                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-briefcase mr-1"></i>Venue: <?php echo $rowvenue['VENUENAME']; ?></h5>

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-centered table-borderless table-striped mb-0">
                                            <tbody>
                                            <?php
                                            echo '<tr>
                                                    <td style="width: 35%;">VENUENAME</td>
                                                    <td><a class="changefield" href="#" data-type="text" data-pk="{id:' . $_GET['venueid'] . ',page:\'venues\'}" data-name="' . $rowvenue['VENUENAME'] . '">' . $rowvenue['VENUENAME'] . '</a></td>
                                                </tr>';
                                            echo '<tr>
                                                    <td style="width: 35%;">VENUETYPE</td>
                                                    <td><a class="changefield" href="#" data-type="text" data-pk="{id:' . $_GET['venueid'] . ',page:\'venues\'}" data-name="' . $rowvenue['VENUETYPE'] . '">' . $rowvenue['VENUETYPE'] . '</a></td>
                                                </tr>';
                                            echo '<tr>
                                                    <td style="width: 35%;">VENUECAPACITY</td>
                                                    <td><a class="changefield" href="#" data-type="text" data-pk="{id:' . $_GET['venueid'] . ',page:\'venues\'}" data-name="' . $rowvenue['VENUECAPACITY'] . '">' . $rowvenue['VENUECAPACITY'] . '</a></td>
                                                </tr>';
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- end timeline content-->

                    <div class="tab-pane" id="settings">
                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-briefcase mr-1"></i> Stages</h5>
                        <div class="row">

                            <?php
                            $query = mysqli_query($mysqli, 'SELECT * FROM stages WHERE UNASSIGNEDSTAGE = 0 AND VENUEID = "' . $_GET['venueid'] . '"');
                            $count = mysqli_num_rows($query);
                            while($row = $query->fetch_array()) {
                                echo '<div class="col-md-6">
                                <div class="card-box">
                                    <div class="table-responsive">
                                        <table class="table table-centered table-borderless table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 35%;">STAGENAME</td>
                                                    <td><a class="changefield" href="#" data-type="text" data-pk="{id:\'' . $row['STAGEID'] . '\',page:\'stages\'}" data-name="' . $row['STAGENAME'] . '">' . $row['STAGENAME'] . '</a></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 35%;">SIZESQFT</td>
                                                    <td><a class="changefield" href="#" data-type="text" data-pk="{id:\'' . $row['STAGEID'] . '\',page:\'stages\'}" data-name="' . $row['SIZESQFT'] . '">' . $row['SIZESQFT'] . '</a></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 35%;">CROWDCAPACITY</td>
                                                    <td><a class="changefield" href="#" data-type="text" data-pk="{id:\'' . $row['CROWDCAPACITY'] . '\',page:\'stages\'}" data-name="' . $row['CROWDCAPACITY'] . '">' . $row['SIZESQFT'] . '</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- end col -->';
                            }
                            ?>
                    </div>

                    <!-- end settings content-->

                </div> <!-- end tab-content -->



                            <div class="tab-pane" id="contacts">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-contacts mr-1"></i>
                                            Venue Contacts</h5></div>
                                    <div class="col-sm-6 text-right">
                                        <a href="#custom-modal" class="btn btn-primary btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Assign New Contact','ajax/ajaxmodalassignnewcontact.php?venueid=<?php echo $_GET['venueid']; ?>');"><i class="mdi mdi-plus-circle mr-1"></i> Assign New Contact</a>
                                    </div></div>
                                <?php



                                if (count($rowcontacts) > 0) {
                                    foreach ($rowcontacts as $contactrow) {
                                        echo '<div class="card">
                                    <div class="card-header"><div class="row"><div class="col-sm-6"><b>' . $contactrow['ROLE'] . '</b></div><div class="col-sm-6 text-right">
                                    <a href="#custom-modal" class="btn btn-danger btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'Are you sure you want to unassign this contact?\',\'ajax/ajaxmodalconfirmdeletion.php?action=unassigncontact&venueid=' . $_GET['venueid'] . '&contactid=' . $contactrow['CONTACTID'] . '\');"><i class="mdi mdi-delete mr-1"></i> Remove</a>
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



            </div> <!-- end card-box-->
        </div>
                    </div>
                <div class="card">
                        <div class="card-body">
                    <?php include('content/components/eventsquery.php'); ?>
                        </div></div>

        </div> <!-- end col -->



    </div>
    <!-- end row-->



