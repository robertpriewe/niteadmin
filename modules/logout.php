<?php
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
if(isset($_COOKIE['EMAIL']) && isset($_COOKIE['PASSWORD'])) {
    setcookie('EMAIL', null, -1, '/');
    setcookie('PASSWORD', null, -1, '/');
}

session_destroy();
header("Location: ?");
die();
?>