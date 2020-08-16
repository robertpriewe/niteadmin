<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');
if (!isset($_GET['eventid'])) {
    echo 'No eventid supplied';
    die;
}


$query = mysqli_query($mysqli, "SELECT * FROM guestlist_access ORDER BY ACCESSLEVEL ASC");
while($row = $query->fetch_assoc()) {
    $accessquery[] = $row;
}
?>
<br>
<div class="col-lg-12">
    <div class="card-box">
        <div class="row">
            <form>
                <div class="row">
                    <div class="col-lg-6">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" placeholder="Enter first name">
                </div>
                    </div>
                    <div class="col-lg-6">
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" id="lastName" placeholder="Enter last name">
                </div>
                    </div>

                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input type="text" class="form-control" id="email" placeholder="Enter E-Mail">
                </div>
                <div class="form-group">
                    <label for="notes">Notes (cannot be read by guests)</label>
                    <textarea id="notes" placeholder="Enter notes" class="form-control"></textarea>
                </div>
                <div class="row">

                    <?php

                    foreach ($accessquery as $accessarr) {
                        echo '<div class="form-group col-md-2">';
                        echo '<label for="inputState">' . $accessarr['ACCESSLEVEL'] . '</label>';
                        echo '<select id="inputState' . $accessarr['ACCESSLEVEL'] . '" class="form-control" name="access_id_' . $accessarr['ACCESSID'] . '">';
                        for ($i=0; $i<=20; $i++) {
                            echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        echo '</select></div>';
                    }

                    ?>
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-success waves-effect waves-light" onclick="javscript:addGuestlist();">Add</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                            onclick="Custombox.modal.close();">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- end card-box -->
<?php
$calc = "";
$vars = "";
$k = 1;
foreach ($accessquery as $accessarr) {
    $calc .= 'slots' . $accessarr['ACCESSLEVEL'];
    $vars .= "'access_id_" . $accessarr['ACCESSID'] . "': slots" . $accessarr['ACCESSLEVEL'];
    if (count($accessquery) > $k) {
        $calc .= ' + ';
        $vars .= ", ";
    }
    $k++;
}
?>
<script type="text/javascript">
    function addGuestlist() {
        var firstName = $("#firstName").val();
        var lastName = $("#lastName").val();
        var email = $("#email").val();
        var notes = $("#notes").val();
        <?php
        foreach ($accessquery as $accessarr) {
        echo 'var slots' . $accessarr['ACCESSLEVEL'] . ' = $("#inputState' . $accessarr['ACCESSLEVEL'] . '").val();';
        echo "\n";
            }
        ?>
        if (firstName == "") {
            alert("Please enter first name");
        } else if (lastName == "") {
            alert("Please enter last name");
        } else if (email == "") {
            alert("Please enter a valid email");
        } else if ((<?php echo $calc; ?>) == 0) {
            alert("Please choose an allocation");
        } else {
            $.ajax({
                type: "POST",
                data: { 'firstName': firstName, 'lastName': lastName, 'notes': notes, 'email': email, <?php echo $vars; ?> },
                url: 'ajax/addguestlistallocation.php?eventid=<?php echo $_GET['eventid']; ?>',
                context: document.body
            }).done(function(response) {
                alert(response);
                location.reload();
            }).fail(function() {
                alert( "Error" );
            });
        }
    }
</script>
