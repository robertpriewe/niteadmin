<?php
if (!isset($_GET['eventid'])) {
    echo 'No eventid supplied';
    die;
}

$query = mysqli_query($mysqli, "SELECT * FROM booking LEFT JOIN shows_fields_list ON booking.COLUMNID = shows_fields_list.ID ORDER BY COLPOSITION ASC");

$colsquery = array();
while($row = $query->fetch_array()) {
    $colsquery[] = $row;
}

$query = mysqli_query($mysqli, "SELECT * FROM shows RIGHT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID RIGHT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID WHERE EVENTID = " . $_GET['eventid']);


function validateFields($value, $showid, $columnid) {
    global $completed;
    if(is_null($value) || $value == "" || $value == "0") {
        return '<a href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'Edit Field\',\'ajax/ajaxmodaleditfield.php?showid=' . $showid . '&columnid=' . $columnid . '\');" class="border-danger text-danger"><i class="ri-checkbox-circle-line"></i></a>';
    } else {
        $completed = $completed + 1;
        return '<a href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'Edit Field\',\'ajax/ajaxmodaleditfield.php?showid=' . $showid . '&columnid=' . $columnid . '\');" class="border-success text-success"><i class="ri-checkbox-circle-fill primary" title="' . $value . '" data-plugin="tippy" data-tippy-arrow="true" data-tippy-animation="fade"></i></a>';
    }
}


?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="advancing-table">
                        <thead class="bg-light">
                        <tr>
                            <th class="font-weight-medium">Artist</th>
                            <?php
                            $colNumber = 0;
                            foreach($colsquery as $colsrow) {
                                echo '<th class="font-weight-medium" align="center">' . $colsrow['FIELDNAME_TEXT'] . '</th>';
                                $colNumber++;
                            }
                            ?>
                            <th class="font-weight-medium">Completion</th>
                        </tr>
                        </thead>

                        <tbody class="font-14">
                        <?php
                        while($row = $query->fetch_array()) {
                            echo '<tr>';
                            echo '<td><b>' . $row['ARTISTNAME'] . '</b></td>';
                            $completed=0;
                            foreach($colsquery as $colsrow) {
                                echo '<td align="center"><b>' . validateFields($row[$colsrow['FIELDNAME']], $row['SHOWID'], $colsrow['COLUMNID']) . '</b></td>';
                            }
                            $percentage = ($completed/$colNumber)*100;
                            if ($percentage >= 100) {
                                $progresssolor = 'bg-success';
                            } elseif ($percentage > 25) {
                                $progresssolor = 'bg-warning';
                            } else {
                                $progresssolor = 'bg-danger';
                            }

                            echo '<td><div class="row"><div class="col-lg-10"><div class="progress mb-0">
                                            <div class="progress-bar progress-bar ' . $progresssolor . '" role="progressbar" style="width: ' . $percentage . '%;" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="100">' . $percentage . '%)</div>
                                        </div></div>
                                        <div class="col-lg-2">' . $completed . '/' . $colNumber . '</div></div></td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- end col -->
    </div>
<?php
/*
                            echo '<tr>';
                            echo '<td><b>' . $row['ARTISTNAME'] . '</b></td>';
                            foreach($colsquery as $colsrow) {
                                echo '<td><b>' . $row[$colsrow['FIELDNAME']] . '</b></td>';
                            }
                            echo '</tr>';
*/