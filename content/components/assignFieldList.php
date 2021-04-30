<?php
function assignFieldList($listusername, $listrole, $listuserid, $checked_names, $checked_ids, $fieldid) {
    $namestext = "";
    foreach ($checked_names as $key => $value) {
        if ($value != "") {
            $namestext .= '<option value="' . $checked_ids[$key] . '-' . $fieldid . '" SELECTED>' . $value . ' - ' . $checked_ids[$key] . '</option>';
        }
    }

    foreach ($listusername as $key => $value) {
        if ($value != "") {
            $namestext .= '<option value="' . $listuserid[$key] . '-' . $fieldid . '">' . $value . ' - ' . $listuserid[$key] . '</option>';
        }
    }

        return '<div class="row">
        <div class="form-group mb-3">
            <select class="selectize-optgroup" multiple placeholder="Select assignee...">
                <option value="">Assign to:</option>
                <optgroup label="Admin">
                    ' . $namestext . '
                </optgroup>
            </select>
        </div>
    </div>';
}