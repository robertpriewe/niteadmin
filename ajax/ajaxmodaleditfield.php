<?php
session_start();

if (!isset($_GET['columnid']) || !isset($_GET['showid'])) {
    echo 'columnid or showid not supplied';
    die;
}
error_reporting(E_ALL);
include ('../modules/sql.php');

include('../content/components/getField.php');

$query = mysqli_query($mysqli, "SELECT * FROM shows_fields_list WHERE ID = " . $_GET['columnid'] . " LIMIT 0, 1");
while($row = $query->fetch_array()) {
    $colname = $row['FIELDNAME'];
    $type = $row['TYPE'];
}

$query = mysqli_query($mysqli, "SELECT * FROM shows_fields WHERE SHOWID = " . $_GET['showid']);
while($row = $query->fetch_array()) {
    $fieldval = $row[$colname];
}
?>
<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <?php
            echo getField($type, $_GET['columnid'], $colname, $fieldval, $_GET['showid']);
            ?>
        </div>

    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
    $('.changefield').editable({
        url: 'ajax/updateshowfield.php?page=showevents',
        disabled: false
    });
    $('.changefield').editable('show');

</script>
