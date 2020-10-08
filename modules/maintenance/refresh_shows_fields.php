<?php
include ('../sql.php');

$query = mysqli_query($mysqli, "SELECT * FROM shows_fields_list ORDER BY ID ASC");
while($row = $query->fetch_array()) {
    $shows_fields_list[] = $row['FIELDNAME'];
}

$query = mysqli_query($mysqli, "DESCRIBE shows_fields");
while($row = $query->fetch_array()) {
    $shows_fields[] = $row['Field'];
}


foreach ($shows_fields_list AS $key) {
    $addfield[$key] = "1";
    foreach ($shows_fields AS $key2) {
        if ($key == $key2) {
            $addfield[$key] = "0";
        }
    }
}


foreach ($shows_fields AS $key2) {
    $removefield[$key2] = "1";
    foreach ($shows_fields_list AS $key) {
        if ($key == $key2) {
            $removefield[$key] = "0";
        }
    }
}

foreach($addfield AS $key => $val) {
    if($val == "1") {
        $addfields[]=$key;
        mysqli_query($mysqli, "ALTER TABLE shows_fields ADD `" . $key . "` TEXT NOT NULL DEFAULT ''");
    }
}

echo "Adding fields:...";
var_dump($addfields);

foreach($removefield AS $key => $val) {
    if($val == "1") {
        $removefields[]=$key;
        mysqli_query($mysqli, "ALTER TABLE shows_fields DROP `" . $key . "`");
    }
}
echo "<br><br>";
echo "Removing fields:...";
var_dump($removefields);

?>