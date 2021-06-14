<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Select Role to Edit Permissions:</h4>
                <div class="mt-3">
                    <?php
                    $query = mysqli_query($mysqli, 'SELECT * FROM permissions_roles');
                    while($row = $query->fetch_assoc()) {
                        echo '
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">' . $row['ROLENAME'] . '</label>
                                    <div class="col-md-10">
                                        <a class="btn btn-primary btn-sm" href="?page=listrolepermissions&roleid=' . $row['ROLEID'] . '">Edit Permissions</a>
                                    </div>
                                </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
