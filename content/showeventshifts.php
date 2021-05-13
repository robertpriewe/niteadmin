<div class="row">
    <div class="col-lg-12 text-right">
        <a href="#custom-modal" class="btn btn-dark waves-effect waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add new shift','ajax/ajaxmodaladdnewshift.php?eventid=<?php echo $_GET['eventid']; ?>');">Create event schedule <i class="fe-plus"></i></a>
            <br><br>
    </div>
</div>
<?php
$query = mysqli_query($mysqli, "SELECT * FROM shifts WHERE EVENTID = " . $_GET['eventid'] . " ORDER BY STARTTIME ASC");
$i=0;
if ($query->num_rows > 0) {
    while($rowshift = $query->fetch_assoc()) {
        $i++;
        echo '
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                       
                        <div class="custom-accordion">
                            <div class="mt-4">
                                <h5 class="position-relative mb-0"><a href="#taskcollapse' . $i . '" class="text-dark d-block collapsed" data-toggle="collapse">' . $rowshift['DESCRIPTION'] . ' <span class="text-muted">(' . date("h:i A", strtotime($rowshift['STARTTIME'])) . ' - ' . date("h:i A", strtotime($rowshift['ENDTIME'])) . ')</span> <i class="mdi mdi-chevron-down accordion-arrow"></i></a></h5>
                                <div class="collapse hide" id="taskcollapse' . $i . '">
                                    <div class="table-responsive mt-3">
                                        <div class="row">
                                            <div class="col-lg-12 text-right">';
        ?>
                                            <a href="#custom-modal" class="btn btn-success waves-effect waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add employee to shift','ajax/ajaxmodalassignemployee.php?shiftid=<?php echo $rowshift['SHIFTID']; ?>');">Add employees to schedule <i class="fe-plus"></i></a>
                                            <?php echo '</div>
                                        </div>
                                            
                                        <table class="table table-centered table-nowrap table-borderless table-sm">
                                            <thead class="thead-light">
                                            <tr class="">
            
                                                <th scope="col">Name</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Confirmed?</th>
                                            </tr>
                                            </thead>
                                            <tbody>';

        $query2 = mysqli_query($mysqli, "SELECT * FROM shifts_users_link LEFT JOIN users ON shifts_users_link.USERID = users.USERID RIGHT JOIN permissions_roles ON users.ROLE = permissions_roles.ROLEID WHERE SHIFTID = " . $rowshift['SHIFTID']);
if ($query2->num_rows > 0) {
    while ($rowemployees = $query2->fetch_assoc()) {
        echo '<tr>
                                         
                                                <td>' . $rowemployees['FIRSTNAME'] . ' ' . $rowemployees['LASTNAME'] . '</td>
                                                <td>' . $rowemployees['ROLENAME'] . '</td>
                                                <td><span class="badge badge-soft-danger p-1">No</span></td>
     
                                            </tr>';
    }
}
                                            echo '
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
    }
} else {
    echo '<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        No shifts created                    
                    </div></div></div></div></div></div>
    ';
}
?>

