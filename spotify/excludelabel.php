<?php
include ('sql.php');
mysqli_query($mysqli, "INSERT INTO labellist_exclude (label, exclude, added_by) VALUES ('" . $_POST['labelname'] . "', '1', 'SYSTEM')");
echo '';
