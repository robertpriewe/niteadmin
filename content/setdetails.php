<?php
if (!isset($_GET['setid'])) {
    echo 'No set ID found';
    die;
}

include ('content/components/getField.php');

$query = mysqli_query($mysqli, "SELECT * FROM shows_fields_list LEFT JOIN shows_fields_categories ON shows_fields_list.FIELDNAME_CATEGORY = shows_fields_categories.ID WHERE HIDDEN = '0' ORDER BY shows_fields_list.POSITION, shows_fields_list.ID ASC");


while($row = $query->fetch_array()) {
    $fieldsquery[] = $row['FIELDNAME'];
    $fieldsdescription[] = $row['FIELDNAME_TEXT'];
    $fieldscategory[] = $row['CATEGORY'];
    $fieldstype[] = $row['TYPE'];
    $fieldsid[] = $row['ID'];
}
$query = mysqli_query($mysqli, "SELECT * FROM shows LEFT JOIN shows_fields ON shows.SHOWID = shows_fields.SHOWID RIGHT JOIN artists ON shows.ARTISTPLAYINGID = artists.ARTISTID RIGHT JOIN stages ON shows.STAGEID = stages.STAGEID RIGHT JOIN venues ON stages.VENUEID = venues.VENUEID RIGHT JOIN events ON events.EVENTID = shows.EVENTID LEFT JOIN shows_b2b ON shows.SHOWID = shows_b2b.B2BSETID WHERE shows.SHOWID = '" . $_GET['setid'] . "' LIMIT 0, 1");

while ($row = $query->fetch_array()) {
    $rowresults = $row;
}
$venueid = $rowresults['VENUEID'];

include("content/components/b2blogic.php");

?>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <ul class="nav nav-pills navtab-bg">
                                    <li class="nav-item">
                                        <a href="#setinfo" data-toggle="tab" aria-expanded="true" class="nav-link active ml-0">
                                            <i class="mdi mdi-face-profile mr-1"></i>Show/Set Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#contract" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-paperclip mr-1"></i>Contract Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#other" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-text mr-1"></i>Other
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#stage" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-headphones mr-1"></i>Stage/Technical
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#rider" data-toggle="tab" aria-expanded="false" class="nav-link" onclick="javascript:loadRider(<?php echo $_GET['setid']; ?>);">
                                            <i class="mdi mdi-paper-cut-vertical mr-1"></i>Rider
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <div class="text-lg-right mt-3 mt-lg-0">
                                    <button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="javascript:clickEdit();"><i class="mdi mdi-settings"></i> Edit</button>
                                    <button type="button" class="btn btn-primary waves-effect waves-light mr-1" onclick="javascript:document.location.href='?page=artistdetails&artistid=<?php echo $rowresults['ARTISTID']; ?>';"><i class="mdi mdi-information"></i> Artist Info</button>
                                    <a href="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Remove Artist from Event','ajax/ajaxmodalconfirmdeletion.php?deleteartistfromevent=true&artistid=<?php echo $rowresults['ARTISTID']; ?>&eventid=<?php echo $rowresults['EVENTID']; ?>');"><i class="mdi mdi-recycle mr-1"></i> Remove</a>


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





                        <div class="tab-pane show active" id="setinfo">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-borderless table-striped mb-0">
                                                <tbody>
                                                <?php
                                                    $i = 0;
                                                    foreach ($fieldsquery as $key => $value) {
                                                        if ($fieldscategory[$i] == "SETDETAILS") {
                                                            if ($fieldsdescription[$i] == "") {
                                                                $fieldname = $value;
                                                            } else {
                                                                $fieldname = $fieldsdescription[$i];
                                                            }

                                                            echo '<tr>
                                                            <td style="width: 35%;">' . $fieldname . '</td>
                                                            <td>' . getField($fieldstype[$i], $fieldsid[$i], $value, $rowresults[$value], $_GET['setid']) . '</td>
                                                            </tr>';
                                                        }
                                                        $i++;
                                                    }
                                                ?>
                                                <tr>
                                                    <td>B2B Set</td>
                                                    <td><?php echo b2blogic($rowresults['B2BID'], $_GET['setid'], $rowresults['ARTISTNAME'], "BUTTONS"); ?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="tab-pane" id="contract">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-borderless table-striped mb-0">
                                                <tbody>
                                                <?php

                                                $i = 0;
                                                foreach ($fieldsquery as $key => $value) {
                                                    if ($fieldscategory[$i] == "CONTRACTDETAILS") {
                                                        if ($fieldsdescription[$i] == "") {
                                                            $fieldname = $value;
                                                        } else {
                                                            $fieldname = $fieldsdescription[$i];
                                                        }

                                                        echo '<tr>
                                                        <td style="width: 35%;">' . $fieldname . '</td>
                                                        <td>' . getField($fieldstype[$i], $fieldsid[$i], $value, $rowresults[$value], $_GET['setid']) . '</td>
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
                                                    if ($fieldscategory[$i] != "CONTRACTDETAILS" && $fieldscategory[$i] != "SETDETAILS") {
                                                        if ($fieldsdescription[$i] == "") {
                                                            $fieldname = $value;
                                                        } else {
                                                            $fieldname = $fieldsdescription[$i];
                                                        }
                                                        echo '<tr>
                                                        <td style="width: 35%;">' . $fieldname . '</td>
                                                        <td>' . getField($fieldstype[$i], $fieldsid[$i], $value, $rowresults[$value], $_GET['setid']) . '</td>
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

                            <div class="tab-pane" id="stage">

                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Stage Information</h5>

                                    <div class="row">
                                        <h6>Select Stage</h6>
                                        <select class="form-control select2" id="stageSelect">
                                            <?php
                                            $query = mysqli_query($mysqli, 'SELECT stages.STAGENAME, stages.STAGEID FROM shows JOIN stages ON shows.STAGEID = stages.STAGEID WHERE shows.SHOWID = ' . $_GET['setid']);
                                            while($row = $query->fetch_array()) {
                                                echo '<option value="' . $row['STAGEID'] . '">' . $row['STAGENAME'] . '</option>';
                                            }

                                            $query = mysqli_query($mysqli, 'SELECT * FROM stages WHERE VENUEID = '. $venueid . ' ORDER BY STAGENAME ASC');
                                            while($row = $query->fetch_array()) {
                                                echo '<option value="' . $row['STAGEID'] . '">' . $row['STAGENAME'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div><br>
                                    <div class="row">
                                        <button class="btn btn-success" onclick="javascript:assignStage();">Assign Stage</button>
                                    </div>

                            </div>

                    <div class="tab-pane" id="rider">

                    </div>

                            <!-- end settings content-->

                        </div> <!-- end tab-content -->
                    </div> <!-- end card-box-->
                    </div>


                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <div class="card">
                            <div class="card-body"><h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i>
                                    Other shows</h5>
                                <div class="table-responsive">
                                    <?php
                                    $_GET['artistid'] = $rowresults['ARTISTID'];
                                    include('content/components/eventsplayingwidget.php');
                                    ?>

                                </div></div>
                            </div></div></div>

                </div> <!-- end col -->




<script type="text/javascript">
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