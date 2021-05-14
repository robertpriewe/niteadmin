<?php
if (!isset($_GET['setid'])) {
    echo 'No set ID found';
    die;
}

function generateIniitals(string $name) : string {
    $words = explode(' ', $name);
    if (count($words) >= 2) {
        return strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
    }
    return $this->makeInitialsFromSingleWord($name);
}

function makeInitialsFromSingleWord(string $name) : string {
    preg_match_all('#([A-Z]+)#', $name, $capitals);
    if (count($capitals[1]) >= 2) {
        return substr(implode('', $capitals[1]), 0, 2);
    }
    return strtoupper(substr($name, 0, 2));
}


include ('content/components/getField.php');
include ('content/components/getFieldDescription.php');
include ('content/components/assignFieldList.php');


$query = mysqli_query($mysqli, "SELECT *, shows_fields_list.ID AS FIELDID FROM shows_fields_list LEFT JOIN shows_fields_categories ON shows_fields_list.FIELDNAME_CATEGORY = shows_fields_categories.ID WHERE HIDDEN = '0' ORDER BY shows_fields_list.POSITION, shows_fields_list.ID ASC");
while($row = $query->fetch_array()) {
    $fieldsquery[] = $row['FIELDNAME'];
    $fieldsdescription[] = $row['FIELDNAME_TEXT'];
    $fieldscategory[] = $row['CATEGORY'];
    $fieldstype[] = $row['TYPE'];
    $fieldsid[] = $row['FIELDID'];
    $fieldspermission[] = $row['PERMISSION'];
    $dropdownvalues[] = $row['FIELDVALUES'];
}

$query = mysqli_query($mysqli, "SELECT * FROM shows LEFT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID RIGHT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID RIGHT JOIN stages ON shows.STAGEID = stages.STAGEID RIGHT JOIN venues ON stages.VENUEID = venues.VENUEID RIGHT JOIN events ON events.EVENTID = shows.EVENTID LEFT JOIN shows_b2b ON shows.SHOWID = shows_b2b.B2BSETID WHERE shows.SHOWID = '" . $_GET['setid'] . "' LIMIT 0, 1");
while ($row = $query->fetch_array()) {
    $rowresults = $row;
}


$query = mysqli_query($mysqli, "SELECT CONCAT(FIRSTNAME, ' ', LASTNAME) AS NAME, permissions_roles.ROLENAME, USERID FROM users LEFT JOIN permissions_roles ON users.ROLE = permissions_roles.ROLEID");
while ($row = $query->fetch_array()) {
    $listusername[] = $row['NAME'];
    $listrole[] = $row['ROLENAME'];
    $listuserid[] = $row['USERID'];
}

$venueid = $rowresults['VENUEID'];


$query = mysqli_query($mysqli, "SELECT * FROM `shows_assigned_users` LEFT JOIN shows_fields_list ON shows_assigned_users.FIELDID = shows_fields_list.ID RIGHT JOIN users ON shows_assigned_users.USERID = users.USERID WHERE showid = '" . $_GET['setid'] . "'");
while ($row = $query->fetch_array()) {
    $assignedusers_fieldname[] = $row['FIELDNAME'];
    $assignedusers_fieldid[] = $row['FIELDID'];
    $assignedusers_name[] = $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];
    $assignedusers_userid[] = $row['USERID'];
}



include("content/components/b2blogic.php");

?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10">
                                <ul class="nav nav-pills navtab-bg">
                                    <li class="nav-item">
                                        <a href="#general" data-toggle="tab" aria-expanded="true" class="nav-link active ml-0" id="navgeneral">
                                            <i class="mdi mdi-face-profile mr-1"></i>General
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#artistdetails" data-toggle="tab" aria-expanded="false" class="nav-link" onclick="javascript:loadArtistDetails();" id="navartistdetails">
                                            <i class="mdi mdi-account mr-1"></i>Artist Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#stageinfo" data-toggle="tab" aria-expanded="false" class="nav-link" id="navstageinfo">
                                            <i class="mdi mdi-headphones mr-1"></i>Stage Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#financials" data-toggle="tab" aria-expanded="false" class="nav-link" id="navfinancials">
                                            <i class="mdi mdi-account-cash mr-1"></i>Financials
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#documents" data-toggle="tab" aria-expanded="false" class="nav-link" id="navdocuments">
                                            <i class="mdi mdi-text mr-1"></i>Contracts/Documents
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#accommodations" data-toggle="tab" aria-expanded="false" class="nav-link" id="navaccommodations">
                                            <i class="mdi mdi-home mr-1"></i>Accommodations
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#other" data-toggle="tab" aria-expanded="false" class="nav-link" id="navother">
                                            <i class="mdi mdi-paperclip mr-1"></i>Other
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#rider" data-toggle="tab" aria-expanded="false" class="nav-link" onclick="javascript:loadRider(<?php echo $_GET['setid']; ?>);" id="navrider">
                                            <i class="mdi mdi-paper-cut-vertical mr-1"></i>Rider
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-2">
                                <div class="text-lg-right mt-3 mt-lg-0">
                                    <button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="javascript:clickEdit();"><i class="mdi mdi-settings"></i> Edit</button>
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" onclick="javascript:document.location.href='?page=artistdetails&artistid=<?php echo $rowresults['ARTISTID']; ?>';"><i class="ri-headphone-line mr-2 text-muted font-18 vertical-middle"></i>Artist Profile</a>
                                            <a class="dropdown-item" href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Remove Artist from Event','ajax/ajaxmodalconfirmdeletion.php?deleteartistfromevent=true&artistid=<?php echo $rowresults['ARTISTID']; ?>&eventid=<?php echo $rowresults['EVENTID']; ?>');"><i class="ri-delete-bin-2-line mr-2 text-muted font-18 vertical-middle"></i>Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col-->
                        </div> <!-- end row -->
                    </div> <!-- end card-box -->
                    </div>
                </div><!-- end col-->
            </div>
            <!-- end row -->


            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="tab-content">

                            <div class="tab-pane show active" id="general">
                                <?php
                                $currentcategory = 'GENERAL';
                                include('content/components/fieldstable.php'); ?>
                            </div>





                            <div class="tab-pane" id="artistdetails">
                                <div class="row">
                                    <div class="col-12" id="divArtistDetails">

                                    </div>
                                </div>
                            </div>



                            <div class="tab-pane" id="stageinfo">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-borderless table-striped mb-0">
                                                <tbody>
                                                <?php

                                                $i = 0;
                                                foreach ($fieldsquery as $key => $value) {
                                                    if ($fieldscategory[$i] == "STAGEINFO") {
                                                        $fieldname = getFieldDescription($fieldsdescription[$i], $value);


                                                        echo '<tr>
                                                        <td style="width: 35%;">' . $fieldname . '</td>
                                                        <td>' . getField($fieldstype[$i], $fieldsid[$i], $value, $rowresults[$value], $_GET['setid'], $fieldspermission[$i], 'shows') . '</td>
                                                        </tr>';
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="tab-pane" id="financials">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-borderless table-striped mb-0">
                                                <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($fieldsquery as $key => $value) {
                                                    if ($fieldscategory[$i] == "FINANCIALS") {
                                                        $fieldname = getFieldDescription($fieldsdescription[$i], $value);

                                                        echo '<tr>
                                                        <td style="width: 35%;">' . $fieldname . '</td>
                                                        <td>' . getField($fieldstype[$i], $fieldsid[$i], $value, $rowresults[$value], $_GET['setid'], $fieldspermission[$i], 'shows') . '</td>
                                                        </tr>';
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="documents">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-borderless table-striped mb-0">
                                                <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($fieldsquery as $key => $value) {
                                                    if ($fieldscategory[$i] == "DOCUMENTS") {
                                                        $fieldname = getFieldDescription($fieldsdescription[$i], $value);

                                                        echo '<tr>
                                                        <td style="width: 35%;">' . $fieldname . '</td>
                                                        <td>' . getField($fieldstype[$i], $fieldsid[$i], $value, $rowresults[$value], $_GET['setid'], $fieldspermission[$i], 'shows') . '</td>
                                                        </tr>';
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane" id="accommodations">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-borderless table-striped mb-0">
                                                <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($fieldsquery as $key => $value) {
                                                    if ($fieldscategory[$i] == "ACCOMMODATIONS") {
                                                        $fieldname = getFieldDescription($fieldsdescription[$i], $value);

                                                        echo '<tr>
                                                        <td style="width: 35%;">' . $fieldname . '</td>
                                                        <td>' . getField($fieldstype[$i], $fieldsid[$i], $value, $rowresults[$value], $_GET['setid'], $fieldspermission[$i], 'shows') . '</td>
                                                        </tr>';
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="tab-pane" id="other">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-borderless table-striped mb-0">
                                                <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($fieldsquery as $key => $value) {
                                                    if ($fieldscategory[$i] == "OTHER") {
                                                        $fieldname = getFieldDescription($fieldsdescription[$i], $value);

                                                        echo '<tr>
                                                        <td style="width: 35%;">' . $fieldname . '</td>
                                                        <td>' . getField($fieldstype[$i], $fieldsid[$i], $value, $rowresults[$value], $_GET['setid'], $fieldspermission[$i], 'shows') . '</td>
                                                        </tr>';
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- end timeline content-->



                    <div class="tab-pane" id="rider">

                    </div>

                            <!-- end settings content-->

                        </div> <!-- end tab-content -->
                    </div> <!-- end card-box-->
                    </div>


                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i> Other shows</h5>
                                    <div class="table-responsive">
                                        <?php
                                        $_GET['artistid'] = $rowresults['ARTISTID'];
                                        include('content/components/eventsplayingwidget.php');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end col -->




<script type="text/javascript">
    function loadArtistDetails() {
        $.ajax({
            type: "GET",
            url: 'content/components/divArtistDetails.php?artistid=<?php echo $rowresults['ARTISTID']; ?>',
            context: document.body
        }).done(function(response) {
            $('#divArtistDetails').html('<div class="spinner-border text-primary m-2" role="status"><span class="sr-only">Loading...</span></div>');
            $('#divArtistDetails').html(response);
        }).fail(function() {
            alert("Error");
        });
    }

    function assignStage() {
        var stageId = $('#stageSelect').val();
        $.ajax({
            type: "GET",
            url: 'ajax/assignstage.php?setid=<?php echo $_GET['setid']; ?>&stageid=' + stageId,
            context: document.body
        }).done(function(response) {
            alert("Stage assigned");
            location.reload();
        }).fail(function() {
            alert("Error");
        });
    }


    function fileDelete(fieldId, fieldName) {
        $.ajax({
            type: "GET",
            url: 'ajax/ajaxdeletefile.php?setid=<?php echo $_GET['setid']; ?>&fieldname=' + encodeURI(fieldName) + '&fieldid=' + fieldId,
            context: document.body
        }).done(function(response) {
            alert("File deleted");
            location.reload();
        }).fail(function() {
            alert("Error");
        });
    }

    function fileUpload(fieldId, fieldName) {
        var formData = new FormData($('#formdata-' + fieldId)[0]);
        var file = $('#uploadField-' + fieldId)[0].files[0];
        formData.append('upload_file',file);
        $('#divUpload-' + fieldId).html('<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;"></div>');
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('.progress-bar').css('width',percentComplete+"%");
                        $('.progress-bar').html(percentComplete+"%");
                        if (percentComplete === 100) {
                        }
                    }
                }, false);
                return xhr;
            },
            type:'POST',
            url: 'ajax/ajaxuploadfile.php?setid=<?php echo $_GET['setid']; ?>&fieldname=' + encodeURI(fieldName) + '&fieldid=' + fieldId,
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function (returndata) {
                $('#divUpload-' + fieldId).html(returndata);
                alert('File uploaded!');
                location.reload();
            }
        });
        return false;
    }


</script>