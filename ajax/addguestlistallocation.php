<?php
session_start();
include ('../modules/sql.php');
include ('addtolog.php');
$grouphash = "g" . substr(md5(time() . '$' . $_GET['eventid'] . '#' . rand(1,99999) . $_POST['email'] . '&' . $_POST['firstName']), 0, 31);
$timeloop = 0;
foreach($_POST as $key => $value) {
  //echo "POST parameter '$key' has '$value' <br>";
  if (strpos($key,"access_id_") !== false) {
    if ($value > 0) {
        for($i=1;$i<=$value;$i++) {
            $timeloop++;
            $tickethash = "t" . substr(md5('$' . $_GET['eventid'] . '#' . $_POST['email'] . $i . rand(1,99999) . time() . '&' . $_POST['firstName']), 0, 31);
            mysqli_query($mysqli, "INSERT INTO guestlist (EVENTID, GROUPHASH, ACCESS, TICKETHASH, FIRSTNAME, LASTNAME, EMAIL, NOTES) VALUES ('" . $_GET['eventid'] . "', '" . $grouphash . "', '" . str_replace("access_id_", "", $key) . "', '" . $tickethash . "', '" . $_POST['firstName'] . "', '" . $_POST['lastName'] . "', '" . $_POST['email'] . "', '" . $_POST['notes'] . "')");
            addToLog($_SESSION['USERID'], 'new', 'guestlist', $_GET['eventid'], '', 'FIRSTNAME/LASTNAME', $_POST['firstName'] . ' ' . $_POST['lastname'], 'Added new guestlist slot for ' . $_POST['firstName'] . ' ' . $_POST['lastname'] . '...access: ' . $key . ' - for event: ' . $_GET['eventid']);
        }
  	}
  }
}


//echo "INSERT INTO guestlist (EVENTID, GROUPHASH, ACCESS, TICKETHASH, FIRSTNAME, LASTNAME, EMAIL, NOTES) VALUES ('" . $_GET['eventid'] . "', '" . $grouphash . "', '" . str_replace("access_id_", "", $key) . "', '" . $tickethash . "', '" . $_POST['firstName'] . "', '" . $_POST['lastName'] . "', '" . $_POST['email'] . "', '" . $_POST['notes'] . "')";


$query = mysqli_query($mysqli, "SELECT *, COUNT(guestlist.ID) AS GUESTLISTCOUNT FROM guestlist LEFT JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID LEFT JOIN events ON guestlist.EVENTID = events.EVENTID WHERE GROUPHASH = '" . $grouphash . "' GROUP BY ACCESSLEVEL ORDER BY FIRSTNAME, LASTNAME ASC");
$accesslist = "";
while($row = $query->fetch_assoc()) {
    $eventname = $row['EVENTNAME'];
    $eventsdate = $row['EVENTSTARTDATE'];
    $accesslist .= $row['ACCESSLEVEL'] . ": " . $row['GUESTLISTCOUNT'] . "\n";
    $firstname = $row['FIRSTNAME'];
}

$urlticketallocation = $urlexternal . "register/";

$msg = "Hello " . $firstname . ",

You have been assigned the following guestlist allocation for the event " . $eventname . " on " . $eventsdate . ":

" . $accesslist . "

IMPORTANT: Please use the below link to submit the names of your guests. These can be changed until the event starts.

" . $urlticketallocation . "?link=" . $grouphash . "

Thanks, " . $clientname;
$subject = "Guestlist allocation for event: " . $eventname;
mail($_POST['email'], $subject, $msg, 'From: "' . $clientname . '" <' . $clientemail . '>');
//echo $i + 1 . ' slots added for ' . $_POST['firstName'] . '<br>';
//echo '<a href="../guestlist/?link=' . $grouphash . '">LINK TO MANAGE SLOTS</a>';

//echo '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $grouphash . '">';


?>