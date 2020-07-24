<?php
include ('../sql.php');


if ($_GET['table']) {
mysqli_query($mysqli, "TRUNCATE TABLE " . $_GET['table'] . "_fields_list");
$query = mysqli_query($mysqli, "SELECT COLUMN_NAME FROM information_schema.columns WHERE table_name='" . $_GET['table'] . "_fields'");

while($row = $query->fetch_array()) {
	if ($row['COLUMN_NAME'] == 'SHOWID') {
		$hidden = 1;
	} else {
		$hidden = 0;
	}
	$query2 = "INSERT INTO " . $_GET['table'] . "_fields_list (FIELDNAME, TYPE, HIDDEN) VALUES ('" . $row['COLUMN_NAME'] . "', 'TEXT', '" . $hidden . "')";
	echo $query2 . '<br>';
	mysqli_query($mysqli, $query2);
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