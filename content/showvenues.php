<?php
$query = mysqli_query($mysqli, "SELECT *, (COUNT(DISTINCT stages.STAGEID)-1) AS STAGECOUNT, COUNT(DISTINCT events.EVENTID) AS EVENTCOUNT FROM venues LEFT JOIN stages ON venues.VENUEID = stages.VENUEID LEFT JOIN shows ON stages.STAGEID = shows.STAGEID LEFT JOIN events ON shows.EVENTID = events.EVENTID GROUP BY VENUENAME ORDER BY VENUENAME ASC");

if ($query->num_rows > 0) {
    while($row = $query->fetch_assoc()) {
        $venuesquery[] = $row;
    }
} else {
    $venuesquery = array();
}


?>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-8"></div>
                        <div class="col-lg-4">
                            <div class="text-lg-right mt-3 mt-lg-0">
                                <button type="button" class="btn btn-success waves-effect waves-light mr-1"><i class="mdi mdi-database-settings"></i></button>
                                <a href="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Venue','ajax/ajaxmodaladdnewvenue.php');"><i class="mdi mdi-plus-circle mr-1"></i> Add New</a>
                            </div>
                        </div><!-- end col-->
                    </div> <!-- end card-box -->
                </div><!-- end col-->
            </div><br>
            <!-- end row -->

            <div class="row">
            <?php
if (count($venuesquery) > 0) {
    foreach ($venuesquery as $venuesrow) {

        if ($venuesrow['VENUEPHOTO'] != "") {
            $venuephoto = $venuesrow['VENUEPHOTO'];
        } else {
            $venuephoto = 'assets/images/small/img-5.jpg';
        }

        //<img src="" alt="logo" class="avatar-xl rounded-circle mb-3">
        echo '
                <div class="col-md-4">
                    <div class="card">
                       <img class="card-img-top img-fluid" src="' . $venuephoto . '" alt="">
                        <div class="text-center">
                            
                            <h4 class="mb-1">' . $venuesrow['VENUENAME'] . '</h4>
                            <p class="text-muted">Capacity: ' . $venuesrow['VENUECAPACITY'] . '</p>
                        </div>

                        <p class="font-14 text-center text-muted">
                            Venue details..
                        </p>

                        <div class="text-center">
                            <a href="?page=venuedetails&venueid=' . $venuesrow['VENUEID'] . '" class="btn btn-sm btn-secondary">View more info</a>
                        </div>

                        <div class="row mt-5 text-center">
                            <div class="col-6">
                                <h5 class="font-weight-normal text-muted">Stages</h5>
                                <h3 class="m-b-30">' . $venuesrow['STAGECOUNT'] . '</h3>
                            </div>
                            <div class="col-6">
                                <h5 class="font-weight-normal text-muted">Events</h5>
                                <h3 class="m-b-30">' . $venuesrow['EVENTCOUNT'] . '</h3>
                            </div>
                        </div>

                        <div id="company-1" class="text-center"></div>

                    </div>
                </div><!-- end col -->';
    }
}
    ?>

