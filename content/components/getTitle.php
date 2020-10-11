<?php
echo $title;
if (isset($eventname)) {
    echo ' for Event: ';
    if (isset($artistname)) {
        echo $artistname . ' @ ';
    }
    echo $eventname;
}
if (isset($venuename)) {
    echo ' (' . $venuename . ')';
}