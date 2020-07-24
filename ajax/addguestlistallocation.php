<?php
session_start();
include ('../modules/sql.php');

$grouphash = "g" . substr(md5(time() . '$' . $_GET['eventid'] . '#' . rand(1,99999) . $_POST['email'] . '&' . $_POST['firstName']), 0, 31);

foreach($_POST as $key => $value) {
  //echo "POST parameter '$key' has '$value' <br>";
  if (strpos($key,"access_id_") !== false) {
  	if ($value > 0) {
  		for($i=1;$i<=$value;$i++) {
  		$tickethash = "t" . substr(md5('$' . $_GET['eventid'] . '#' . $_POST['email'] . $i . rand(1,99999) . time() . '&' . $_POST['firstName']), 0, 31);
  		mysqli_query($mysqli, "INSERT INTO guestlist (EVENTID, GROUPHASH, ACCESS, TICKETHASH, FIRSTNAME, LASTNAME, EMAIL, NOTES) VALUES ('" . $_GET['eventid'] . "', '" . $grouphash . "', '" . str_replace("access_id_", "", $key) . "', '" . $tickethash . "', '" . $_POST['firstName'] . "', '" . $_POST['lastName'] . "', '" . $_POST['email'] . "', '" . $_POST['notes'] . "')");
  		}
  	}
  }
}

echo "INSERT INTO guestlist (EVENTID, GROUPHASH, ACCESS, TICKETHASH, FIRSTNAME, LASTNAME, EMAIL) VALUES ('" . $_GET['eventid'] . "', '" . $grouphash . "', '" . str_replace("access_id_", "", $key) . "', '" . $tickethash . "', '" . $_POST['firstName'] . "', '" . $_POST['lastName'] . "', '" . $_POST['email'] . "')";

//echo $i + 1 . ' slots added for ' . $_POST['firstName'] . '<br>';
//echo '<a href="../guestlist/?link=' . $grouphash . '">LINK TO MANAGE SLOTS</a>';

//echo '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $grouphash . '">';


?>