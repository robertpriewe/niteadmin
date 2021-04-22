<?php
if (isset($_GET['venueid'])) {
    $wherequery = "WHERE venues.VENUEID = '" . $_GET['venueid'] . "'";
}
elseif(isset($_GET['artistid'])) {
    $wherequery = "WHERE ARTISTPLAYINGID = '" . $_GET['artistid'] . "'";
}
elseif(isset($_GET['eventid'])) {
    $wherequery = "WHERE events.EVENTID = '" . $_GET['eventid'] . "'";
}
else {
    $wherequery = "";
}
if (mysqli_connect_errno()) {
    exit();
}

$query = mysqli_query($mysqli, "SELECT events.EVENTSTARTDATE, events.EVENTENDDATE, events.EVENTSTATUS, shows.ARTISTPLAYINGID, venues.VENUEID, VENUENAME, events.EVENTID, EVENTNAME, COUNT(shows.SHOWID) AS 'SHOWCOUNT', MIN(shows_fields.TIMESTART) AS 'EVENTSTART', MAX(shows_fields.TIMEEND) AS 'EVENTEND', COUNT(DISTINCT stages.STAGEID) AS 'STAGECOUNT' FROM events LEFT JOIN shows ON shows.EVENTID = events.EVENTID LEFT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID LEFT JOIN stages ON stages.STAGEID = shows.STAGEID LEFT JOIN venues ON venues.VENUEID = stages.VENUEID $wherequery GROUP BY EVENTNAME ORDER BY TIMESTART ASC");

//NOT LINKED BY SHOW/EVEN $query = mysqli_query($mysqli, "SELECT venues.VENUEID, VENUENAME, events.EVENTID, EVENTNAME, COUNT(shows.SHOWID) AS 'SHOWCOUNT', MIN(shows_fields.TIMESTART) AS 'EVENTSTART', MAX(shows_fields.TIMEEND) AS 'EVENTEND', COUNT(DISTINCT stages.STAGEID) AS 'STAGECOUNT' FROM events LEFT JOIN venues ON events.VENUEID = venues.VENUEID LEFT JOIN stages ON venues.VENUEID = stages.VENUEID LEFT JOIN shows ON shows.STAGEID = stages.STAGEID LEFT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID $wherequery GROUP BY EVENTNAME ORDER BY EVENTSTART ASC");

if ( $mysqli->errno > 0 ) {
    print "An error occurred: " . $mysqli->error;
    exit;
}


if ($query->num_rows < 0) {
    echo 'NOTHING';
    die;
}
$showsquery = array();
while($row = $query->fetch_array()) {
    $showsquery[] = $row;
}

if (count($showsquery) == 0) {
    echo 'No events found...';
} else {
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10">
                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Event List</h5>
                    </div>
                        <div class="col-lg-2">
                            <div class="text-lg-right mt-3 mt-lg-0">
                                <a href="#custom-modal" data-target="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Event','ajax/ajaxmodaladdnewevent.php');"><i class="mdi mdi-plus-circle mr-1"></i> Add New Event</a>
                            </div>
                        </div>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1">
                    <label class="custom-control-label" for="customSwitch1">Show past events</label>
                </div>
                <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                    <thead class="bg-light">
                    <tr>
                        <th class="font-weight-medium">Event Name</th>
                        <th class="font-weight-medium">Venue</th>
                        <th class="font-weight-medium"># of Sets</th>
                        <th class="font-weight-medium">Status</th>
                        <th class="font-weight-medium">Event Start</th>
                        <th class="font-weight-medium">Event End</th>
                        <th class="font-weight-medium hide-col">PAST/UPCOMING</th>
                    </tr>
                    </thead>

                    <tbody class="font-14">


                    <?php
                    foreach($showsquery as $showsrow) {

                        $setcount = 0;
                        if ($showsrow['EVENTSTARTDATE'] <> "") {
                            $eventstart = date("Y/m/d", strtotime($showsrow['EVENTSTARTDATE']));
                        } else {
                            $eventstart = "";
                        }

                        if ($showsrow['EVENTENDDATE'] <> "") {
                            $eventend = date("Y/m/d", strtotime($showsrow['EVENTENDDATE']));
                        } else {
                            $eventend = "";
                        }

                        if ($showsrow['EVENTSTARTDATE'] == "") {
                            $pastupcoming = "UPCOMING";
                        } else {
                            if (strtotime($showsrow['EVENTSTARTDATE']) < time()) {
                                $pastupcoming = "";
                            } else {
                                $pastupcoming = "UPCOMING";
                            }
                        }

                        if ($showsrow['EVENTSTATUS'] == 'Confirmed') {
                            $statuscolor = 'primary';
                        } elseif ($showsrow['EVENTSTATUS'] == 'Pending') {
                            $statuscolor = 'warning';
                        } elseif ($showsrow['EVENTSTATUS'] == 'Hold') {
                            $statuscolor = 'dark';
                        } elseif ($showsrow['EVENTSTATUS'] == 'Cancelled') {
                            $statuscolor = 'danger';
                        } else {
                            $statuscolor = 'dark';
                        }
                        $eventstatus = '<span class="badge badge-' . $statuscolor . '">' . $showsrow['EVENTSTATUS'] . '</span>';

                        echo '<tr>
                                  
    
                                    <td><a href="?page=eventdetails&eventid=' . $showsrow['EVENTID'] . '">' . $showsrow['EVENTNAME'] . '</a></td>
    
                                    <td><a href="?page=venuedetails&venueid=' . $showsrow['VENUEID'] . '">' . $showsrow['VENUENAME'] . '</a></td>
                                    
                                    <td>' . ($showsrow['SHOWCOUNT'] - 1) . '</td>
    
                                    <td>' . $eventstatus . '</td>
    
                                    <td>' . $eventstart . '</td>
    
                                    <td>' . $eventend . '</td>
    
                                    <td>' . $pastupcoming . '</td>
                                </tr>';
                    }
                    ?>






                    </tbody>
                </table>
                <?php
                }
                ?>
            </div>
        </div>
    </div><!-- end col -->
</div>
