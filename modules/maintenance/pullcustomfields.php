<?php
$mysqli = mysqli_connect("localhost", "youtubed_crmuser", "crmuser", "youtubed_crm");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if ($_GET['table']) {

$query = mysqli_query($mysqli, "SELECT FIELDNAME FROM " . $_GET['table'] . "_fields");

while($row = $query->fetch_array()) {
	$fieldsquery[] = $row['FIELDNAME'];
	//echo $row['FIELDNAME'] . '<br>';
}
$query = mysqli_query($mysqli, "SELECT * FROM shows RIGHT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID RIGHT JOIN stages ON shows.STAGEID = stages.STAGEID RIGHT JOIN venues ON stages.VENUEID = venues.VENUEID LIMIT 0, 1");
while($row = $query->fetch_array()) {
	foreach ($fieldsquery as $key => $value) {
		echo $value . "  - " . $row[$value] . '<br>';
	}
}

echo 'done';

} else {
	echo 'No table specified';
}



/*
$myfile = fopen("debug.txt", "w") or die("Unable to open file!");
$txt = 'update shows set '.mysql_escape_string($name).'="'.mysql_escape_string($value).'" where user_id = "'.mysql_escape_string($pk).'"';
fwrite($myfile, $txt);
$txt = "\n";
fwrite($myfile, $txt);
fclose($myfile);
*/



?>