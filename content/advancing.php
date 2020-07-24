<?php
if (!isset($_GET['eventid'])) {
    echo 'No eventid supplied';
    die;
}

$query = mysqli_query($mysqli, "SELECT * FROM advancing LEFT JOIN shows_fields_list ON advancing.COLUMNID = shows_fields_list.ID ORDER BY COLPOSITION ASC");

$colsquery = array();
while($row = $query->fetch_array()) {
    $colsquery[] = $row;
}

$query = mysqli_query($mysqli, "SELECT * FROM shows RIGHT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID RIGHT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID WHERE EVENTID = " . $_GET['eventid']);




?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                    <thead class="bg-light">
                    <tr>
                        <th class="font-weight-medium">Artist</th>
                        <?php
                        foreach($colsquery as $colsrow) {
                            echo '<th class="font-weight-medium">' . $colsrow['FIELDNAME'] . '</th>';
                        }
                        ?>
                    </tr>
                    </thead>

                    <tbody class="font-14">
                        <?php
                        while($row = $query->fetch_array()) {
                                                    echo '<tr>';
                                                    echo '<td><b>' . $row['ARTISTNAME'] . '</b></td>';
                                                    foreach($colsquery as $colsrow) {
                                                        echo '<td><b>' . $row[$colsrow['FIELDNAME']] . '</b></td>';
                                                    }
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