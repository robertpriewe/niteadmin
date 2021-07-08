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


$sql = "SELECT trackname, artistname, copyright, releasedate, tracksv2.label AS labelname,
        AVG(CASE WHEN DATE(timestamp) = '" . $asofdate . "' THEN metricvalue END) AS 'playsAsOfDate',
        AVG(CASE WHEN DATE(timestamp) = '" . $date1DayAgo . "' THEN metricvalue END) AS 'plays1DayAgo',
        AVG(CASE WHEN DATE(timestamp) = '" . $date3DaysAgo . "' THEN metricvalue END) AS 'plays3DaysAgo',
        AVG(CASE WHEN DATE(timestamp) = '" . $date7DaysAgo . "' THEN metricvalue END) AS 'plays7DaysAgo'
        FROM metricsv2
        JOIN tracksv2 ON metricsv2.trackid = tracksv2.trackid
        WHERE metricname = 'playcount' AND DATE(timestamp) IN ('" . $asofdate . "', '" . $date1DayAgo . "', '" . $date3DaysAgo . "',  '" . $date7DaysAgo . "')
        GROUP BY metricsv2.trackid
";
echo $sql;
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
    </tr>
    </thead>
    <tbody>
    <?php

    $query = mysqli_query($mysqli, $sql);
    while($row = $query->fetch_array()) {
        $newplays24h = $row['playsAsOfDate'] - $row['plays1DayAgo'];
        $newplays3d = $row['playsAsOfDate'] - $row['plays3DaysAgo'];
        $newplays7d = $row['playsAsOfDate'] - $row['plays7DaysAgo'];
        if ($newplays24h > 0 && $row['plays1DayAgo'] > 0) {
            if (strpos($row['labelname'], ' DK') !== false || strpos($row['labelname'], ' DK2') !== false) {
                $labelname = '<span class="badge badge-primary">' . substr($row['labelname'], 0, 30) . '</span>';
            } else {
                $labelname = substr($row['labelname'], 0, 30);
            }

            $playcounts = number_format(round($row['playsAsOfDate'], 0));
            if ($row['playsAsOfDate'] < 10000) {
                //red
                $color = '#E40000';
                $rank = 1;
            } elseif ($row['playsAsOfDate'] >= 10000 && $row['playsAsOfDate'] < 100000) {
                //orange
                $color = '#FFA800';
                $rank = 2;
            } elseif ($row['playsAsOfDate'] >= 100000) {
                //green
                $color = '#06BD00';
                $rank = 3;
                if ($row['playsAsOfDate'] >= 1000000) {
                        $rank = round(($row['playsAsOfDate']/1000000) + 5, 0);
                }
                if ($rank > 15) {
                    $rank = 15;
                }
            } else {
                //black
                $color = '#000000';
                $rank = 1;
            }

            $percentage24h = round(($newplays24h / $row['playsAsOfDate']) * 100, 1);
            $percentage3d = round(($newplays3d / $row['playsAsOfDate']) * 100, 1);
            $percentage7d = round(($newplays7d / $row['playsAsOfDate']) * 100, 1);

            $score = (($percentage24h*$rank*1.2) + ($percentage3d*$rank*1.3) + ($percentage7d*$rank*1.5))/30;
                echo '
            <tr>
                <td title="' . $row['trackname'] .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . substr($row['trackname'], 0, 30) . '</td>
                <td title="' . $row['artistname'] .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . substr($row['artistname'], 0, 30) . '</td>
                <td title="' . $row['labelname'] .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . $labelname . '</td>
                <td title="' . $row['copyright'] .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . substr($row['copyright'], 0, 30) . '</td>
                <td>' . $row['releasedate'] . '</td>
                <td title="Plays 24h ago: ' . number_format($row['plays1DayAgo']) .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . $percentage24h . '%</td>
                <td title="Plays 3d ago: ' . number_format($row['plays3DaysAgo']) .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . $percentage3d . '%</td>
                <td title="Plays 7d ago: ' . number_format($row['plays7DaysAgo']) .'" data-plugin="tippy" data-placement="top-start" data-tippy-animation="shift-away" data-tippy-arrow="true">' . $percentage7d . '%</td>
                <td><b style="color: ' . $color . '">' . $playcounts . '</b></td>
                <td>' . round($score, 0) . '</td>
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


</script>
<script src="assets/libs/tippy.js/tippy.all.min.js"></script>
