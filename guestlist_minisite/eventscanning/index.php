<?php
include('sql.php');
if (!isset($_GET['eventid'])) {
    $query = mysqli_query($mysqli, "SELECT * FROM events ORDER BY EVENTSTARTDATE ASC");
    echo 'Select event to manage:<br><br>';
    while ($row = $query->fetch_assoc()) {
        echo  '<a href="?eventid=' . $row['EVENTID'] . '">' . $row['EVENTNAME'] . '</a><br>';
    }
} else {

    $query = mysqli_query($mysqli, "SELECT * FROM guestlist JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID WHERE EVENTID = '" . $_GET['eventid'] . "' ORDER BY FIRSTNAME, LASTNAME ASC");
    $countTotal = $query->num_rows;

if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $showsquery[] = $row;
    }
}
$query = mysqli_query($mysqli, "SELECT EVENTNAME FROM events WHERE EVENTID = '" . $_GET['eventid'] . "' LIMIT 0, 1");
while ($row = $query->fetch_assoc()) {
    $eventname = $row['EVENTNAME'];
}

$query = mysqli_query($mysqli, "SELECT * FROM guestlist JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID WHERE EVENTID = '" . $_GET['eventid'] . "' AND CHECKIN != ''");
$countChecked = $query->num_rows;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo $eventname; ?> - Guestlist Management</title>
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
                <!-- start page title -->
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
                <!-- end page title -->

    <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">

                            <div class="text-center mb-2 d-none d-sm-block">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="card-box">
                                            <i class="fe-tag font-24"></i>
                                            <h3><?php echo $countTotal; ?></h3>
                                            <p class="text-uppercase mb-1 font-13 font-weight-medium">Total</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card-box">
                                            <i class="fe-archive font-24"></i>
                                            <h3 class="text-success"><?php echo $countChecked; ?></h3>
                                            <p class="text-uppercase mb-1 font-13 font-weight-medium">Checked In</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card-box">
                                            <i class="fe-shield font-24"></i>
                                            <h3 class="text-warning"><?php echo ($countTotal - $countChecked); ?></h3>
                                            <p class="text-uppercase mb-1 font-13 font-weight-medium">Unattended</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                                <thead class="bg-light">
                                <tr>
                                    <th class="font-weight-medium">ID</th>
                                    <th class="font-weight-medium">Name</th>
                                    <th class="font-weight-medium">Access</th>
                                    <th class="font-weight-medium">E-Mail</th>
                                    <th class="font-weight-medium">Guest Name</th>
                                    <th class="font-weight-medium">Guest E-Mail</th>
                                    <th class="font-weight-medium">Checked In</th>
                                </tr>
                                </thead>

                                <tbody class="font-14">

                                    <?php
                                    if (count($showsquery) > 0) {
                                    foreach ($showsquery as $showsrow) {
                                        if (is_null($showsrow['CHECKIN']) == TRUE) {
                                            $checkin = '<button class="btn btn-primary" onclick="javascript:checkin(\'' . $showsrow['ID'] . '\');">Check-In</button>';
                                        } else {
                                            $checkin = $showsrow['CHECKIN'];
                                        }
                                        echo '<tr>';
                                        echo '<td>' . $showsrow['ID'] . '</td>';
                                        echo '<td>' . $showsrow['FIRSTNAME'] . ' ' . $showsrow['LASTNAME'] . '</td>';
                                        echo '<td>' . $showsrow['ACCESSLEVEL'] . '</td>';
                                        echo '<td>' . $showsrow['EMAIL'] . '</td>';
                                        echo '<td>' . $showsrow['FIRSTNAMEGUEST'] . ' ' . $showsrow['LASTNAMEGUEST'] . '</td>';
                                        echo '<td>' . $showsrow['EMAILGUEST'] . '</td>';
                                        echo '<td id="checkin-' . $showsrow['ID'] . '">' . $checkin . '</td>';
                                        echo '</tr>';
                                        }
                                    }
                                    ?>




                                </tbody>
                            </table>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
</div>
</div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

<script type="text/javascript">
    function checkin(guestID) {
        var guestID;
        $.ajax({
            type: "GET",
            url: 'ajax/checkin.php?guestid=' + guestID,
            context: document.body
        }).done(function(response) {
            $('#checkin-' + guestID).html('DONE');
            alert(response);
        }).fail(function() {
            alert( "Error" );
        });
    }
</script>

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
<?php
}
?>