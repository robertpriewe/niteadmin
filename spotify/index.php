<?php
session_start();

include ('sql.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Spotify Plays</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- third party css -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />


    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />


</head>

<body class="loading">

<!-- Begin page -->
<div id="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">

        <!-- LOGO -->
        <div class="logo-box">
            <a href="?" class="logo logo-dark text-center">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm-dark.png" alt="" height="24">
                            <!-- <span class="logo-lg-text-light">Minton</span> -->
                        </span>
                <span class="logo-lg">
                            <img src="assets/images/logo-dark.png" alt="" height="20">
                    <!-- <span class="logo-lg-text-light">M</span> -->
                        </span>
            </a>

            <a href="?" class="logo logo-light text-center">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="" height="24">
                        </span>
                <span class="logo-lg">
                            <img src="assets/images/logo-light.png" alt="" height="20">
                        </span>
            </a>
        </div>

        <div class="h-100" data-simplebar>

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="#sidebarDashboards" data-toggle="collapse" class="waves-effect">
                            <i class="ri-spotify-fill"></i>
                            <span> Spotify Plays </span>
                        </a>

                    </li>


                </ul>

            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Topbar Start -->
            <div class="navbar-custom">
                <div class="container-fluid">

                    <ul class="list-unstyled topnav-menu float-right mb-0">
                    </ul>

                    <!-- LOGO -->
                    <div class="logo-box">
                        <a href="?" class="logo logo-dark text-center">
                                    <span class="logo-sm">
                                        <img src="assets/images/logo-sm-dark.png" alt="" height="24">
                                        <!-- <span class="logo-lg-text-light">Minton</span> -->
                                    </span>
                            <span class="logo-lg">
                                        <img src="assets/images/logo-dark.png" alt="" height="20">
                                <!-- <span class="logo-lg-text-light">M</span> -->
                                    </span>
                        </a>

                        <a href="?" class="logo logo-light text-center">
                                    <span class="logo-sm">
                                        <img src="assets/images/logo-sm.png" alt="" height="24">
                                    </span>
                            <span class="logo-lg">
                                        <img src="assets/images/logo-light.png" alt="" height="20">
                                    </span>
                        </a>
                    </div>

                    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                        <li>
                            <button class="button-menu-mobile waves-effect waves-light">
                                <i class="fe-menu"></i>
                            </button>
                        </li>

                        <li>
                            <!-- Mobile menu toggle (Horizontal Layout)-->
                            <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- end Topbar -->

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title"><i class="ri-spotify-fill"></i> Spotify Plays</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                    <li class="breadcrumb-item active">Spotify Plays</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Daily Plays</h4>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-2">
                                            <select class="form-control select2" id="datelist">
                                                <?php
                                                $sql = "SELECT DATE(asofdate) AS datelist FROM reporting_table WHERE active = 1 GROUP BY datelist ORDER BY datelist DESC";
                                                $query = mysqli_query($mysqli, $sql);
                                                while($row = $query->fetch_array()) {
                                                    echo '<option value="' . $row['datelist'] . '">' . $row['datelist'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-success waves-effect waves-light" type="submit" onclick="javascript:loadTables();">GO</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="playsTable"></div>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>
                <!-- end row-->


            </div> <!-- container -->

        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <script>document.write(new Date().getFullYear())</script> &copy; Nite.ai
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-sm-block">
                            <a href="javascript:void(0);">About Us</a>
                            <a href="javascript:void(0);">Help</a>
                            <a href="javascript:void(0);">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->


<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>

<!-- third party js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
<script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
<!-- third party js ends -->

<!-- Datatables init -->
<script src="assets/js/pages/datatables.init.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>


<script type="text/javascript">
    var seconds = 0;
    var percentage = 0;
    function incrementSeconds() {
        seconds += 1;
        percentage = Math.round((seconds / 90) * 100, 0);
        if (percentage > 99) {
            percentage = 99;
        }
        $('#loadingProgress').css('width', percentage + '%');
        $('#loadingProgress').html(percentage + '%');
    }

    function loadTables() {
        seconds = 0;
        percentage = 0;
        var asofdate = $('#datelist').val();
        $('#playsTable').html('<div class="spinner-border avatar-lg text-primary m-2" role="status"></div>');
        $.ajax({
            type: "GET",
            url: 'ajaxTableReporting.php?asofdate=' + asofdate,
            context: document.body
        }).done(function (response) {
            cancel = 1;
            $('#playsTable').html(response);
        }).fail(function () {
            alert("Error loading list");
        });
    }


    $(document).ready(function () {
        $(".select2").select2({
            maximumSelectionLength: 2
        });
    });
</script>
<script src="assets/libs/select2/js/select2.min.js"></script>

</body>
</html>