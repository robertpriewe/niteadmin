<?php
$whitelist = array(
    '127.0.0.1',
    '::1'
);
if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
        if ($_SERVER["HTTPS"] != "on") {
        header("Location: https://www." . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
}



session_start();
include('modules/initvariables.php');

include('modules/sql.php');
if(isset($_GET['logout'])) {
    include('modules/logout.php');
}
if(isset($_GET['login'])) {
    include('modules/login.php');
}

if (isset($_SESSION['USERID'])) {
    include('modules/header.php');
    include('modules/sidenav.php');
    include('modules/topnav.php');
    include('modules/breadcrumb.php');
    if (isset($_SESSION['ACCESS'][$section]) || $section == "GENERAL") {
        include('content/' . $content . '.php');
    } else {
        echo "Access Denied (Section: " . $section . ")";
    }
    //include('modules/rightbar.php');
    include('modules/footer.php');
    include('modules/js.php');
    if (isset($js)) { include('modules/js/js-' . $_GET['page'] . '.php'); }
    echo '</body></html>';
} else {
    include('modules/login.php');
}
?>