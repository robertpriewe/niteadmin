<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
if (!isset($_GET['setid'])) {
    echo 'No Set ID provided';
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- Plugins css-->
    <link href="../assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="../assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/multiselect/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />


    <!-- App css -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
<br>
<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <h6>Select Artist</h6>
            <select class="form-control select2" id="selectb2b">
                <option>Select</option>
                <?php
                $query = mysqli_query($mysqli, 'SELECT EVENTID FROM shows WHERE SHOWID = ' . $_GET['setid'] . ' LIMIT 0, 1');
                while($row = $query->fetch_array()) {
                    $eventid = $row['EVENTID'];
                }
                $query = mysqli_query($mysqli, 'SELECT * FROM shows RIGHT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID LEFT JOIN shows_b2b ON shows.SHOWID = shows_b2b.B2BSETID LEFT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID WHERE EVENTID = ' . $eventid . ' AND shows.SHOWID <> ' . $_GET['setid'] . ' ORDER BY artists.ARTISTNAME ASC');
                while($row = $query->fetch_array()) {
                    echo '<option value="' . $row['SHOWID'] . '">' . $row['ARTISTNAME'] . '</option>';
                }
                ?>
            </select>
        </div><br>
        <div class="row">
            <button class="btn btn-success" onclick="javascript:runQuery();">Create B2B Set</button>
        </div>
    </div>
</div> <!-- end card-box -->
<?php
if (isset($_GET['b2bid'])) {
    $addmainb2b = "&b2bid=" . $_GET['b2bid'];
} else {
    $addmainb2b = "";
}
?>

<script type="text/javascript">

    function runQuery() {
        var showid = $('#selectb2b').val();
        $.ajax({
            type: "GET",
            url: 'ajax/assignb2b.php?eventid=<?php echo $eventid . $addmainb2b; ?>&showid=' + showid,
            context: document.body
        }).done(function(response) {
            alert(response);
            location.reload();
        }).fail(function() {
            alert("Error");
        });
    }

</script>


<!-- Vendor js -->
<script src="../assets/js/vendor.min.js"></script>

<!-- Plugins Js -->
<script src="../assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="../assets/libs/switchery/switchery.min.js"></script>
<script src="../assets/libs/multiselect/jquery.multi-select.js"></script>
<script src="../assets/libs/jquery-quicksearch/jquery.quicksearch.min.js"></script>
<script src="../assets/libs/select2/select2.min.js"></script>
<script src="../assets/libs/bootstrap-select/bootstrap-select.min.js"></script>
<script src="../assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="../assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>

<!-- init js -->
<script src="../assets/js/pages/form-advanced.init.js"></script>

<!-- App js -->
<script src="../assets/js/app.min.js"></script>

</body>
</html>