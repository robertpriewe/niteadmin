<div class="content-page">
    <div class="content">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">

                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <li class="d-none d-lg-block">
                        <form class="app-search">
                            <div class="app-search-box dropdown">
                                <div class="input-group">
                                    <input type="search" class="form-control" placeholder="Search..." id="top-search" onkeyup="javascript:refreshSearch();">
                                    <div class="input-group-append">
                                        <button class="btn" type="submit">
                                            <i class="fe-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="dropdown-menu dropdown-lg" id="search-dropdown">
                                    <!-- item-->
                                    <div class="dropdown-header noti-title">
                                        <h5 class="text-overflow mb-2" id="searchTitle">Please type some keywords..</h5>
                                    </div>

                                    <div class="notification-list" id="searchBody">

                                    </div>

                                </div>
                            </div>
                        </form>
                    </li>

                    <li class="dropdown d-inline-block d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="fe-search noti-icon"></i>
                        </a>
                        <div class="dropdown-menu dropdown-lg dropdown-menu-right p-0">
                            <form class="p-3">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                            </form>
                        </div>
                    </li>


                    <li class="dropdown d-none d-lg-inline-block">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                            <i class="fe-maximize noti-icon"></i>
                        </a>
                    </li>


                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="<?php if ($_SESSION['USERPHOTO'] == "") { echo 'assets/images/users/avatar-generic.png'; } else { echo $_SESSION['USERPHOTO']; } ?>" alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ml-1">
                                <?php echo $_SESSION['USERNAME'] . ' (' . $_SESSION['ROLENAME'] . ')'; ?> <i class="mdi mdi-chevron-down"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="remixicon-account-circle-line"></i>
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="remixicon-settings-3-line"></i>
                                <span>Settings</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="remixicon-wallet-line"></i>
                                <span>Messages <span class="badge badge-success float-right">3</span> </span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="remixicon-lock-line"></i>
                                <span>Lock Screen</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a href="?logout=true" class="dropdown-item notify-item">
                                <i class="remixicon-logout-box-line"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </li>

                    <?php /*
            <li class="dropdown notification-list">
                <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                    <i class="fe-settings noti-icon"></i>
                </a>
            </li>
*/
                    ?>


                </ul>



                <!-- LOGO -->


                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                            <i class="fe-menu"></i>
                        </button>
                    </li>

                    <li class="dropdown d-none d-lg-block">
                        <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            Create New
                            <i class="mdi mdi-chevron-down"></i>
                        </a>
                        <div class="dropdown-menu">
                            <!-- item-->
                            <a href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Event','ajax/ajaxmodaladdnewevent.php');" class="dropdown-item">
                                <i class="fe-briefcase mr-1"></i>
                                <span>New Event</span>
                            </a>

                            <!-- item-->
                            <a href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Artist','ajax/ajaxmodaladdnewartist.php');" class="dropdown-item">
                                <i class="fe-user mr-1"></i>
                                <span>New Artist</span>
                            </a>

                            <a href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Contact','ajax/ajaxmodaladdnewcontact.php');" class="dropdown-item">
                                <i class="fe-user mr-1"></i>
                                <span>New Contact</span>
                            </a>

                            <a href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Vendor','ajax/ajaxmodaladdnewvendor.php');" class="dropdown-item">
                                <i class="fe-user mr-1"></i>
                                <span>New Vendor</span>
                            </a>

                            <a href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Sponsor','ajax/ajaxmodaladdnewsponsor.php');" class="dropdown-item">
                                <i class="fe-user mr-1"></i>
                                <span>New Sponsor</span>
                            </a>


                            <!-- item-->
                            <a href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Venue','ajax/ajaxmodaladdnewvenue.php');" class="dropdown-item">
                                <i class="fe-headphones mr-1"></i>
                                <span>New Venue</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="fe-bar-chart-line- mr-1"></i>
                                <span>New Expense</span>
                            </a>

                        </div>
                    </li>

                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- end Topbar -->



        <!-- Start Content-->
        <div class="container-fluid">