<?php
include ('sql.php');
mysqli_query($mysqli, "INSERT INTO artistlist_exclude (artist, exclude, added_by) VALUES ('" . $_POST['artistname'] . "', '1', 'SYSTEM')");
echo '';
