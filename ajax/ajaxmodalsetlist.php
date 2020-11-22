<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
if (!isset($_GET['setid'])) {
    echo 'No Set ID provided';
    die;
}
?>
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
            url: 'ajax/assignb2b.php?showidmain=<?php echo $_GET['setid']; ?>&eventid=<?php echo $eventid . $addmainb2b; ?>&showid=' + showid,
            context: document.body
        }).done(function(response) {
            alert(response);
            location.reload();
        }).fail(function() {
            alert("Error");
        });
    }

</script>
