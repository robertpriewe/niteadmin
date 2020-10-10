<?php
function getField($type, $fieldid, $fieldname, $fieldvalue, $setid) {

    if ($type == "TEXT") {
        return '<a class="changefield" href="#" data-type="text" data-pk="{id:' . $setid . ',page:\'shows_fields\'}" data-name="' . $fieldname . '">' . $fieldvalue . '</a>';
    } else if ($type == "CHECKBOX") {
        return '<a class="changefield" href="#" data-type="checklist" data-pk="{id:' . $setid . ',page:\'shows_fields_checkbox\'}" data-value="' . $fieldvalue . '" data-source="{\'1\':\'Yes\'}" data-emptytext="0" data-name="' . $fieldname . '">' . $fieldvalue . '</a>';
    } else if ($type == "DATETIME") {
        if (is_null($fieldvalue) == TRUE) {
            $datetime = "";
        } else {
            $datetime = date("Y/m/d h:i A", strtotime($fieldvalue));
        }

        return '<a class="changefield" href="#" data-type="combodate" data-template="MMM D YYYY  hh:mm a" data-format="YYYY-MM-DD HH:mm:ss" data-viewformat="YYYY-MM-DD hh:mm a" data-pk="{id:' . $setid . ',page:\'shows_fields\'}" data-name="' . $fieldname . '">' .  $datetime . '</a>';
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
    }
}

?>