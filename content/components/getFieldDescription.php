<?php
function getFieldDescription($description, $value) {
    if ($description == "") {
        return $value;
    } else {
        return $description;
    }
}
?>