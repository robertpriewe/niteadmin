<?php
if (!isset($_GET['eventvendorid'])) {
    echo 'No ID found';
    die;
}

$query = mysqli_query($mysqli, "SELECT * FROM events_vendors_fields_list LEFT JOIN events_vendors_fields_categories ON events_vendors_fields_list.FIELDNAME_CATEGORY = events_vendors_fields_categories.ID WHERE HIDDEN = '0' ORDER BY events_vendors_fields_list.POSITION, events_vendors_fields_list.ID ASC");


while($row = $query->fetch_array()) {
    $fieldsquery[] = $row['FIELDNAME'];
    $fieldsdescription[] = $row['FIELDNAME_TEXT'];
    $fieldscategory[] = $row['CATEGORY'];
    $fieldstype[] = $row['TYPE'];
}
$query = mysqli_query($mysqli, "SELECT * FROM events_vendors_link LEFT JOIN events_vendors_fields ON events_vendors_link.EVENTVENDORID = events_vendors_fields.EVENTVENDORID LEFT JOIN events ON events_vendors_link.EVENTID = events.EVENTID RIGHT JOIN shows ON events.EVENTID = shows.EVENTID RIGHT JOIN stages ON shows.STAGEID = stages.STAGEID RIGHT JOIN venues ON stages.VENUEID = venues.VENUEID RIGHT JOIN vendors ON events_vendors_link.VENDORID = vendors.VENDORID WHERE events_vendors_link.EVENTVENDORID = " . $_GET['eventvendorid'] . " LIMIT 0, 1");

while ($row = $query->fetch_array()) {
    $rowresults = $row;
}
$venueid = $rowresults['VENUEID'];
?>

            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <ul class="nav nav-pills navtab-bg">
                                    <li class="nav-item">
                                        <a href="#setinfo" data-toggle="tab" aria-expanded="true" class="nav-link active ml-0">
                                            <i class="mdi mdi-face-profile mr-1"></i>Logistics
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#contract" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-paperclip mr-1"></i>Contract/Financial Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#other" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-text mr-1"></i>Other
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <div class="text-lg-right mt-3 mt-lg-0">

                                    <button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="javascript:clickEdit();"><i class="mdi mdi-settings"></i> Edit</button>
                                    <button type="button" class="btn btn-primary waves-effect waves-light mr-1" onclick="javascript:document.location.href='?page=vendordetails&vendorid=<?php echo $rowresults['VENDORID']; ?>';"><i class="mdi mdi-information"></i> Vendor Info</button>
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
                                                    if ($fieldscategory[$i] == "LOGISTICS") {
                                                        if ($fieldsdescription[$i] == "") {
                                                            $fieldname = $value;
                                                        } else {
                                                            $fieldname = $fieldsdescription[$i];
                                                        }
                                                        if ($fieldstype[$i] == "TEXT") {
                                                            echo '<tr>
                                                        <td style="width: 35%;">' . $fieldname . '</td>
                                                        <td><a class="changefield" href="#" data-type="text" data-pk="{id:' . $_GET['eventvendorid'] . ',page:\'events_vendors_fields\'}" data-name="' . $value . '">' . $rowresults[$value] . '</a></td>
                                                        </tr>';
                                                        } else if ($fieldstype[$i] == "DATETIME") {

                                                            if (is_null($rowresults[$value]) == TRUE) {
                                                                $datetime = "";
                                                            } else {
                                                                $datetime = date("Y/m/d h:i A", strtotime($rowresults[$value]));
                                                            }

                                                            echo '<tr>
                                                        <td style="width: 35%;">' . $fieldname . '</td>
                                                        <td><a class="changefield" href="#" data-type="combodate" data-template="MMM D YYYY  hh:mm a" data-format="YYYY-MM-DD HH:mm:ss" data-viewformat="YYYY-MM-DD hh:mm a" data-pk="{id:' . $_GET['eventvendorid'] . ',page:\'events_vendors_fields\'}" data-name="' . $value . '">' .  $datetime . '</a></td>
                                                        </tr>';
                                                        }
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
                                                        <td><a class="changefield" href="#" data-type="text" data-pk="{id:' . $_GET['eventvendorid'] . ',page:\'events_vendors_fields\'}" data-name="' . $value . '">' . $rowresults[$value] . '</a></td>
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
                                                    if ($fieldscategory[$i] != "LOGISTICS" && $fieldscategory[$i] != "SETDETAILS") {
                                                        if ($fieldsdescription[$i] == "") {
                                                            $fieldname = $value;
                                                        } else {
                                                            $fieldname = $fieldsdescription[$i];
                                                        }
                                                        echo '<tr>
                                                        <td style="width: 35%;">' . $fieldname . '</td>
                                                        <td><a class="changefield" href="#" data-type="text" data-pk="{id:' . $_GET['eventvendorid'] . ',page:\'shows_fields\'}" data-name="' . $value . '">' . $rowresults[$value] . '</a></td>
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





                        </div> <!-- end tab-content -->
                    </div> <!-- end card-box-->
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <div class="card">
                            <div class="card-body"><h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i>
                                    Other events</h5>
                                <div class="table-responsive">
                                    <?php
                                    $_GET['vendorid'] = $rowresults['VENDORID'];
                                    include('content/components/eventsplayingwidget.php');
                                    ?>

                                </div>
                            </div></div></div></div>

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
    </script>