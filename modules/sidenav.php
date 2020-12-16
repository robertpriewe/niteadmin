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

        <!-- User box -->
        <div class="user-box text-center">
            <img src="assets/images/users/avatar-1.jpg" alt="user-img" title="Mat Helme"
                 class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-reset dropdown-toggle h5 mt-2 mb-1 d-block"
                   data-toggle="dropdown">Rob</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user mr-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings mr-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock mr-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-reset">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="?page=showartists">
                        <i class="ri-music-line"></i>
                        <span> Artists </span>
                    </a>
                </li>
                <li>
                    <a href="?page=showcontacts" class="waves-effect">
                        <i class="ri-contacts-book-2-line"></i>
                        <span> Contacts </span>
                    </a>
                </li>

                <li>
                    <a href="?page=showevents">
                        <i class="ri-calendar-event-line"></i>
                        <span> Events </span>
                    </a>
                    <?php

                    if (isset($_GET['eventid']) || isset($_GET['setid'])) {

                        echo '
                        <div>
                            <ul class="nav-second-level">
                                <li>Event Selected: <b>' . $eventname . '</b></li>
                                <li>
                                    <a href="?page=eventdetails&eventid=' . $eventid . '"> Event Overview</a>
                                </li>
                                <li>
                                    <a href="?page=timeline&eventid=' . $eventid . '"> Timeline</a>
                                </li>
                                <li>
                                    <a href="?page=booking&eventid=' . $eventid . '"> Booking Table</a>
                                </li>
                                <li>
                                    <a href="?page=advancing&eventid=' . $eventid . '"> Advancing Table</a>
                                </li>
                                <li>
                                    <a href="?page=ridersoverview&eventid=' . $eventid . '"> Event Riders</a>
                                </li>
                                <li>
                                    <a href="?page=venuedetails&venueid=' . $eventid . '"> Venue Details</a>
                                </li>
                                <li>
                                    <a href="?page=showguestlist&eventid=' . $eventid . '"> Guestlist</a>
                                </li>
                                <li>
                                    <a href="?page=showeventshifts&eventid=' . $eventid . '"> Shifts</a>
                                </li>
                                <li>
                                    <a href="?page=showeventvendors&eventid=' . $eventid . '"> Event Vendors</a>
                                </li>
                                <li>
                                    <a href="?page=showeventsponsors&eventid=' . $eventid . '"> Event Sponsors</a>
                                </li>
                            </ul>
                        </div>';
                }
                ?>
                </li>
                <li>
                    <a href="?page=showvenues" class="waves-effect">
                        <i class="ri-building-line"></i>
                        <span> Venues </span>
                    </a>
                </li>

                <li>
                    <a href="?page=showvendors" class="waves-effect">
                        <i class="ri-shopping-bag-line"></i>
                        <span> Vendors </span>
                    </a>
                </li>

                <li>
                    <a href="?page=showsponsors" class="waves-effect">
                        <i class="ri-copper-coin-line"></i>
                        <span> Sponsors </span>
                    </a>
                </li>


                <li>
                    <a href="#sidebarGuestlist" data-toggle="collapse">
                        <i class="ri-file-list-line"></i>
                        <span class="menu-arrow"></span>
                        <span> Guestlist </span>
                    </a>
                    <div class="collapse" id="sidebarGuestlist">
                        <ul class="nav-second-level">
                            <li>
                                <a href="guestlist_minisite/scan.php" target="_BLANK">Scan Tickets</a>
                            </li>
                            <li>
                                <a href="guestlist_minisite/?" target="_BLANK">Check-In Guests</a>
                            </li>
                            <li>
                                <a href="#custom-modal" data-animation="fadein" data-plugin="custommodal" data-overlayColor="#38414a" onclick="javascript:openModal('Select guestlist to export','ajax/ajaxmodalexportguestlist.php');" class="dropdown-item">Export to CSV</a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="menu-title mt-2">Administration</li>


                <li>
                    <a href="#sidebarUserManagement" data-toggle="collapse">
                        <i class="ri-file-user-line"></i>
                        <span class="menu-arrow"></span>
                        <span> User Management </span>
                    </a>
                    <div class="collapse" id="sidebarUserManagement">
                        <ul class="nav-second-level">
                            <li>
                                <a href="?page=usermanagement">Add New User</a>
                            </li>
                            <li>
                                <a href="?page=userlist">User List</a>
                            </li>
                            <li>
                                <a href="?page=listroles">Permissions</a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li>
                    <a href="?page=displaylogs">
                        <i class="ri-newspaper-line"></i>
                        <span> Activity Logs </span>
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
