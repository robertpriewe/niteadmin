<?php
if (!isset($_GET['eventid'])) {
    echo 'No eventid supplied';
    die;
}

$query = mysqli_query($mysqli, "SELECT * FROM booking LEFT JOIN shows_fields_list ON booking.COLUMNID = shows_fields_list.ID ORDER BY COLPOSITION ASC");

$colsquery = array();
$totalbooking = 0;
while($row = $query->fetch_array()) {
    $bookingquery[] = $row;
    $totalbooking++;
}

$query = mysqli_query($mysqli, "SELECT * FROM advancing LEFT JOIN shows_fields_list ON advancing.COLUMNID = shows_fields_list.ID ORDER BY COLPOSITION ASC");

$advancingquery = array();
$totaladvancing = 0;
while($row = $query->fetch_array()) {
    $advancingquery[] = $row;
    $totaladvancing++;
}


$query = mysqli_query($mysqli, "SELECT * FROM shows RIGHT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID RIGHT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID WHERE EVENTID = " . $_GET['eventid']);

$bookingcnt = 0;
$totalartists = 0;
$bookingtext = "";
$advancingcnt = 0;
$advancingtext = "";
while($row = $query->fetch_array()) {
    $count = 0;
    foreach ($bookingquery as $colsrow) {
        if ($row[$colsrow['FIELDNAME']] != "") {
            $count++;
        }
    }
    $percentage = round(($count / $totalbooking)*100, 0);
    $bookingcnt = $bookingcnt + $percentage;
    $bookingtext .= $row['ARTISTNAME'] . " " . $percentage . "%<br>";
    $totalartists++;

    $countadv = 0;
    foreach ($advancingquery as $colsrowadv) {
        if ($row[$colsrowadv['FIELDNAME']] != "") {
            $countadv++;
        }
    }
    $percentageadv = round(($countadv / $totalbooking)*100, 0);
    $advancingcnt = $advancingcnt + $percentageadv;
    $advancingtext .= $row['ARTISTNAME'] . " " . $percentageadv . "%<br>";
}
$bookingavg = round($bookingcnt/$totalartists, 0);
$advancingavg = round($advancingcnt/$totalartists, 0);




?>

<div class="row">
    <div class="col-12">
                <div class="timeline" dir="ltr">

                    <article class="timeline-item">
                        <h2 class="m-0 d-none">&nbsp;</h2>
                        <div class="time-show mt-0">
                            <a href="#" class="btn btn-primary width-lg">Pre-Show</a>
                        </div>
                    </article>

                    <article class="timeline-item timeline-item-left">
                        <div class="timeline-desk">
                            <div class="timeline-box">
                                <span class="arrow-alt"></span>
                                <span class="timeline-icon" style="width: 35px; height: 35px; right: -63px; padding-top:2px;">
                                    <input data-plugin="knob" data-width="30" data-height="30" data-fgColor="#f05050 "
                                           data-bgColor="#F9B9B9" value="<?php echo $bookingavg; ?>" data-displayInput=false
                                           data-skin="tron" data-angleOffset="0" data-readOnly=true
                                           data-thickness=".45">
                                </span>
                                <h4 class="mt-0 font-16"><?php echo '<a href="?page=booking&eventid=' . $_GET['eventid'] . '">'; ?>Booking Table</a></h4>
                                <p class="text-muted"><small><?php echo $bookingavg; ?>% complete</small></p>
                                <p class="mb-0">
                                <?php
                                    echo $bookingtext;
                                ?>
                                </p>
                            </div>
                        </div>
                    </article>

                    <article class="timeline-item">
                        <div class="timeline-desk">
                            <div class="timeline-box">
                                <span class="arrow"></span>
                                <span class="timeline-icon" style="width: 35px; height: 35px; right: -63px; padding-top:2px;">
                                    <input data-plugin="knob" data-width="30" data-height="30" data-fgColor="#f05050 "
                                           data-bgColor="#F9B9B9" value="<?php echo $advancingavg; ?>" data-displayInput=false
                                           data-skin="tron" data-angleOffset="0" data-readOnly=true
                                           data-thickness=".45">
                                </span>
                                <h4 class="mt-0 font-16"><?php echo '<a href="?page=advancing&eventid=' . $_GET['eventid'] . '">'; ?>Advancing Table</a></h4>
                                <p class=" text-muted"><small><?php echo $advancingavg; ?>% Complete</small></p>
                                <p class="mb-0">
                                    <?php
                                    echo $advancingtext;
                                    ?>
                                </p>
                            </div>
                        </div>
                    </article>

                    <article class="timeline-item">
                        <h2 class="m-0 d-none">&nbsp;</h2>
                        <div class="time-show">
                            <a href="#" class="btn btn-primary width-lg">Day of Show</a>
                        </div>
                    </article>

                    <article class="timeline-item timeline-item-left">
                        <div class="timeline-desk">
                            <div class="panel">
                                <div class="timeline-box">
                                    <span class="arrow-alt"></span>
                                    <span class="timeline-icon" style="width: 35px; height: 35px; right: -63px; padding-top:2px;">
                                    <input data-plugin="knob" data-width="30" data-height="30" data-fgColor="#f05050 "
                                           data-bgColor="#F9B9B9" value="20" data-displayInput=false
                                           data-skin="tron" data-angleOffset="0" data-readOnly=true
                                           data-thickness=".45">
                                </span>
                                    <h4 class="mt-0 font-16">Show Checklists</h4>
                                    <p class="text-muted"><small>20%</small></p>
                                    <p class="mb-0">Hardwell - 15% Complete<br>
                                        KAAZE - 25% Complete<br>
                                        Jauz - 18% Complete
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="timeline-item">
                        <div class="timeline-desk">
                            <div class="panel">
                                <div class="timeline-box">
                                    <span class="arrow"></span>
                                    <span class="timeline-icon" style="width: 35px; height: 35px; right: -63px; padding-top:2px;">
                                    <input data-plugin="knob" data-width="30" data-height="30" data-fgColor="#f05050 "
                                           data-bgColor="#F9B9B9" value="35" data-displayInput=false
                                           data-skin="tron" data-angleOffset="0" data-readOnly=true
                                           data-thickness=".45">
                                    </span>
                                    <h4 class="mt-0 font-16">Rider Completion</h4>
                                    <p class="text-muted"><small>35%</small></p>
                                    <p class="mb-0">Hardwell - 45% Complete<br>
                                        KAAZE - 15% Complete<br>
                                        Jauz - 28% Complete
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="timeline-item">
                        <h2 class="m-0 d-none">&nbsp;</h2>
                        <div class="time-show">
                            <a href="#" class="btn btn-primary width-lg">Post Show</a>
                        </div>
                    </article>

                    <article class="timeline-item timeline-item-left">
                        <div class="timeline-desk">
                            <div class="panel">
                                <div class="timeline-box">
                                    <span class="arrow-alt"></span>
                                    <span class="timeline-icon" style="width: 35px; height: 35px; right: -63px; padding-top:2px;">
                                    <input data-plugin="knob" data-width="30" data-height="30" data-fgColor="#f05050 "
                                           data-bgColor="#F9B9B9" value="0" data-displayInput=false
                                           data-skin="tron" data-angleOffset="0" data-readOnly=true
                                           data-thickness=".45">
                                    </span>
                                    <h4 class="mt-0 font-16">Post-Show Surveys</h4>
                                    <p class="text-muted"><small>0%</small></p>
                                    <p class="mb-0">Hardwell - 0% Complete<br>
                                        KAAZE - 0% Complete<br>
                                        Jauz - 0% Complete
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>

                </div>
                <!-- end timeline -->
    </div><!-- end col -->
</div>
