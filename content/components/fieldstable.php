<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-centered mb-0">
                <thead class="thead-dark">
                <tr>
                    <th><b>Field</b></th>
                    <th><b>Assigned to</b></th>
                    <th><b>Value</b></th>
                </tr>
                </thead>
                <tbody>

                <?php
                $i = 0;
                if (isset($_GET['setid'])) {
                    $fieldtype = 'shows';
                    $fieldidtype = 'setid';
                } else {
                    $fieldtype = 'events';
                    $fieldidtype = 'eventid';
                }
                foreach ($fieldsquery as $key => $value) {
                    if ($fieldscategory[$i] == $currentcategory) {
                        $fieldname = getFieldDescription($fieldsdescription[$i], $value);

                        echo '<tr>
                                                            <td>' . $fieldname . '</td>
                                                            <td class="assignedto_edit" id="assignedto_edit-' . $fieldsid[$i] . '">';
                        if (isset($assignedusers_fieldid)) {
                            $tempres = array_search($fieldsid[$i], $assignedusers_fieldid);
                        } else {
                            $tempres = "";
                        }
                        unset($checked_names);
                        unset($checked_ids);
                        $checked_names[] = "";
                        $checked_ids[] = "";
                        if (is_numeric($tempres)) {
                            $k=0;
                            foreach ($assignedusers_name as $key2 => $value2) {
                                if ($assignedusers_fieldid[$k] == $fieldsid[$i]) {
                                    //echo $value2 . ' --' . $assignedusers_userid[$k] . '<br>';
                                    $checked_names[$k] = $value2;
                                    $checked_ids[$k] = $assignedusers_userid[$k];
                                }
                                $k++;
                            }
                        }
                        echo assignFieldList($listusername, $listrole, $listuserid, $checked_names, $checked_ids, $fieldsid[$i], $fieldtype);
                        echo '</td>';
                        echo '<td class="assignedto_view" id="assignedto_view-' . $fieldsid[$i] . '" onclick="javascript:clickAsssignedTo(' . $fieldsid[$i] . ');">
                                                                 <div class="row">';
                        foreach ($checked_names as $key3 => $value3) {
                            if ($value3 != "") {
                                echo '<div class="avatar-xs">
                                                                    <span class="avatar-title bg-soft-primary text-dark font-10 rounded-circle" data-toggle="tooltip" data-placement="top" title="' . $value3 . '">
                                                                        ' . generateIniitals($value3) . '
                                                                    </span>
                                                                </div>&nbsp;';
                            }
                        }

                        echo '</div></td>';
                        echo '<td>' . getField($fieldstype[$i], $fieldsid[$i], $value, $rowresults[$value], $_GET[$fieldidtype], $fieldspermission[$i], $fieldtype, $dropdownvalues[$i]);
                        echo '</td></tr>';
                    }
                    $i++;
                }
                ?>

                </tbody>
            </table>



        </div>
    </div>
</div>