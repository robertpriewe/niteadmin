<div class="row">
    <div class="col-lg-12">
        <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Event List</h5>
    </div>
</div>
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
elseif(isset($_GET['vendorid'])) {
    $wherequery = "RIGHT JOIN events_vendors_link ON events.EVENTID = events_vendors_link.EVENTID WHERE events_vendors_link.VENDORID = '" . $_GET['vendorid'] . "'";
} elseif(isset($_GET['sponsorid'])) {
    $wherequery = "RIGHT JOIN events_sponsors_link ON events.EVENTID = events_sponsors_link.EVENTID WHERE events_sponsors_link.SPONSORID = '" . $_GET['sponsorid'] . "'";
}
else {
    $wherequery = "";
}

$query = mysqli_query($mysqli, "SELECT * FROM shows RIGHT JOIN events ON shows.EVENTID = events.EVENTID RIGHT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID LEFT JOIN stages ON shows.STAGEID = stages.STAGEID RIGHT JOIN venues ON stages.VENUEID = venues.VENUEID $wherequery GROUP BY events.EVENTID ORDER BY TIMESTART ASC");
//echo "SELECT * FROM shows RIGHT JOIN events ON shows.EVENTID = events.EVENTID RIGHT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID LEFT JOIN stages ON shows.STAGEID = stages.STAGEID RIGHT JOIN venues ON stages.VENUEID = venues.VENUEID $wherequery events.EVENTNAME <> '' GROUP BY events.EVENTID ORDER BY TIMESTART ASC";

if ( $mysqli->errno > 0 ) {
    print "An error occurred: " . $mysqli->error;
    exit;
}


if ($query->num_rows > 0) {

while($row = $query->fetch_array()) {
    $showsquery[] = $row;
}
?>
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="customSwitch1">
        <label class="custom-control-label" for="customSwitch1">Show past events</label>
    </div>
    <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
        <thead class="bg-light">
        <tr>
            <th class="font-weight-medium">Event Name</th>
            <th class="font-weight-medium">Venue</th>
            <th class="font-weight-medium">Date</th>
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

            if ($showsrow['EVENTSTARTDATE'] == "") {
                $pastupcoming = "UPCOMING";
            } else {
                if (strtotime($showsrow['EVENTSTARTDATE']) < time()) {
                    $pastupcoming = "";
                } else {
                    $pastupcoming = "UPCOMING";
                }
            }
            echo '<tr>
    
                        <td><a href="?page=eventdetails&eventid=' . $showsrow['EVENTID'] . '">' . $showsrow['EVENTNAME'] . '</a></td>
    
                        <td><a href="?page=venuedetails&venueid=' . $showsrow['VENUEID'] . '">' . $showsrow['VENUENAME'] . '</a></td>
                        
                        <td>' . $eventstart . '</td>
                        <td>' . $pastupcoming . '</td>
    
    
                    </tr>';
        }
    ?>






            </tbody>
        </table>
        <?php
        } else {
            echo 'No events found';
        }

?>
