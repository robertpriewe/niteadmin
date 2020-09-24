<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title"><?php
                echo $title;
                if (isset($eventname)) {
                    echo ' for Event: ' . $eventname;
                }
                if (isset($venuename)) {
                    echo ' (' . $venuename . ')';
                }
                ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="?">Home</a></li>
                    <?php
                    if (isset($eventid)) {
                        echo '<li class="breadcrumb-item"><a href="?page=showevents">Event List</a></li>';
                        echo '<li class="breadcrumb-item"><a href="?page=eventdetails&eventid=' . $eventid . '">Event Details</a></li>';
                    }
                    ?>
                    <li class="breadcrumb-item active"><?php echo $title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->