<?php
$query = mysqli_query($mysqli, 'SELECT CONTACTID, FIRSTNAME, LASTNAME FROM contacts');
while($row = $query->fetch_array()) {
    $listcontactids[] = $row['CONTACTID'];
    $listcontactnames[] = $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];
}

function convertIdToName($fieldName) {
    global $listcontactids;
    global $listcontactnames;
    $arrpos = array_search($fieldName, $listcontactids);
    if (is_numeric($arrpos)) {
        return '<a href="?page=showcontacts&contactid=' . $listcontactids[$arrpos] . '">' . $listcontactnames[$arrpos] . '</a>';
    } else {
        return '';
    }
}