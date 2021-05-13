<?php
include ('../sql.php');

$addfields = [];
$removefields = [];

$query = mysqli_query($mysqli, "SELECT * FROM events_fields_list ORDER BY ID ASC");
while($row = $query->fetch_array()) {
    $shows_fields_list[] = $row['FIELDNAME'];
    $fieldtype[$row['FIELDNAME']] = $row['TYPE'];
}


$query = mysqli_query($mysqli, "DESCRIBE events");
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
        if ($fieldtype[$key] == "TEXT") {
            $type = "TEXT NULL DEFAULT ''";
        } elseif ($fieldtype[$key] == "DATETIME") {
            $type = "DATE NULL DEFAULT NULL";
        } elseif ($fieldtype[$key] == "FILE") {
            $type = "TEXT NULL DEFAULT ''";
        }
        mysqli_query($mysqli, "ALTER TABLE events ADD `" . $key . "` " . $type);
        echo "ALTER TABLE events ADD `" . $key . "` " . $type . "<br>";
    }
}

echo "Adding fields:...";

var_dump($addfields);

foreach($removefield AS $key => $val) {
    if($val == "1") {
        $removefields[]=$key;
        mysqli_query($mysqli, "ALTER TABLE events DROP `" . $key . "`");
    }
}
echo "<br><br>";
echo "Removing fields:...";
var_dump($removefields);

?>