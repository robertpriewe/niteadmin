<?php
session_start();
include('../../modules/sql.php');
include('getFieldArtist.php');

$query = mysqli_query($mysqli, 'SELECT * FROM shows JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID WHERE shows.SHOWID = ' . $_GET['setid'] . ' LIMIT 0, 1');
while($row = $query->fetch_array()) {
    $rowresults = $row;
}

$query = mysqli_query($mysqli, 'SELECT * FROM contacts');
while($row = $query->fetch_array()) {
    $listcontactids[] = $row['CONTACTID'];
    $listcontactnames[] = $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];
}

function convertIdToName($fieldName) {
    global $listcontactids;
    global $listcontactnames;
    $arrpos = array_search($fieldName, $listcontactids);
    if (is_numeric($arrpos)) {
        return '<a href="?page=showcontacts&contactid=' . $listcontactids[$arrpos] . '">' . $listcontactnames[$arrpos] . '</a>';
    } else {
        return '';
    }
}


?>
<div class="table-responsive">
    <h3>Please select artist entourage for the show:</h3><br>
    <table class="table table-centered table-borderless table-striped mb-0">
        <tbody>
        <?php
        echo '<tr>
            <td style="width: 35%;">Tour Manager</td>
            <td>' . convertIdToName($rowresults['EVENTTOURMANAGER']) . ' <button type="button" class="btn btn-primary btn-xs waves-effect waves-light mr-1" onclick="javascript:openModal(\'Assign contact\',\'ajax/ajaxmodalassigncontactaccreditation.php?fieldname=EVENTTOURMANAGER&setid=' . $_GET['setid'] . '\');"><i class="mdi mdi-pen"></i> Change</button></td>
            </tr>';
        echo '<tr>
            <td style="width: 35%;">Photographer</td>
            <td>' . convertIdToName($rowresults['EVENTPHOTOGRAPHER']) . ' <button type="button" class="btn btn-primary btn-xs waves-effect waves-light mr-1" onclick="javascript:openModal(\'Assign contact\',\'ajax/ajaxmodalassigncontactaccreditation.php?fieldname=EVENTPHOTOGRAPHER&setid=' . $_GET['setid'] . '\');"><i class="mdi mdi-pen"></i> Change</button></td>
            </tr>';
        echo '<tr>
            <td style="width: 35%;">VJ</td>
            <td>' . convertIdToName($rowresults['EVENTVJ']) . ' <button type="button" class="btn btn-primary btn-xs waves-effect waves-light mr-1" onclick="javascript:openModal(\'Assign contact\',\'ajax/ajaxmodalassigncontactaccreditation.php?fieldname=EVENTVJ&setid=' . $_GET['setid'] . '\');"><i class="mdi mdi-pen"></i> Change</button></td>
            </tr>';
        echo '<tr>
            <td style="width: 35%;">Manager</td>
            <td>' . convertIdToName($rowresults['EVENTMANAGER']) . ' <button type="button" class="btn btn-primary btn-xs waves-effect waves-light mr-1" onclick="javascript:openModal(\'Assign contact\',\'ajax/ajaxmodalassigncontactaccreditation.php?fieldname=EVENTMANAGER&setid=' . $_GET['setid'] . '\');"><i class="mdi mdi-pen"></i> Change</button></td>
            </tr>';
        echo '<tr>
            <td style="width: 35%;">Agent</td>
            <td>' . convertIdToName($rowresults['EVENTAGENT']) . ' <button type="button" class="btn btn-primary btn-xs waves-effect waves-light mr-1" onclick="javascript:openModal(\'Assign contact\',\'ajax/ajaxmodalassigncontactaccreditation.php?fieldname=EVENTAGENT&setid=' . $_GET['setid'] . '\');"><i class="mdi mdi-pen"></i> Change</button></td>
            </tr>';
        echo '<tr>
            <td style="width: 35%;">Others</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowresults['ACCROTHERS'] . ',page:\'shows\'}" data-name="ACCROTHERS">' . $rowresults['ACCROTHERS'] . '</td>
            </tr>';
        echo '    </tbody>
</table></div>';
?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-primary editable-submit btn-sm waves-effect waves-light"><i class="mdi mdi-check"></i></button><button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect"><i class="mdi mdi-close"></i></button>';


        $('.changefield').editable({
            url: 'ajax/updateshowfield.php?page=artists',
            disabled: true
        });
    });

    function changeAccreditation(fieldName) {
        var fieldName;
        $.ajax({
            type: "GET",
            url: 'ajax/ajaxmodalassigncontactaccomodation.php?setid=<?php echo $_GET['setid']; ?>&fieldname=' + fieldName,
            context: document.body
        }).done(function(response) {
            alert("Stage assigned");
            location.reload();
        }).fail(function() {
            alert("Error");
        });
    }
</script>

<script src="../../assets/js/app.min.js"></script>