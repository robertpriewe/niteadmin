<?php
session_start();
include('../../modules/sql.php');
include('getFieldArtist.php');
    $query = mysqli_query($mysqli, 'SELECT * FROM artists JOIN contacts ON artists.MANAGERID = contacts.CONTACTID WHERE artists.ARTISTID = ' . $_GET['artistid'] . ' LIMIT 0, 1');
while($row = $query->fetch_array()) {
    $rowartists = $row;
}
$query = mysqli_query($mysqli, 'SELECT * FROM contacts_link JOIN contacts ON contacts_link.CONTACTID = contacts.CONTACTID WHERE LINKTABLE = "artists" AND LINKID = "' . $_GET['artistid'] . '" ORDER BY ORDERID ASC');
$rowcontacts = array();
while($row = $query->fetch_array()) {
    $rowcontacts[] = $row;
}
?>
<div class="table-responsive">
<table class="table table-centered table-borderless table-striped mb-0">
    <tbody>
    <?php
    echo '<tr>
            <td style="width: 35%;">Artist Name</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="ARTISTNAME">' . $rowartists['ARTISTNAME'] . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">First Name</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="ARTISTFIRSTNAME">' . $rowartists['ARTISTFIRSTNAME'] . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">Last Name</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="ARTISTLASTNAME">' . $rowartists['ARTISTLASTNAME'] . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">Phone</td>
            <td>' . getFieldArtist('PHONE', $rowartists['PHONE'], $rowartists['ARTISTID']) . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">E-Mail</td>
            <td>' . getFieldArtist('EMAIL', $rowartists['EMAIL'], $rowartists['ARTISTID']) . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">Genre</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="GENRE">' . $rowartists['GENRE'] . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">Website</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="WEBSITE">' . $rowartists['WEBSITE'] . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">Photo</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="ARTISTPHOTO">' . $rowartists['ARTISTPHOTO'] . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">Logo</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="ARTISTLOGO">' . $rowartists['ARTISTLOGO'] . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">Custom Photo</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="ARTISTCUSTOMPHOTO">' . $rowartists['ARTISTCUSTOMPHOTO'] . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">Instagram</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="INSTAGRAM">' . $rowartists['INSTAGRAM'] . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">Twitter</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="TWITTER">' . $rowartists['TWITTER'] . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">Snapchat</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="SNAPCHAT">' . $rowartists['SNAPCHAT'] . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">Soundcloud</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="SOUNDCLOUD">' . $rowartists['SOUNDCLOUD'] . '</td>
            </tr>';
    echo '<tr>
            <td style="width: 35%;">Spotify</td>
            <td><a class="changefield" href="#" data-type="text" data-pk="{id:' .  $rowartists['ARTISTID'] . ',page:\'artists\'}" data-name="SPOTIFY">' . $rowartists['SPOTIFY'] . '</td>
            </tr>';

echo '    </tbody>
</table></div>';
echo '<br><br>
<h4>Contacts</h4> <a href="#custom-modal" class="btn btn-primary btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'Assign New Contact\',\'ajax/ajaxmodalassignnewcontact.php?artistid=' . $_GET['artistid'] . '\');"><i class="mdi mdi-plus-circle mr-1"></i> Assign New Contact</a>';
echo ' <div class="table-responsive"><table class="table table-centered table-borderless table-striped mb-0">
    <tbody>';
    echo '<tr>
            <td style="width: 35%;">Manager</td>';
            if ($rowartists['CONTACTID'] == "0") {
                echo '<td>Unassigned</td>';
            } else {
                echo '<td><a href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'View Contact\',\'ajax/ajaxmodalviewcontact.php?contactid=' . $rowartists['CONTACTID'] . '\');">' . $rowartists['FIRSTNAME'] . ' ' . $rowartists['LASTNAME'] . ' (', $rowartists['COMPANY'] . ')</a></td>';
            }
            echo '<td><a href="#custom-modal" class="btn btn-primary btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'Change Manager\',\'ajax/ajaxmodalassignnewcontact.php?action=change&artistid=' . $_GET['artistid'] . '\');"><i class="mdi mdi-chart-bubble mr-1"></i> Change Manager</a></td></tr>';
    foreach ($rowcontacts as $contactrow) {
        echo '<tr>
            <td style="width: 35%;">' . $contactrow['ROLE'] . '</td>
            <td><a href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'View Contact\',\'ajax/ajaxmodalviewcontact.php?contactid=' . $contactrow['CONTACTID'] . '\');">' . $contactrow['FIRSTNAME'] . ' ' . $contactrow['LASTNAME'] . ' (' , $contactrow['COMPANY'] . ')</a></td>
            <td><a href="#custom-modal" class="btn btn-danger btn-xs waves-effect mb-2 waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'Are you sure you want to unassign this contact?\',\'ajax/ajaxmodalconfirmdeletion.php?action=unassigncontact&artistid=' . $_GET['artistid'] . '&contactid=' . $contactrow['CONTACTID'] . '\');"><i class="mdi mdi-delete mr-1"></i> Unassign</a></td></tr>';
    }
    ?>
    </tbody>
</table>
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
</script>

<script src="../../assets/js/app.min.js"></script>