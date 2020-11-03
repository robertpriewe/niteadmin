<?php
include('sql.php');
$query = mysqli_query($mysqli, "SELECT * FROM guestlist LEFT JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID LEFT JOIN events ON guestlist.EVENTID = events.EVENTID WHERE GROUPHASH = '" . $_GET['link'] . "' ORDER BY FIRSTNAME, LASTNAME ASC");

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

<body>

<div>
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

    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="col-3"></div>
                </div>
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
