<?php
include ('sql.php');

if (!isset($_GET['asofdate'])) {
    echo 'No proper date selected!';
    die;
}

$asofdate = $_GET['asofdate'];
$date1DayAgo = date('Y-m-d', strtotime('-1 day', strtotime($asofdate)));
$date3DaysAgo = date('Y-m-d', strtotime('-3 days', strtotime($asofdate)));
$date7DaysAgo = date('Y-m-d', strtotime('-7 days', strtotime($asofdate)));


$sql = "SELECT *
        FROM reporting_table
        WHERE DATE(asofdate) = '" . $asofdate . "' AND active = 1
        GROUP BY trackid";
//echo $sql;
echo 'As of date: ' . $asofdate;
?>

<table id="basic-datatable" class="table display nowrap">
    <thead>
    <tr>
        <th>Track Name</th>
        <th>Artist Name</th>
        <th>Label</th>
        <th>Copyright</th>
        <th>Release</th>
        <th>24h increase</th>
        <th>3d increase</th>
        <th>7d increase</th>
        <th>Total Plays</th>
        <th>SCORE</th>
        <th>Genres</th>
    </tr>
    </thead>
    <tbody>
    <?php

    $query = mysqli_query($mysqli, $sql);
    while($row = $query->fetch_array()) {
        $newplays24h = $row['playcount'] - $row['plays1DayAgo'];
        $newplays3d = $row['playcount'] - $row['plays3DaysAgo'];
        $newplays7d = $row['playcount'] - $row['plays7DaysAgo'];
        if ($newplays24h > 0 && $row['plays1DayAgo'] > 0) {
            if (strpos($row['labelname'], ' DK') !== false || strpos($row['labelname'], ' DK2') !== false) {
                $labelname = '<span class="badge badge-primary">' . substr($row['labelname'], 0, 30) . '</span>';
            } else {
                $labelname = substr($row['labelname'], 0, 30);
            }

            $playcounts = number_format(round($row['playcount'], 0));
            if ($row['playcount'] < 10000) {
                //red
                $color = '#E40000';
                $rank = 1;
            } elseif ($row['playcount'] >= 10000 && $row['playcount'] < 100000) {
                //orange
                $color = '#FFA800';
                $rank = 2;
            } elseif ($row['playcount'] >= 100000) {
                //green
                $color = '#06BD00';
                $rank = 3;
                if ($row['playcount'] >= 1000000) {
                    $rank = round(($row['playcount']/1000000) + 5, 0);
                }
                if ($rank > 15) {
                    $rank = 15;
                }
            } else {
                //black
                $color = '#000000';
                $rank = 1;
            }

            if ($row['plays1DayAgo'] == 0) {
                $percentage24h = 'N/A';
            } else {
                $percentage24h = round(($newplays24h / $row['playcount']) * 100, 1) . '%';
            }

            if ($row['plays3DaysAgo'] == 0) {
                $percentage3d = 'N/A';
            } else {
                $percentage3d = round(($newplays3d / $row['playcount']) * 100, 1) . '%';
            }

            if ($row['plays7DaysAgo'] == 0) {
                $percentage7d = 'N/A';
            } else {
                $percentage7d = round(($newplays7d / $row['playcount']) * 100, 1) . '%';
            }




            $score = (($percentage24h*$rank*1.2) + ($percentage3d*$rank*1.3) + ($percentage7d*$rank*1.5))/30;

            if ($row['genres'] == "nan" || $row['genres'] == "NULL") {
                $genre = '';
            } else {
                $genre = $row['genres'];
            }
            echo '
            <tr>
                <td title="' . $row['trackname'] .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . substr($row['trackname'], 0, 30) . '</td>
                <td title="' . $row['artistname'] .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . substr($row['artistname'], 0, 30) . ' <button type="button" class="btn btn-xs btn-danger" onclick="javascript:ignoreArtist(\'' . $row['artistname'] . '\');"><i class="mdi mdi-trash-can"></i></button></td>
                <td title="' . $row['labelname'] .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . $labelname . ' <button type="button" class="btn btn-xs btn-danger" onclick="javascript:ignoreLabel(\'' . $row['labelname'] . '\');"><i class="mdi mdi-trash-can"></i></button></td>
                <td title="' . $row['copyright'] .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . substr($row['copyright'], 0, 30) . '</td>
                <td>' . $row['releasedate'] . '</td>
                <td title="Plays 24h ago: ' . number_format($row['plays1DayAgo']) .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . $percentage24h . '</td>
                <td title="Plays 3d ago: ' . number_format($row['plays3DaysAgo']) .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . $percentage3d . '</td>
                <td title="Plays 7d ago: ' . number_format($row['plays7DaysAgo']) .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . $percentage7d . '</td>
                <td><b style="color: ' . $color . '">' . $playcounts . '</b></td>
                <td>' . round($score, 0) . '</td>
                <td>' . $genre . '</td>
            </tr>';
        }
    }
    ?>


    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $("#basic-datatable").DataTable({
            lengthMenu: [[100, 250, 500, -1], [100, 250, 500, "All"]],
            scrollX: true,
            order: [[ 5, "desc" ]],
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            }
        });

        tippy('[data-plugin="tippy"]');
    });

    function ignoreLabel(labelname) {
        if (confirm('Are you sure you want to exclude the label "' + labelname + '"?')) {
            $.ajax({
                type: "POST",
                url: 'excludelabel.php',
                data: {'labelname': labelname},
                context: document.body
            }).done(function (response) {
                alert('"' + labelname + '" will be excluded starting the new refresh tomorrow');
            }).fail(function () {
                alert("Error loading list");
            });
        } else {

        }


    }

    function ignoreArtist(artistname) {
        if (confirm('Are you sure you want to exclude the artist "' + artistname + '"?')) {
            $.ajax({
                type: "POST",
                url: 'excludeartist.php',
                data: {'artistname': artistname},
                context: document.body
            }).done(function (response) {
                alert('"' + artistname + '" will be excluded starting the new refresh tomorrow');
            }).fail(function () {
                alert("Error loading list");
            });
        } else {

        }
    }
</script>
<script src="assets/libs/tippy.js/tippy.all.min.js"></script>
