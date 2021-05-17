<?php
function getField($type, $fieldid, $fieldname, $fieldvalue, $id, $permission, $fieldtype="shows", $dropdownvalues="") {
    global $rowresults;
    if ($fieldtype == "shows") {
        $table = "shows_fields";
    } else {
        $table = "events";
    }
    if ($permission != "") {
        if (!isset($_SESSION['ACCESS'][$permission])) {
            if ($fieldvalue == "") {
                return '<i class="ri-checkbox-blank-circle-line" title="Field has not been populated yet" data-plugin="tippy" data-tippy-arrow="true" data-tippy-animation="fade"></i>';
            } else {
                return '<i class="ri-checkbox-circle-fill primary" title="No permission to see the value" data-plugin="tippy" data-tippy-arrow="true" data-tippy-animation="fade"></i>';
            }
        }
    }

    if ($type == "TEXT") {
        return '<a class="changefield" href="#" data-type="text" data-pk="{id:' . $id . ',page:\'' . $table . '\'}" data-name="' . $fieldname . '">' . $fieldvalue . '</a>';
    } else if ($type == "CHECKBOX") {
        return '<a class="changefield" href="#" data-type="checklist" data-pk="{id:' . $id . ',page:\'' . $table . '_checkbox\'}" data-value="' . $fieldvalue . '" data-source="{\'1\':\'Yes\'}" data-emptytext="0" data-name="' . $fieldname . '">' . $fieldvalue . '</a>';
    } else if ($type == "DATETIME") {
        if (is_null($fieldvalue) == TRUE) {
            $datetime = $rowresults['EVENTSTARTDATE'];;
            $text = "No time set";
        } else {
            $datetime = date("Y-m-d H:i:s", strtotime($fieldvalue));
            $text = '';
        }
        //return '<a class="changefield" href="#" data-type="combodate" data-value="' . $datetime . '" data-template="MMM D YYYY hh:mm a" data-format="YYYY-MM-DD HH:mm:ss" data-viewformat="YYYY-MM-DD hh:mm a" data-pk="{id:' . $id . ',page:\'' . $table . '\'}" data-clear="NA" data-name="' . $fieldname . '">' . '2021-05-30' . '</a>';
        return '<a class="changefield" href="#" data-type="combodate" data-value="' . $datetime . '" data-template="MM/DD/YYYY     hh:mm a" data-format="YYYY-MM-DD HH:mm:ss" data-viewformat="YYYY-MM-DD hh:mm a" data-pk="{id:' . $id . ',page:\'' . $table . '\'}" data-name="' . $fieldname . '">' . $text . '</a>';
    } else if ($type == "FILE") {
        if ($fieldvalue == "") {
            return '<form method="POST" enctype="multipart/form-data" name="formdata-' . $fieldid . '" id="divUpload-' . $fieldid . '">
                    <div class="fileupload btn btn-xs btn-secondary waves-effect mt-1">
                        <span><i class="mdi mdi-cloud-upload mr-1"></i>Upload</span>
                        <input type="file" class="upload" id="uploadField-' . $fieldid . '" name="uploadField-' . $fieldid . '" onChange="javascript:fileUpload(' . $fieldid . ', \'' . $fieldname . '\');">
                    </div>
                </form>';
        } else {
            return '<a href="files/' . $fieldvalue . '" target="_BLANK">' . basename($fieldvalue) . '</a> <button type="button" class="btn btn-danger btn-xs waves-effect waves-light mr-1" onclick="javascript:fileDelete(' . $fieldid . ', \'' . $fieldname . '\');"><i class="mdi mdi-trash-can"></i></button>';
        }
    } else if ($type == "DROPDOWN") {
        return '<a class="changefield" href="#" data-type="select" data-pk="{id:' . $id . ',page:\'' . $table . '\'}" data-prepend="' . $fieldvalue . '" data-source="' . $dropdownvalues . '" data-emptytext="" data-name="' . $fieldname . '">' . $fieldvalue . '</a>';
    }
}

?>