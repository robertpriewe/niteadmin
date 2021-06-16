<?php
if (isset($_GET['venueid'])) {
    $wherequery = "WHERE venues.VENUEID = '" . $_GET['venueid'] . "' AND";
    echo '<br><br><br>Please supply eventid!';
    die;
}
elseif(isset($_GET['artistid'])) {
    $wherequery = "WHERE ARTISTID = '" . $_GET['artistid'] . "' AND";
    echo '<br><br><br>Please supply eventid!';
    die;
}
elseif(isset($_GET['eventid'])) {
    $wherequery = "WHERE events.EVENTID = '" . $_GET['eventid'] . "' AND";
    $wherequery2 = "WHERE EVENTID = '" . $_GET['eventid'] . "' AND ARTISTPLAYINGID != 0";

}
else {
    $wherequery = "WHERE";
    $wherequery2 = "";
    echo '<br><br><br>Please supply eventid!';
    die;
}

function generateIniitals(string $name) : string {
    $words = explode(' ', $name);
    if (count($words) >= 2) {
        return strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
    }
    return $this->makeInitialsFromSingleWord($name);
}

function makeInitialsFromSingleWord(string $name) : string {
    preg_match_all('#([A-Z]+)#', $name, $capitals);
    if (count($capitals[1]) >= 2) {
        return substr(implode('', $capitals[1]), 0, 2);
    }
    return strtoupper(substr($name, 0, 2));
}

include ('content/components/getField.php');
include ('content/components/getFieldDescription.php');
include ('content/components/assignFieldList.php');

$totalfeeoverdue = 0;
$totaldepositoverdue = 0;
$totalfeepaid = 0;
$totaldepositpaid = 0;
include('content/components/getPaymentInfo.php');

include ('content/components/convertContactIdToName.php');

//OLDWORKING $query = mysqli_query($mysqli, "SELECT TIMESTART, TIMEEND, ARTISTNAME, STAGENAME, VENUENAME, shows.SHOWID, EVENTNAME, ARTISTID, stages.STAGEID, venues.VENUEID FROM shows LEFT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID LEFT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID LEFT JOIN stages ON shows.STAGEID = stages.STAGEID LEFT JOIN venues ON stages.VENUEID = venues.VENUEID LEFT JOIN events ON venues.VENUEID = events.VENUEID " . $wherequery);

$countshowq = mysqli_query($mysqli, "SELECT SHOWID FROM shows " . $wherequery2);
//OLDWORKING $countshowq = mysqli_query($mysqli, "SELECT SHOWID FROM shows LEFT JOIN stages ON shows.STAGEID = stages.STAGEID RIGHT JOIN venues ON venues.VENUEID = stages.VENUEID RIGHT JOIN events ON events.VENUEID = venues.VENUEID " . $wherequery2);
$countstageq = mysqli_query($mysqli, "SELECT STAGEID FROM shows " . $wherequery2 . " GROUP BY STAGEID");
//OLDWORKING $countstageq = mysqli_query($mysqli, "SELECT stages.STAGEID FROM shows LEFT JOIN stages ON shows.STAGEID = stages.STAGEID RIGHT JOIN venues ON venues.VENUEID = stages.VENUEID RIGHT JOIN events ON events.VENUEID = venues.VENUEID " . $wherequery2 . " AND stages.UNASSIGNEDSTAGE = 0 GROUP BY stages.STAGEID");

$setcount = $countshowq->num_rows;
$stagecount = $countstageq->num_rows - 1;

$query = mysqli_query($mysqli, "SELECT *, shows.SHOWID AS SHOWIDFULL FROM shows LEFT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID LEFT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID LEFT JOIN stages ON shows.STAGEID = stages.STAGEID LEFT JOIN venues ON stages.VENUEID = venues.VENUEID LEFT JOIN events ON shows.EVENTID = events.EVENTID LEFT JOIN shows_b2b ON shows.SHOWID = shows_b2b.B2BSETID " . $wherequery . " shows.ARTISTPLAYINGID != 0");

if ($query->num_rows > 0) {
    while($row = $query->fetch_assoc()) {
        $showsquery[] = $row;
    }
    $eventname = $showsquery[0]['EVENTNAME'];
    $venuename = $showsquery[0]['VENUENAME'];
} else {
    $showsquery = array();
    $eventnamequery = mysqli_query($mysqli, "SELECT * FROM events WHERE EVENTID = '" . $_GET['eventid'] . "' LIMIT 0, 1");
    while($row2 = $eventnamequery->fetch_assoc()) {
        $eventname = $row2['EVENTNAME'];
        $venuename = "";
    }
}

//$query = mysqli_query($mysqli, "SELECT TIMESTART, TIMEEND, ARTISTNAME, STAGENAME, VENUENAME, shows.SHOWID, EVENTNAME, ARTISTID, stages.STAGEID, venues.VENUEID, COUNT(shows.SHOWID) AS 'SETCOUNT', COUNT(stages.STAGEID) AS 'STAGECOUNT' FROM shows LEFT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID LEFT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID LEFT JOIN stages ON shows.STAGEID = stages.STAGEID LEFT JOIN venues ON stages.VENUEID = venues.VENUEID LEFT JOIN events ON shows.EVENTID = events.EVENTID " . $wherequery . " shows.ARTISTPLAYINGID != 0");
include("content/components/b2blogic.php");







$query = mysqli_query($mysqli, "SELECT *, events_fields_list.ID AS FIELDID FROM events_fields_list LEFT JOIN events_fields_categories ON events_fields_list.FIELDNAME_CATEGORY = events_fields_categories.ID WHERE HIDDEN = '0' ORDER BY events_fields_list.POSITION, events_fields_list.ID ASC");
while($row = $query->fetch_array()) {
    $fieldsquery[] = $row['FIELDNAME'];
    $fieldsdescription[] = $row['FIELDNAME_TEXT'];
    $fieldscategory[] = $row['CATEGORY'];
    $fieldstype[] = $row['TYPE'];
    $fieldsid[] = $row['FIELDID'];
    $fieldspermission[] = $row['PERMISSION'];
    $dropdownvalues[] = $row['FIELDVALUES'];
}

$query = mysqli_query($mysqli, "SELECT * FROM events WHERE EVENTID = '" . $_GET['eventid'] . "' LIMIT 0, 1");
while ($row = $query->fetch_array()) {
    $rowresults = $row;
}


$query = mysqli_query($mysqli, "SELECT CONCAT(FIRSTNAME, ' ', LASTNAME) AS NAME, permissions_roles.ROLENAME, USERID FROM users LEFT JOIN permissions_roles ON users.ROLE = permissions_roles.ROLEID");
while ($row = $query->fetch_array()) {
    $listusername[] = $row['NAME'];
    $listrole[] = $row['ROLENAME'];
    $listuserid[] = $row['USERID'];
}



$query = mysqli_query($mysqli, "SELECT * FROM `events_assigned_users` LEFT JOIN events_fields_list ON events_assigned_users.FIELDID = events_fields_list.ID RIGHT JOIN users ON events_assigned_users.USERID = users.USERID WHERE EVENTID = '" . $_GET['eventid'] . "'");
while ($row = $query->fetch_array()) {
    $assignedusers_fieldname[] = $row['FIELDNAME'];
    $assignedusers_fieldid[] = $row['FIELDID'];
    $assignedusers_name[] = $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];
    $assignedusers_userid[] = $row['USERID'];
}
?>


<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->


            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                            <div class="col-lg-7">
                                <ul class="nav nav-pills navtab-bg">
                                    <li class="nav-item">
                                        <a href="#setdetails" data-toggle="tab" aria-expanded="true" class="nav-link active ml-0" id="navsetdetails">
                                            <i class="mdi mdi-face-profile mr-1"></i>Artist Overview
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#eventdetails" data-toggle="tab" aria-expanded="false" class="nav-link" id="naveventdetails">
                                            <i class="mdi mdi-star-outline mr-1"></i>Event Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#production" data-toggle="tab" aria-expanded="false" class="nav-link" id="navproduction">
                                            <i class="mdi mdi-track-light mr-1"></i>Production
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#operations" data-toggle="tab" aria-expanded="false" class="nav-link" id="navoperations">
                                            <i class="mdi mdi-domain mr-1"></i>Operations
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#marketing" data-toggle="tab" aria-expanded="false" class="nav-link" id="navmarketing">
                                            <i class="mdi mdi-bullhorn mr-1"></i>Marketing
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-5">
                                <div class="text-lg-right mt-3 mt-lg-0">
                                    <a href="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Set','ajax/ajaxmodalassignartist.php?eventid=<?php echo $_GET['eventid']; ?>');"><i class="mdi mdi-plus-circle mr-1"></i> Assign New Artist</a>
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="?page=showeventvendors&eventid=<?php echo $_GET['eventid']; ?>"><i class="ri-shopping-bag-line mr-2 text-muted font-18 vertical-middle"></i>Vendors</a>
                                            <a class="dropdown-item" href="?page=showeventsponsors&eventid=<?php echo $_GET['eventid']; ?>"><i class="ri-copper-coin-line mr-2 text-muted font-18 vertical-middle"></i>Sponsors</a>
                                            <a class="dropdown-item" href="?page=showeventshifts&eventid=<?php echo $_GET['eventid']; ?>"><i class="ri-group-line mr-2 text-muted font-18 vertical-middle"></i>Staff Shifts</a>
                                            <a class="dropdown-item" href="?page=advancing&eventid=<?php echo $_GET['eventid']; ?>"><i class="ri-checkbox-circle-line mr-2 text-muted font-18 vertical-middle"></i>Advancing</a>
                                            <a class="dropdown-item" href="?page=showguestlist&eventid=<?php echo $_GET['eventid']; ?>"><i class="ri-file-list-line mr-2 text-muted font-18 vertical-middle"></i>Guestlist</a>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col-->
                        </div> <!-- end row -->
                        </div>
                    </div> <!-- end card-box -->
                </div><!-- end col-->
            </div> <!-- end row -->



            <div class="row">
                <div class="col-lg-12 col-xl-12">

                    <div class="card">
                        <div class="card-body">
                        <div class="tab-content">

                            <div class="tab-pane show active" id="setdetails">
                                <div class="text-center mb-2">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-3">
                                            <div class="card-box">
                                                <i class="fe-tag font-24"></i>
                                                <h3><?php echo $setcount; ?></h3>
                                                <p class="text-uppercase mb-1 font-13 font-weight-medium">Total Sets</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-3">
                                            <div class="card-box">
                                                <i class="fe-archive font-24"></i>
                                                <h3><?php echo $stagecount; ?></h3>
                                                <p class="text-uppercase mb-1 font-13 font-weight-medium"># of Stages</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-3">
                                            <div class="card-box">
                                                <i class="fe-shield font-24"></i>
                                                <h3 class="text-success" id="textPaid">0</h3>
                                                <p class="text-uppercase mb-1 font-13 font-weight-medium">Paid</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-3">
                                            <div class="card-box">
                                                <i class="fe-delete font-24"></i>
                                                <h3 class="text-danger" id="textOverdue">0</h3>
                                                <p class="text-uppercase mb-1 font-13 font-weight-medium">Total Overdue</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                                    <thead class="bg-light">
                                    <tr>
                                        <th class="font-weight-medium">Artist</th>
                                        <th class="font-weight-medium">Stage</th>
                                        <th class="font-weight-medium">Offer</th>
                                        <th class="font-weight-medium">Deposit / Guarantee</th>
                                        <th class="font-weight-medium">B2B</th>
                                        <th class="font-weight-medium">Set Start</th>
                                    </tr>
                                    </thead>

                                    <tbody class="font-14">

                                    <?php
                                    if (count($showsquery) > 0) {
                                        foreach ($showsquery as $showsrow) {
                                            if ($showsrow['TIMESTART'] <> "") {
                                                $eventstart = date("Y/m/d h:i A", strtotime($showsrow['TIMESTART']));
                                            } else {
                                                $eventstart = "";
                                            }

                                            if ($showsrow['TIMEEND'] <> "") {
                                                $eventend = date("Y/m/d h:i A", strtotime($showsrow['TIMEEND']));
                                            } else {
                                                $eventend = "";
                                            }

                                            if ($showsrow['ARTISTPHOTO'] != "") {
                                                $photo =  $showsrow['ARTISTPHOTO'];
                                            } else {
                                                $photo = 'assets/images/users/avatar-3.jpg';
                                            }

                                            if (isset($showsrow['OFFER'])) {
                                                $infosheet = '<span class="badge badge-success">Uploaded</span>';
                                            } else {
                                                $infosheet = '<span class="badge badge-dark">Pending</span>';
                                            }

                                            echo '<tr>
                                                    <td>
                                                        <a href="?page=setdetails&setid=' . $showsrow['SHOWIDFULL'] . '" class="text-dark">
                                                            <img src="' . $photo . '" alt="contact-img" title="contact-img" class="avatar-sm rounded-circle img-thumbnail" />
                                                            <span class="ml-2">' . $showsrow['ARTISTNAME'] . '</span>
                                                        </a>
                                                    </td>
                    
                                                    <td>' . $showsrow['STAGENAME'] . '</td>
                                                    
                                                    <td>
                                                        ' . $infosheet . '
                                                    </td>
                    
                                                    <td>
                                                        ' . getPaymentInfo($showsrow['DEPOSITDUEDATE'], $showsrow['DEPOSITPAYMENTDATE'], $showsrow['GUARANTEEFEEDUEDATE'], $showsrow['GUARANTEEFEEPAYMENTDATE']) . '
                                                    </td>
                                                    
                                                    <td>' . b2blogic($showsrow['B2BID'], $showsrow['SHOWIDFULL'], $showsrow['ARTISTNAME'], "NA") . '</td>
                    
                                                    <td>' . $eventstart . '</td>
                    
                                                </tr>';
                                            /*                      <td>
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
                                            */
                                        }
                                    }
                                    ?>

                                    </tbody>
                                </table>

                            </div>
                            <div class="tab-pane" id="eventdetails">
                                <div class="row">
                                    <div class="col-lg-8">
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="text-lg-right mt-3 mt-lg-0">
                                            <button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="javascript:clickEdit();"><i class="mdi mdi-pencil"></i> Edit</button>
                                        </div>
                                    </div><!-- end col-->
                                </div>
                                <br>
                                <?php
                                $currentcategory = 'EVENTDETAILS';
                                include('content/components/fieldstable.php'); ?>
                            </div>

                            <div class="tab-pane" id="production">
                                <div class="row">
                                    <div class="col-lg-8">
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="text-lg-right mt-3 mt-lg-0">
                                            <button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="javascript:clickEdit();"><i class="mdi mdi-pencil"></i> Edit</button>
                                        </div>
                                    </div><!-- end col-->
                                </div>
                                <br>
                                <?php
                                $currentcategory = 'PRODUCTION';
                                include('content/components/fieldstable.php'); ?>
                            </div>

                            <div class="tab-pane" id="operations">
                                <div class="row">
                                    <div class="col-lg-8">
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="text-lg-right mt-3 mt-lg-0">
                                            <button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="javascript:clickEdit();"><i class="mdi mdi-pencil"></i> Edit</button>
                                        </div>
                                    </div><!-- end col-->
                                </div>
                                <br>
                                <?php
                                $currentcategory = 'OPERATIONS';
                                include('content/components/fieldstable.php'); ?>
                            </div>


                            <div class="tab-pane" id="marketing">
                                <div class="row">
                                    <div class="col-lg-8">
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="text-lg-right mt-3 mt-lg-0">
                                            <button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="javascript:clickEdit();"><i class="mdi mdi-pencil"></i> Edit</button>
                                        </div>
                                    </div><!-- end col-->
                                </div>
                                <br>
                                <?php
                                $currentcategory = 'MARKETING';
                                include('content/components/fieldstable.php'); ?>
                            </div>




                        </div> <!-- end tab-content -->
                    </div> <!-- end card-box-->

                    <?php
                    /*
                     <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <div class="card-box"><h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i>
                                    Bottom box</h5>
                                <div class="table-responsive">
                                    test
                                </div>
                            </div>
                        </div>
                    </div>
                     */
                    ?>


</div>
                </div> <!-- end col -->
            </div>  <!-- end row-->

<?php
$totaloverdue = $totalfeeoverdue + $totaldepositoverdue;
$totalpaid = $totalfeepaid + $totaldepositpaid;
echo '<script type="text/javascript">
document.getElementById("textOverdue").innerHTML = "' . $totaloverdue . '";
document.getElementById("textPaid").innerHTML = "' . $totalpaid . '";
</script>
';
?>