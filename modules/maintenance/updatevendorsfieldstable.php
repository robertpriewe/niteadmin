<?php
include ('../sql.php');

$query = mysqli_query($mysqli, "SELECT * FROM events_vendors_fields_list");

while($row = $query->fetch_array()) {
    mysqli_query($mysqli, "ALTER TABLE events_vendors_fields ADD COLUMN " .$row['FIELDNAME'] . " VARCHAR(300)");
    echo "ALTER TABLE events_vendors_fields ADD COLUMN " .$row['FIELDNAME'] . " VARCHAR(300)<br>";
//    echo $row['FIELDNAME'];
}