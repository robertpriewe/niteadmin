<?php
if (!isset($_GET['artistid'])) {
    echo '<div class="content-page">No artist ID found</div>';
} else {

include ('content/components/getFieldArtist.php');
$query = mysqli_query($mysqli, 'SELECT * FROM artists JOIN contacts ON artists.MANAGERID = contacts.CONTACTID WHERE artists.ARTISTID = ' . $_GET['artistid'] . ' LIMIT 0, 1');
while($row = $query->fetch_array()) {
    $rowartists = $row;
}
$query = mysqli_query($mysqli, 'SELECT * FROM contacts_link JOIN contacts ON contacts_link.CONTACTID = contacts.CONTACTID WHERE LINKTABLE = "artists" AND LINKID = "' . $_GET['artistid'] . '" ORDER BY ORDERID ASC');
$rowcontacts = array();
while($row = $query->fetch_array()) {
    $rowcontacts[] = $row;
}
?>

            <div class="row">
                <div class="col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="<?php if($rowartists['ARTISTPHOTO'] != "") { echo $rowartists['ARTISTPHOTO']; } else { echo 'assets/images/users/avatar-3.jpg'; } ?>" class="rounded-circle avatar-xl img-thumbnail"
                             alt="profile-image">

                        <h4 class="mb-0"><?php echo $rowartists['ARTISTNAME']; ?></h4>
                        <p class="text-muted">Management: <?php echo $rowartists['COMPANY']; ?></p>

                        <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Website</button>

                        <a href="#custom-modal" class="btn btn-danger btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Assign Artist to Event','ajax/ajaxmodaleventlist.php?artistid=<?php echo $_GET['artistid']; ?>');"><i class="mdi mdi-account-badge mr-1"></i> Assign to Event</a>
                        <div class="text-left mt-3">
                            <div class="row">
                                <div class="col-sm-6"><h4 class="font-13 text-uppercase">Artist Info</h4></div>
                                <div class="col-sm-6 text-right"><button type="button" class="btn btn-primary btn-xs waves-effect mb-2 waves-light" onclick="javascript:clickEdit();">Edit</button></div>
                            </div>

                            <p class="text-muted font-13 mb-3">
                            </p>
                            <table>
                                <tr><td><p class="text-muted mb-2 font-13"><strong>Full Name</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2"><a class="changefield" href="#" data-type="text" data-pk="{id:'<?php echo $rowartists['ARTISTID']; ?>',page:'artists'}" data-name="ARTISTFIRSTNAME"><?php echo $rowartists['ARTISTFIRSTNAME']; ?></a> <a class="changefield" href="#" data-type="text" data-pk="{id:'<?php echo $rowartists['ARTISTID']; ?>',page:'artists'}" data-name="ARTISTLASTNAME"><?php echo $rowartists['ARTISTLASTNAME']; ?></a></span></p></td></tr>
                                <tr><td><p class="text-muted mb-2 font-13"><strong>Personal Phone</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2"><?php echo getFieldArtist('ARTISTPHONE', $rowartists['ARTISTPHONE'], $rowartists['ARTISTID']); ?></span></p></td></tr>
                                <tr><td><p class="text-muted mb-2 font-13"><strong>Personal E-Mail</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2"><?php echo getFieldArtist('ARTISTEMAIL', $rowartists['ARTISTEMAIL'], $rowartists['ARTISTID']); ?></span></p></td></tr>
                            </table>

                        </div>



                        <ul class="social-list list-inline mt-3 mb-0">
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-purple text-purple"><i
                                        class="mdi mdi-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                        class="mdi mdi-instagram"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-warning text-warning"><i
                                        class="mdi mdi-snapchat"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                        class="mdi mdi-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-success text-success"><i
                                        class="mdi mdi-spotify"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-warning text-warning"><i
                                        class="mdi mdi-soundcloud"></i></a>
                            </li>
                        </ul>
                    </div> <!-- end card-box -->


                    <div class="card-body">
                        <h4 class="header-title">Notes</h4>
                        <p class="mb-3">Artist notes</p>

                    </div> <!-- end card-box-->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6"><h4 class="font-13 text-uppercase">Spotify Info</h4></div>
                            <div class="col-sm-6 text-right"><a href="#custom-modal" class="btn btn-primary btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Refreshing spotify information','ajax/ajaxrefreshspotifyinfo.php?artistid=<?php echo $_GET['artistid']; ?>');"><i class="mdi mdi-refresh mr-1"></i> Refresh Spotify Info</a></div>
                        </div>
                        <p class="mb-3">
                            <table>
                                <tr><td><p class="text-muted mb-2 font-13"><strong>Genres</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2"><?php echo $rowartists['SPOTIFYGENRES']; ?></span></p></td></tr>
                                <tr><td><p class="text-muted mb-2 font-13"><strong>Followers</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2"><?php echo $rowartists['SPOTIFYFOLLOWERS']; ?></span></p></td></tr>
                                <tr><td><p class="text-muted mb-2 font-13"><strong>Popularity</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2"><?php echo $rowartists['SPOTIFYPOPULARITY']; ?></span></p></td></tr>
                                <tr><td><p class="text-muted mb-2 font-13"><strong>Related Artists</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2"><?php echo $rowartists['SPOTIFYRELATEDARTISTS']; ?></span></p></td></tr>
                        </table>
                        </p>

                    </div> <!-- end card-box-->
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6"><h4 class="mb-4 text-uppercase">Contact History</h4></div>
                            <div class="col-sm-6 text-right"><a href="#custom-modal" class="btn btn-primary btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Log New Activity','ajax/ajaxmodalnewcontactactivity.php?artistid=<?php echo $_GET['artistid']; ?>');">New Contact Activity</a></div>
                        </div>
                        <ul class="list-unstyled timeline-sm">
                        <?php
                        $query = mysqli_query($mysqli, 'SELECT *, contacts.ROLE AS CONTACTROLE, contacts.FIRSTNAME AS CONTACTFIRSTNAME, contacts.LASTNAME AS CONTACTLASTNAME FROM contact_activity LEFT JOIN contacts ON contacts.CONTACTID = contact_activity.CONTACTEDLINKID LEFT JOIN events ON contact_activity.CONTACTEDEVENTID = events.EVENTID LEFT JOIN users ON contact_activity.CONTACTEDUSERID = users.USERID WHERE CONTACTEDARTISTID = ' . $_GET['artistid'] . ' GROUP BY contact_activity.CONTACTEDID ORDER BY TIMESTAMP DESC');

                        if ($query->num_rows == 0) {
                            echo 'No history yet';
                        }

                        while($row = $query->fetch_array()) {
                            $contactlink = '<a href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'View Contact\',\'ajax/ajaxmodalviewcontact.php?contactid=' . $row['CONTACTID'] . '\');">' . $row['CONTACTFIRSTNAME'] . ' ' . $row['CONTACTLASTNAME'] . '</a>';
                            echo '<li class="timeline-sm-item">
                                <span class="timeline-sm-date"><div class="row">' . date("m/d/Y", strtotime($row['TIMESTAMP'])) . '</div><div class="row">' . date("h:i A", strtotime($row['TIMESTAMP'])) . '</div></span>
                                <h5 class="mt-0 mb-1">' . $row['CONTACTEDTYPE'] . ' to ' . $row['CONTACTROLE'] . ' (' . $contactlink . ')</h5>
                                <p>Contacted by ' . $row['USERNAME'] . ' - Event: <a href="?page=eventdetails&eventid=' . $row['EVENTID'] . '">' . $row['EVENTNAME'] . '</a></p>
                                <p class="text-muted mt-2">' . nl2br($row['CONTACTEDNOTE']) . '</p>
                            </li>';
                        }


                        ?>



                        </ul>

                    </div> <!-- end card-box -->
                </div>

                </div> <!-- end col-->

                <div class="col-lg-6 col-xl-6">
                    <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills navtab-bg">
                            <li class="nav-item">
                                <a href="#teaminfo" data-toggle="tab" aria-expanded="true" class="nav-link active ml-0">
                                    <i class="mdi mdi-face-profile mr-1"></i>Team Info
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
                                    <a href="#custom-modal" class="btn btn-primary btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Assign New Contact','ajax/ajaxmodalassignnewcontact.php?artistid=<?php echo $_GET['artistid']; ?>');"><i class="mdi mdi-plus-circle mr-1"></i> Assign New Contact</a>
                                    </div></div>
                                <?php
                                echo '<div class="card">
                                    <div class="card-header"><div class="row"><div class="col-sm-6"><b>Manager</b></div><div class="col-sm-6 text-right">
                                    <a href="#custom-modal" class="btn btn-primary btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'Change Manager\',\'ajax/ajaxmodalassignnewcontact.php?action=change&artistid=' . $_GET['artistid'] . '\');"><i class="mdi mdi-chart-bubble mr-1"></i> Change Manager</a>
                                    </div></div></div>
                                    <div class="card-body">
                                        <blockquote class="card-bodyquote">
                                            <table>
                                                <tr><td><p class="text-muted mb-2 font-13"><strong>Name</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2">' . $rowartists['FIRSTNAME'] . ' ' . $rowartists['LASTNAME'] . '</span></p></td></tr>
                                                <tr><td><p class="text-muted mb-2 font-13"><strong>Company</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2">' . $rowartists['COMPANY'] . '</span></p></td></tr>
                                                <tr><td><p class="text-muted mb-2 font-13"><strong>Phone</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2">' . $rowartists['PHONE'] . '</span></p></td></tr>
                                                <tr><td><p class="text-muted mb-2 font-13"><strong>Email</strong></p></td><td><p class="text-muted mb-2 font-13"><span class="ml-2">' . $rowartists['EMAIL'] . '</span></p></td></tr>
                                                </table>
                                        </blockquote>
                                    </div>
                                </div>';



                                if (count($rowcontacts) > 0) {
                                    foreach ($rowcontacts as $contactrow) {
                                        echo '<div class="card">
                                    <div class="card-header"><div class="row"><div class="col-sm-6"><b>' . $contactrow['ROLE'] . '</b></div><div class="col-sm-6 text-right">
                                    <a href="#custom-modal" class="btn btn-danger btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'Are you sure you want to unassign this contact?\',\'ajax/ajaxmodalconfirmdeletion.php?action=unassigncontact&artistid=' . $_GET['artistid'] . '&contactid=' . $contactrow['CONTACTID'] . '\');"><i class="mdi mdi-delete mr-1"></i> Remove</a>
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
                                <div class="table-responsive">

                                    <?php include('content/components/eventsplayingwidget.php'); ?>
                                </div>

                            </div>
                            <!-- end settings content-->

                        </div> <!-- end tab-content -->
                    </div> <!-- end card-box-->
                    </div>
                </div> <!-- end col -->

<?php
}
?>