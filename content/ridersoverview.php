<?php
if (!isset($_GET['eventid'])) {
    echo 'No eventid supplied';
    die;
}

$query = mysqli_query($mysqli, "SELECT * FROM shows RIGHT JOIN shows_riders ON shows.SHOWID = shows_riders.SETID RIGHT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID RIGHT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID WHERE shows.EVENTID = '" . $_GET['eventid'] . "' AND ITEMDELETED = 0 ORDER BY TIMESTART, shows.STAGEID, ARTISTNAME ASC, ITEMDONE DESC");

$riderquery = array();
while($row = $query->fetch_array()) {
    $riderquery[] = $row;
}

$artistname = "";
foreach ($riderquery AS $key) {
    if ($artistname != $key['ARTISTNAME']) {
        if ($artistname != "") {
            echo '</ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
        }
        $artistname = $key['ARTISTNAME'];
        echo '<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="custom-accordion">
                        <h5 class="position-relative mb-0"><a href="#taskcollapse' . $key['ARTISTPLAYINGID'] . '" class="text-dark d-block" data-toggle="collapse">' . $artistname . ' <i class="mdi mdi-chevron-down accordion-arrow"></i></a></h5>
                        <div class="collapse show" id="taskcollapse' . $key['ARTISTPLAYINGID'] . '">
                            <ul>';



    }
    if ($key['ITEMDONE'] == '1') {
        $text = 'success';
    } else {
        $text = 'danger';
    }
    echo '<li class="list-group-item border-0 pl-1"><label class="text-' . $text . '">' . $key['ITEMNAME'] . '</label></li>';
}
echo '</ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
?>


