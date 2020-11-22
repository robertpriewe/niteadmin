<?php
function getFieldArtist($fieldname, $fieldvalue, $artistid) {
    if (!isset($_SESSION['ACCESS']['CONFIDENTIALCONTACT'])) {
        if ($fieldvalue == "") {
            return '<i class="ri-checkbox-blank-circle-line" title="No permission to see the information" data-plugin="tippy" data-tippy-arrow="true" data-tippy-animation="fade"></i>';
        } else {
            return '<i class="ri-checkbox-circle-fill primary" title="No permission to see the information" data-plugin="tippy" data-tippy-arrow="true" data-tippy-animation="fade"></i>';
        }
    } else {
        return '<a class="changefield" href="#" data-type="text" data-pk="{id:\'' . $artistid . '\',page:\'artists\'}" data-name="' . $fieldname . '">' . $fieldvalue . '</a>';
    }
}

?>
