<?php
session_start();
include('../modules/sql.php');
if (!isset($_SESSION['USERID'])) {
    echo 'Please log in';
    die;
}

if (!isset($_GET['setid'])) {
    echo 'Please supply a set id';
    die;
}

$query = mysqli_query($mysqli, "SELECT * FROM shows LEFT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID RIGHT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID RIGHT JOIN stages ON shows.STAGEID = stages.STAGEID RIGHT JOIN venues ON stages.VENUEID = venues.VENUEID RIGHT JOIN events ON events.EVENTID = shows.EVENTID LEFT JOIN shows_b2b ON shows.SHOWID = shows_b2b.B2BSETID WHERE shows.SHOWID = '" . $_GET['setid'] . "' LIMIT 0, 1");
while ($row = $query->fetch_array()) {
    $rowresults = $row;
}




$query = mysqli_query($mysqli, "SELECT ARTISTNAME, TIMESTART, shows.SHOWID AS SHOWID FROM shows LEFT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID LEFT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID WHERE EVENTID = " . $rowresults['EVENTID'] . " ORDER BY TIMESTART ASC");
$priorartisttemp = "";
$priorartist = "";
$nextartist = "";
$doloop = 1;
while ($row = $query->fetch_array()) {
    if ($doloop == 1) {
        if ($row['SHOWID'] != $_GET['setid']) {
            $priorartisttemp = $row['ARTISTNAME'];
        } elseif ($row['SHOWID'] == $_GET['setid']) {
            $priorartist = $priorartisttemp;
            $doloop = 2;
        }
    } elseif ($doloop == 2) {
        $nextartist = $row['ARTISTNAME'];
        $doloop = 0;
    }
}

if ($nextartist == "") {
    $nextartist = "N/A";
}

if ($priorartist == "") {
    $priorartist = "N/A";
}


$query = mysqli_query($mysqli, 'SELECT * FROM contacts');
while($row = $query->fetch_array()) {
    $listcontactids[] = $row['CONTACTID'];
    $listcontactnames[] = $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];
    if ($row['PHONE'] == "") {
        $listcontactphones[] = "NO PHONE NUMBER FOUND!";
    } else {
        $listcontactphones[] = $row['PHONE'];
    }
}


function convertIdToName($fieldName) {
    global $listcontactids;
    global $listcontactnames;
    global $listcontactphones;
    $arrpos = array_search($fieldName, $listcontactids);
    if ($arrpos != "") {
        return $listcontactnames[$arrpos] . ' - ' . $listcontactphones[$arrpos];
    } else {
        return '';
    }
}

$contacts = "";
if ($rowresults['EVENTTOURMANAGER'] != "") {
    $contacts .= "TM: " . convertIdToName($rowresults['EVENTTOURMANAGER']) . '<br>';
}
if ($rowresults['EVENTPHOTOGRAPHER'] != "") {
    $contacts .= "Photographer: " . convertIdToName($rowresults['EVENTPHOTOGRAPHER']) . '<br>';
}
if ($rowresults['EVENTVJ'] != "") {
    $contacts .= "VJ: " . convertIdToName($rowresults['EVENTVJ']) . '<br>';
}
if ($rowresults['EVENTMANAGER'] != "") {
    $contacts .= "Manager: " . convertIdToName($rowresults['EVENTMANAGER']) . '<br>';
}
if ($rowresults['EVENTAGENT'] != "") {
    $contacts .= "Agent: " . convertIdToName($rowresults['EVENTAGENT']) . '<br>';
}
if ($rowresults['ACCROTHERS'] != "") {
    $contacts .= "Others: " . $rowresults['ACCROTHERS'] . '<br>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Advancing One Sheet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- App css -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="../assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="../assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="loading">
<br>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon ribbon-primary float-left"><i class="mdi mdi-access-point mr-1"></i> Advancing for <?php echo $rowresults['ARTISTNAME']; ?></div>
                        <h5 class="text-dark float-right mt-0"><?php echo $clientname; ?></h5>
                        <div class="ribbon-content">
                            <div class="form-group row">
                                <label class="col-sm-3">ARTIST / EVENT</label>
                                <div class="col-sm-9">
                                    <?php echo $rowresults['ARTISTNAME'] . ' @ ' . $rowresults['EVENTNAME']; ?>
                                </div>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-sm-3">ARTIST CONTACT</label>
                                <div class="col-sm-9">
                                    <?php
                                    if ($rowresults['ARTISTPHONE'] == "") {
                                        $artistphone = "NO ARTIST PHONE NUMBER FOUND";
                                    } else {
                                        $artistphone = $rowresults['ARTISTPHONE'];
                                    }
                                    echo $rowresults['ARTISTFIRSTNAME'] . ' ' . $rowresults['ARTISTLASTNAME'] . ' - '. $artistphone; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">ENTOURAGE CONTACT</label>
                                <div class="col-sm-9">
                                    <?php echo $contacts; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">DATE</label>
                                <div class="col-sm-9">
                                    <?php echo date_format(date_create($rowresults['EVENTSTARTDATE']), 'l, F jS Y'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">VENUE</label>
                                <div class="col-sm-9">
                                    <?php echo $rowresults['VENUENAME']; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">DROPOFF ADDRESS</label>
                                <div class="col-sm-9">
                                    <?php echo $rowresults['DROPOFFADDRESS']; ?>
                                </div>
                            </div>
                        <div class="ribbon ribbon-dark float-left"><i class="mdi mdi-access-point mr-1"></i> CONTACTS</div>
                        <div class="ribbon-content">
                            <div class="form-group row">
                                <label class="col-sm-3">ARTIST RELATIONS</label>
                                <div class="col-sm-9">
                                    <?php echo $rowresults['ARTISTRELATIONS']; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">ARTIST HOSPITALITY</label>
                                <div class="col-sm-9">
                                    <?php echo $rowresults['ARTISTHOSPITALITY']; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">PROUCTION / TECH</label>
                                <div class="col-sm-9">
                                    <?php echo $rowresults['PRODUCTIONTECH']; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">STAGE MANAGER</label>
                                <div class="col-sm-9">
                                    <?php echo $rowresults['STAGEMANAGER']; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">TRANSPORTATION</label>
                                <div class="col-sm-9">
                                    <?php echo $rowresults['TRANSPORTATIONREP']; ?>
                                </div>
                            </div>
                            <div class="ribbon ribbon-dark float-left"><i class="mdi mdi-access-point mr-1"></i> GROUND DETAILS</div>
                            <div class="ribbon-content">
                                <div class="form-group row">
                                    <label class="col-sm-3">CAR</label>
                                    <div class="col-sm-9">
                                        <?php echo $rowresults['CAR']; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3">AIRPORT TO HOTEL</label>
                                    <div class="col-sm-9">
                                        <?php echo $rowresults['AIRPORTTOHOTEL']; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3">HOTEL TO VENUE</label>
                                    <div class="col-sm-9">
                                        <?php echo $rowresults['HOTELTOVENUE']; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3">VENUE TO HOTEL</label>
                                    <div class="col-sm-9">
                                        <?php echo $rowresults['VENUETOHOTEL']; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3">HOTEL TO AIRPORT</label>
                                    <div class="col-sm-9">
                                        <?php echo $rowresults['HOTELTOAIRPORT']; ?>
                                    </div>
                                </div>
                                <div class="ribbon ribbon-dark float-left"><i class="mdi mdi-access-point mr-1"></i> EVENT SCHEDULE</div>
                                <div class="ribbon-content">
                                    <div class="form-group row">
                                        <label class="col-sm-3">SOUNDCHECK</label>
                                        <div class="col-sm-9">
                                            <?php echo date_format(date_create($rowresults['SOUNDCHECKTIME']), 'g:i a'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3">DOORS OPEN</label>
                                        <div class="col-sm-9">
                                            <?php echo date_format(date_create($rowresults['EVENTSTARTDATE']), 'g:i a'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3">STAGE</label>
                                        <div class="col-sm-9">
                                            <?php echo $rowresults['STAGENAME']; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3">ARTIST BEFORE</label>
                                        <div class="col-sm-9">
                                            <?php echo $priorartist; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3">SET TIME</label>
                                        <div class="col-sm-9">
                                            <?php echo date_format(date_create($rowresults['TIMESTART']), 'g:i a'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3">SET DURATION</label>
                                        <div class="col-sm-9">
                                            <?php
                                            $a = date_create($rowresults['TIMEEND']);
                                            $b = date_create($rowresults['TIMESTART']);
                                            echo ($a->getTimestamp() - $b->getTimestamp())/60 . " min";

                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3">ARTIST AFTER</label>
                                        <div class="col-sm-9">
                                            <?php echo $nextartist; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3">CURFEW</label>
                                        <div class="col-sm-9">
                                            <?php echo date_format(date_create($rowresults['EVENTENDDATE']), 'g:i a'); ?>
                                        </div>
                                    </div>
                                    <div class="ribbon ribbon-dark float-left"><i class="mdi mdi-access-point mr-1"></i> TECHNICAL / HOSPITALITY</div>
                                    <div class="ribbon-content">
                                        <div class="form-group row">
                                            <label class="col-sm-3">TECHNICAL / VISUALS / LIGHTING CONFIRMED</label>
                                            <div class="col-sm-9">
                                                <?php
                                                if ($rowresults['TECHNICALRIDER'] != "") {
                                                    $technicalrider = "YES";
                                                } else {
                                                    $technicalrider = "NO";
                                                }
                                                if ($rowresults['VJSPECS'] != "") {
                                                    $visuals = "YES";
                                                } else {
                                                    $visuals = "NO";
                                                }
                                                if ($rowresults['LIGHTINGSPECS'] != "") {
                                                    $lighting = "YES";
                                                } else {
                                                    $lighting = "NO";
                                                }

                                                echo $technicalrider . ' / ' . $visuals . ' / ' . $lighting;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3">HOSPITALITY CONFIRMED</label>
                                            <div class="col-sm-9">
                                                <?php
                                                if ($rowresults['RIDER'] != "") {
                                                    $rider = "YES";
                                                } else {
                                                    $rider = "NO";
                                                }

                                                echo $rider;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<!-- end page -->

<footer class="footer footer-alt">
    <script>document.write(new Date().getFullYear())</script> &copy; NiteAdmin
</footer>
<br>
<!-- Vendor js -->
<script src="../assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="../assets/js/app.min.js"></script>

</body>
</html>