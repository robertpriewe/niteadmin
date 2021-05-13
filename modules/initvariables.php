<?php
if (isset($_GET['page'])) {
    if ($_GET['page'] == "guestlist") {
        $title = 'Guestlist';
        $content = 'guestlist';
        $section = "GUESTLIST";
    } elseif ($_GET['page'] == "showvenues") {
        $title = 'Venues List';
        $content = 'showvenues';
        $section = "VENUES";
    } elseif ($_GET['page'] == "eventdetails") {
        $title = 'Event Details';
        $content = 'eventdetails';
        $section = "EVENTS";
    } elseif ($_GET['page'] == "showevents") {
        $title = 'Events List';
        $section = 'EVENTS';
        $content = 'showevents';
    } elseif ($_GET['page'] == "showartists") {
        $title = 'Artists List';
        $content = 'showartists';
        $section = 'ARTISTS';
    } elseif ($_GET['page'] == "showcontacts") {
        $title = 'Contact List';
        $content = 'showcontacts';
        $section = 'CONTACTS';
    } elseif ($_GET['page'] == "artistdetails") {
        $title = 'Artist Details';
        $content = 'artistdetails';
        $section = 'ARTISTS';
    } elseif ($_GET['page'] == "venuedetails") {
        $title = 'Venue Details';
        $content = 'venuedetails';
        $section = 'VENUES';
    } elseif ($_GET['page'] == "vendordetails") {
        $title = 'Vendor Details';
        $content = 'vendordetails';
        $section = 'VENDORS';
    } elseif ($_GET['page'] == "setdetails") {
        $title = 'Set/Show Details';
        $content = 'setdetails';
        $section = 'EVENTS';
    } elseif ($_GET['page'] == "showvendors") {
        $title = 'Vendors List';
        $content = 'showvendors';
        $section = 'VENDORS';
    } elseif ($_GET['page'] == "showguestlist") {
        $title = 'Guestlist';
        $content = 'showguestlist';
        $section = 'GUESTLIST';
    } elseif ($_GET['page'] == "showeventvendors") {
        $title = 'Vendors for Event';
        $content = 'showeventvendors';
        $section = 'VENDORS';
    } elseif ($_GET['page'] == "eventvendordetails") {
        $title = 'Vendor Details for Event';
        $content = 'eventvendordetails';
        $section = 'VENDORS';
    } elseif ($_GET['page'] == "showeventsponsors") {
        $title = 'Sponsors for Event';
        $content = 'showeventsponsors';
        $section = 'SPONSORS';
    } elseif ($_GET['page'] == "eventsponsordetails") {
        $title = 'Sponsor Details for Event';
        $content = 'eventsponsordetails';
        $section = 'SPONSORS';
    } elseif ($_GET['page'] == "showeventemployees") {
        $title = 'Staff for Event';
        $content = 'showeventemployees';
        $section = 'STAFF';
    } elseif ($_GET['page'] == "showeventshifts") {
        $title = 'Master Schedule';
        $content = 'showeventshifts';
        $section = 'STAFF';
    } elseif ($_GET['page'] == "showsponsors") {
        $title = 'Sponsor List';
        $content = 'showsponsors';
        $section = 'SPONSORS';
    } elseif ($_GET['page'] == "sponsordetails") {
        $title = 'Sponsor Details';
        $content = 'sponsordetails';
        $section = 'SPONSORS';
    } elseif ($_GET['page'] == "showcalendar") {
        $title = 'Calendar';
        $content = 'showcalendar';
        $section = 'EVENTS';
        $js = true;
    } elseif ($_GET['page'] == "uploadtest") {
        $title = 'Upload Test';
        $content = 'uploadtest';
        $section = 'GENERAL';
    } elseif ($_GET['page'] == "listrolepermissions") {
        $title = 'Role Permissions';
        $content = 'listrolepermissions';
        $section = 'ADMIN';
    } elseif ($_GET['page'] == "listroles") {
        $title = 'Roles Overview';
        $content = 'listroles';
        $section = 'ADMIN';
    } elseif ($_GET['page'] == "usermanagement") {
        $title = 'User Management';
        $content = 'usermanagement';
        $section = 'ADMIN';
    } elseif ($_GET['page'] == "changepassword") {
        $title = 'Change Password';
        $content = 'changepassword';
        $section = 'GENERAL';
    } elseif ($_GET['page'] == "userlist") {
        $title = 'User List';
        $content = 'userlist';
        $section = 'ADMIN';
    } elseif ($_GET['page'] == "advancing") {
        $title = 'Advancing Table';
        $content = 'advancing';
        $section = 'EVENTS';
    } elseif ($_GET['page'] == "booking") {
        $title = 'Booking Table';
        $content = 'booking';
        $section = 'EVENTS';
    } elseif ($_GET['page'] == "displaylogs") {
        $title = 'Display Logs';
        $content = 'displaylogs';
        $section = 'ADMIN';
    } elseif ($_GET['page'] == "ridersoverview") {
        $title = 'Riders Overview';
        $content = 'ridersoverview';
        $section = 'EVENTS';
    } elseif ($_GET['page'] == "timeline") {
        $title = 'Timeline';
        $content = 'timeline';
        $section = 'EVENTS';
    } elseif ($_GET['page'] == "assignedfields") {
        $title = 'Assigned Fields';
        $content = 'assignedfields';
        $section = 'EVENTS';
    } elseif ($_GET['page'] == "uploadpdf") {
        $title = 'UploadPDF';
        $content = 'uploadpdf';
        $section = 'EVENTS';
    } else {
        $title = 'Page not found';
        $content = 'pagenotfound';
        $_GET['page'] = 'pagenotfound';
        $section = 'GENERAL';
    }
} else {
    $title = 'Events List';
    $content = 'showevents';
    $_GET['page'] = 'showevents';
    $section = 'GENERAL';
}
/*
ARTISTS
CONTACTS
EVENTS
STAFF
SPONSORS
VENDORS
ADMIN
 */
?>