<?php
if (isset($_GET['action'])) {
    mysqli_query($mysqli, 'DELETE FROM permissions_access WHERE ROLEID = ' . $_GET['roleid']);

    if (count($_POST) > 0) {
        foreach ($_POST as $key => $value) {
            //echo $key;
            mysqli_query($mysqli, 'INSERT INTO permissions_access (ROLEID, SECTIONID) VALUES ("' . $_GET['roleid'] . '", "' . $key . '")');
        }
    }
    echo 'Changes saved!';
}

$query = mysqli_query($mysqli, 'SELECT * FROM sections');
while($row = $query->fetch_assoc()) {
    $sectionlist[] = $row;
}

$query = mysqli_query($mysqli, 'SELECT * FROM permissions_access WHERE ROLEID = ' . $_GET['roleid']);
//$query = mysqli_query($mysqli, 'SELECT * FROM sections LEFT JOIN permissions_access ON permissions_access.SECTIONID = sections.IDSECTION WHERE (permissions_access.ROLEID = ' . $_GET['roleid'] . ' OR permissions_access.ROLEID IS NULL) GROUP BY SECTIONNAME');
    if ($query->num_rows > 0) {
        while($row = $query->fetch_assoc()) {
            $rowquery[] = $row;
        }
    } else {
        $rowquery = array();
    }
$query = mysqli_query($mysqli, 'SELECT * FROM permissions_roles WHERE ROLEID = ' . $_GET['roleid'] . ' LIMIT 0, 1');
while($row = $query->fetch_assoc()) {
   $rolename = $row['ROLENAME'];
}

    ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Editing Permissions for: <?php echo $rolename; ?></h4>
                <div class="mt-3">
                    <form action="?page=listrolepermissions&roleid=<?php echo $_GET['roleid']; ?>&action=submit" method="POST">
                    <?php
                    foreach ($sectionlist as $sectionrow) {
                        $checked = "";
                        foreach ($rowquery as $queryrow) {
                            if ($sectionrow['IDSECTION'] == $queryrow['SECTIONID']) {
                                $checked = " checked";
                            }
                        }
                        echo '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="' . $sectionrow['IDSECTION'] . '" id="customCheck' . $sectionrow['IDSECTION'] . '"' . $checked . '>
                        <label class="custom-control-label" for="customCheck' . $sectionrow['IDSECTION'] . '">' . $sectionrow['SECTIONNAME'] . '</label>
                        </div>';
                    }
                    ?><br>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
