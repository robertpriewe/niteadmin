<?php
session_start();
include ('../../modules/sql.php');



if (!$_GET['QR'] || !$_GET['guestid']) {
  echo 'Your link is invalid';
  mysqli_close($mysqli);
  die;
  //link=mdaCasD
}

if ($_GET['QR'][0] == "g") {
	$query = mysqli_query($mysqli, "UPDATE guestlist SET CHECKIN = NOW() WHERE ID = '" . $_GET['guestid'] . "' AND GROUPHASH = '" . $_GET['QR'] . "'");
} elseif ($_GET['QR'][0] == "t") {
	$query = mysqli_query($mysqli, "UPDATE guestlist SET CHECKIN = NOW() WHERE ID = '" . $_GET['guestid'] . "' AND TICKETHASH = '" . $_GET['QR'] . "'");
} else {
	echo 'Your link is invalid';
	mysqli_close($mysqli);
	die;
}

echo "CHECKED!";
mysqli_close($mysqli);
die;

?>