<?php
function addToLog($userid, $action, $section, $eventname, $artistname, $fieldname, $newvalue, $description) {
    global $mysqli;
    mysqli_query($mysqli,"INSERT INTO logs (USERID, ACTION, SECTION, EVENTNAME, ARTISTNAME, FIELDNAME, NEWVALUE, DESCRIPTION) VALUES ('" . $userid . "', '" . $action . "', '" . $section . "', '" . $eventname . "', '" . $artistname . "', '" . $fieldname . "', '" . $newvalue . "', '" . $description . "')");
}

?>