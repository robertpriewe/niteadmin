
<?php
include ('content/components/getField.php');
include ('content/components/getFieldDescription.php');
$query = mysqli_query($mysqli, "SELECT FIELDNAME FROM shows_fields_list WHERE FIELDNAME != 'SHOWID'");
$caseconstructor = "";
while ($row = $query->fetch_array()) {
    $caseconstructor .= " WHEN shows_fields_list.FIELDNAME = '" . $row['FIELDNAME'] . "' THEN shows_fields." . $row['FIELDNAME'] . " ";
}


$query = mysqli_query($mysqli, "SELECT shows_assigned_users.*, shows_fields_list.*, events.*, artists.*, (
CASE " . $caseconstructor . " 
    END
) AS FIELDVALUE FROM shows_assigned_users 
LEFT JOIN shows_fields_list ON shows_assigned_users.FIELDID = shows_fields_list.ID
LEFT JOIN shows_fields ON shows_assigned_users.SHOWID = shows_fields.SHOWID
LEFT JOIN shows ON shows_assigned_users.SHOWID = shows.SHOWID
LEFT JOIN events ON shows.EVENTID = events.EVENTID
LEFT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID
WHERE USERID = '" . $_SESSION['USERID'] . "' ORDER BY SHOWID, POSITION ASC");

if ($query->num_rows <= 0) {
echo '<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">No fields have been assigned to you yet
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
} else {
    echo '<div class="text-lg-right mt-3 mt-lg-0">
    <button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="javascript:clickEdit();"><i class="mdi mdi-settings"></i> Edit</button>
</div>';
    $prioreventname = "";
    $i = 0;
    while ($row = $query->fetch_array()) {
        //echo 'Userid:' . $row['USERID'] . ' - Eventid:' . $row['EVENTNAME'] . ' Artistname:' . $row['ARTISTNAME'] . ' - Fieldname:' . $row['FIELDNAME'] . ' - Fieldval:' . $row['FIELDVALUE'] . '<br>';
        if ($row['EVENTNAME'] != $prioreventname) {
            if ($i != 0) {
                echo '
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
            }
            echo '
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="custom-accordion">
                            <div class="mt-4">
                                <h5 class="position-relative mb-0"><a href="#taskcollapse' . $i . '" class="text-dark d-block collapsed" data-toggle="collapse">' . $row['EVENTNAME'] . ' <span class="text-muted">abcd</span> <i class="mdi mdi-chevron-down accordion-arrow"></i></a></h5>
                                <div class="collapse hide" id="taskcollapse' . $i . '">
                                    <div class="table-responsive mt-3">
                                        <div class="row">
                                            <div class="col-lg-12 text-right">
                                            </div>
                                        </div>
                                        <table class="table table-centered table-nowrap table-borderless table-sm">
                                            <thead class="thead-light">
                                            <tr class="">
                                                <th scope="col">Artist</th>
                                                <th scope="col">Field Name</th>
                                                <th scope="col">Field Value</th>
                                            </tr>
                                            </thead>
                                            <tbody>';
        }
        echo '<tr>
                                                <td>' . $row['ARTISTNAME'] . '</td>
                                                <td>' . $row['FIELDNAME'] . '</td>
                                                <td>' . getField($row['TYPE'], $row['FIELDID'], $row['FIELDNAME'], $row['FIELDVALUE'], $row['SHOWID'], $row['PERMISSION']) . '</td>
                                            </tr>';
        $i++;
        $prioreventname = $row['EVENTNAME'];
    }
    echo '
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
}
?>
