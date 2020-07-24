<?php
session_start();
include ('../sql.php');

if (!$_GET['QR']) {
  echo 'Your link is invalid';
  mysqli_close($mysqli);
  die;
  //link=mdaCasD
}

if ($_GET['QR'][0] == "g") {
	$query = mysqli_query($mysqli, "SELECT * FROM guestlist RIGHT JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID WHERE guestlist.GROUPHASH = '" . $_GET['QR'] . "'");
} elseif ($_GET['QR'][0] == "t") {
	$query = mysqli_query($mysqli, "SELECT * FROM guestlist RIGHT JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID WHERE guestlist.TICKETHASH = '" . $_GET['QR'] . "'");
} else {
	echo 'Your link is invalid';
	mysqli_close($mysqli);
	die;
}


if ($query->num_rows == 0) {
	echo 'Your link is invalid or expired';
	mysqli_close($mysqli);
	die;
}


while($row = $query->fetch_array()) {
	$showsquery[] = $row;
}
echo '<h2>Number of guests: ' . $query->num_rows . '</h2>';
foreach($showsquery as $showsrow) {
	echo '<div class="form-group row">
    <div class="col-form-label col-sm-8" style="border: 1px #000000 solid;">' . $showsrow['FIRSTNAME'] . ' ' . $showsrow['LASTNAME'] . '</div><div class="col-form-label col-sm-2" style="border: 1px #000000 solid;">' . $showsrow['ACCESSLEVEL'] . '</div><div class="col-form-label col-sm-2" style="border: 1px #000000 solid;">';
	if ($showsrow['CHECKIN'] == NULL) {
		echo '<button type="button" class="btn btn-primary btn-sm" id="checkinButton' . $showsrow['ID'] . '" onclick="javascript:checkin(\'' . $showsrow['ID'] . '\',\'' . $_GET['QR'] . '\');">Check In</button>';
	}
	else {
		echo 'Checked in: ' . $showsrow['CHECKIN'];
	}
	echo '</div></div>';
}


?>

<script type="text/javascript">
function checkin(guestID, QR) {
	var guestID;
	var QR;
	$.ajax({
		url: "ajax/checkinqr.php?QR=" + QR + "&guestid=" + guestID,
		method: "GET"
	}).done(function(ajaxReturn) {
	//alert('loaded');
		$("#checkinButton" + guestID).removeClass("btn-primary").addClass("btn-secondary disabled");
		$("#checkinButton" + guestID).html("Checked-In!");
	});
}
</script>