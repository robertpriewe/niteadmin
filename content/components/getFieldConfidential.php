<?php
function getFieldConfidential($fieldname='', $fieldvalue, $contactid='', $confidential) {
    if ($confidential == 0) {
        if ($fieldname == '' || $contactid == '') {
            return $fieldvalue;
        } else {
            return '<a class="changefield" href="#" data-type="text" data-pk="{id:' . $contactid . ',page:\'contacts\'}" data-name="' . $fieldname . '">' . $fieldvalue . '</a>';
        }
    } else {
        if (!isset($_SESSION['ACCESS']['CONFIDENTIALCONTACT'])) {
            if ($fieldvalue == "") {
                return '<i class="ri-checkbox-blank-circle-line" title="No permission to see the information" data-plugin="tippy" data-tippy-arrow="true" data-tippy-animation="fade"></i>';
            } else {
                return '<i class="ri-checkbox-circle-fill primary" title="No permission to see the information" data-plugin="tippy" data-tippy-arrow="true" data-tippy-animation="fade"></i>';
            }
        } else {
            if ($fieldname == '' || $contactid == '') {
                return $fieldvalue;
            } else {
                return '<a class="changefield" href="#" data-type="text" data-pk="{id:' . $contactid . ',page:\'contacts\'}" data-name="' . $fieldname . '">' . $fieldvalue . '</a>';
            }
        }
    }
}
 