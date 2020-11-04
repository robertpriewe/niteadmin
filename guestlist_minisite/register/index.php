<?php
if (!isset($_GET['link'])) {
    echo "Link is missing the registration hash";
    die;
}
include('sql.php');

if (isset($_GET['action']) && isset($_POST)) {
    $updateid = [];
    $idcount = 0;
    foreach($_POST as $key => $val) {
        if ($val <> "") {
            $fieldid = explode("-", $key)[1];
            $fieldname = explode("-", $key)[0];
            $updateid[$idcount] = $fieldid;
            $idcount++;
        }
    }

    $group = array();
    foreach ( $updateid as $value ) {
        $group[$value][] = $value;
    }

    foreach ($group as $key => $value) {
        mysqli_query($mysqli, "UPDATE guestlist SET FIRSTNAMEGUEST = '" . $_POST['firstName-' . $key] . "', LASTNAMEGUEST = '" . $_POST['lastName-' . $key] . "', EMAILGUEST = '" . $_POST['email-' . $key] . "' WHERE ID = " . $key . " AND GROUPHASH = '" . $_GET['link'] . "'");
    }
    $saved = "true";
}

$query = mysqli_query($mysqli, "SELECT * FROM guestlist LEFT JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID LEFT JOIN events ON guestlist.EVENTID = events.EVENTID WHERE GROUPHASH = '" . $_GET['link'] . "' ORDER BY ACCESSLEVEL, LASTNAME, FIRSTNAME ASC");

if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $firstname[] = $row['FIRSTNAMEGUEST'];
        $lastname[] = $row['LASTNAMEGUEST'];
        $email[] = $row['EMAILGUEST'];
        $accesslevel[] = $row['ACCESSLEVEL'];
        $tickethash[] = $row['TICKETHASH'];
        $checkin[] = $row['CHECKIN'];
        $eventname = $row['EVENTNAME'];
        $eventstart = $row['EVENTSTARTDATE'];
        $rowscol[] = $row;
    }
} else {
    echo "Your link is damaged or invalid, please contact the event organizer if you believe this is an error";
    die;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Guestlist Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- third party css -->
    <link href="../assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- App css -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<div>
    <?php
    $accessvar = "";
    foreach($rowscol as $rowresult) {
        $accesscount[$rowresult['ACCESSLEVEL']] = 0;
    }
    foreach($rowscol as $rowresult) {
        $accesscount[$rowresult['ACCESSLEVEL']]++;
    }



    ?>

        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Guestlist</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Guestlist for: <?php echo $eventname; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    <?php
    if (isset($saved)) {
        echo ' <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Changes have been saved!
                    </div>
                </div>
            </div>
        </div>';
    }
    ?>
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-secondary" role="alert">
                        Names can be changed until the start of the event!
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <form action="?link=<?php echo $_GET['link']; ?>&action=submit" method="POST">
                    <?php
                    foreach($rowscol as $rowresult) {
                        if ($accessvar <> $rowresult['ACCESSLEVEL']) {
                            if ($accessvar <> "") {
                                echo '
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                            }
                            echo '
                <div class="row">
                    <div class="col-12">
                        <div class="card ribbon-box">
                            <div class="card-body">
                                <div class="ribbon ribbon-purple float-left"><i class="mdi mdi-access-point mr-1"></i> ' . $rowresult['ACCESSLEVEL'] . '</div>
                                <h5 class="text-purple float-right mt-0">' . $rowresult['ACCESSLEVEL'] . ' Slots: ' . $accesscount[$rowresult['ACCESSLEVEL']] . '</h5>
                                <div class="ribbon-content">
                                    <div class="form-row">';
                            $accessvar = $rowresult['ACCESSLEVEL'];
                        }
                        echo '<div class="form-group col-4">
                                            <label class="col-form-label">First Name</label>
                                            <input type="text" class="form-control" name="firstName-' . $rowresult['ID'] . '" placeholder="First Name" value="' . $rowresult['FIRSTNAMEGUEST'] . '">
                                        </div>
                                        <div class="form-group col-4">
                                            <label class="col-form-label">Last Name</label>
                                            <input type="text" class="form-control" name="lastName-' . $rowresult['ID'] . '" placeholder="Last Name" value="' . $rowresult['LASTNAMEGUEST'] . '">
                                        </div>
                                        <div class="form-group col-4">
                                            <label class="col-form-label">E-Mail</label>
                                            <input type="email" class="form-control" name="email-' . $rowresult['ID'] . '" placeholder="E-Mail" value="' . $rowresult['EMAILGUEST'] . '">
                                        </div>';
                    }
                    ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>

            </form>
        </div>

    <div class="col-12">
        <div class="row">
            <div class="col-12">
                &nbsp;
            </div>
        </div>
    </div>
<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>

<!-- Vendor js -->
<script src="../assets/js/vendor.min.js"></script>

<!-- third party js -->
<script src="../assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/libs/datatables/dataTables.bootstrap4.js"></script>
<script src="../assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="../assets/libs/datatables/responsive.bootstrap4.min.js"></script>
<!-- third party js ends -->

<!-- init js -->
<script src="../assets/js/pages/tickets.js"></script>

<!-- App js -->
<script src="../assets/js/app.min.js"></script>

</body>
</html>
