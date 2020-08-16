<?php
function b2blogic($B2BID, $SETID, $ARTISTNAME, $OUTPUT) {
    include("modules/sql.php");
    if ($B2BID == NULL) {
        return '<button type="button" class="btn btn-sm btn-primary waves-effect waves-light mr-1" href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'Create B2B Set\',\'ajax/ajaxmodalsetlist.php?setid=' . $SETID . '\');"><i class="mdi mdi-magnet"></i> Create B2B</button>';
    } else {
        $query = mysqli_query($mysqli, "SELECT *, shows_b2b.ID AS B2BDBID FROM shows_b2b RIGHT JOIN shows ON shows_b2b.B2BSETID = shows.SHOWID LEFT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID WHERE B2BID = " . $B2BID);
        $b2bnumber = $query->num_rows;
        $i = 1;
        $output = "";
        while ($row = $query->fetch_array()) {
            $output .= $row['ARTISTNAME'];
            if ($i < $b2bnumber) {
                $output .= " b" . $b2bnumber . "b ";
            }
            $ID = $row['B2BDBID'];
            $i++;
        }
        if ($OUTPUT == "BUTTONS") {
            return $output . ' <button type="button" class="btn btn-xs btn-primary waves-effect waves-light mr-1" href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'Create B2B Set\',\'ajax/ajaxmodalsetlist.php?setid=' . $SETID . '&b2bid=' . $B2BID . '\');">+ B2B</button> <button type="button" class="btn btn-xs btn-danger waves-effect waves-light mr-1" href="#custom-modal" data-animation="fadein" data-plugin="custommodal" data-overlayColor="#38414a" onclick="javascript:openModal(\'Remove ' . '&quot;' . $ARTISTNAME . '&quot;' . ' from b2b\',\'ajax/ajaxmodalremoveb2b.php?id=' . $ID . '\');">X</button>';
        } else {
            return $output;
        }
    }
}
?>