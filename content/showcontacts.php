            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                        <?php
                        $query = mysqli_query($mysqli, "SELECT *, GROUP_CONCAT(DISTINCT artists.ARTISTNAME) AS RELATEDARTISTS, GROUP_CONCAT(DISTINCT vendors.VENDORNAME) AS RELATEDVENDORS, GROUP_CONCAT(DISTINCT venues.VENUENAME) AS RELATEDVENUES, contacts.CONTACTID AS MAINCONTACTID FROM contacts LEFT JOIN contacts_link ON contacts.CONTACTID = contacts_link.CONTACTID LEFT JOIN artists ON contacts_link.LINKID = artists.ARTISTID AND contacts_link.LINKTABLE = 'artists' LEFT JOIN vendors ON contacts_link.LINKID = vendors.VENDORID AND contacts_link.LINKTABLE = 'vendors' LEFT JOIN venues ON contacts_link.LINKID = venues.VENUEID AND contacts_link.LINKTABLE = 'venues' WHERE contacts.CONTACTID <> 0 GROUP BY contacts.CONTACTID ORDER BY FIRSTNAME, LASTNAME ASC");

                        if ($query->num_rows > 0) {
                            while($row = $query->fetch_assoc()) {
                                $showsquery[] = $row;
                            }
                        } else {
                            $showsquery = array();
                        }


                        ?>
                        <div class="row">
                            <div class="col-lg-12 row">
                                <div class="col-lg-10">
                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Contacts</h5>
                                </div>
                                <div class="col-lg-2">
                                    <div class="text-lg-right mt-3 mt-lg-0">
                                        <a href="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal('Add New Contact','ajax/ajaxmodaladdnewcontact.php');"><i class="mdi mdi-plus-circle mr-1"></i> New Contact</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                            <thead class="bg-light">
                            <tr>
                                <th class="font-weight-medium">Name</th>
                                <th class="font-weight-medium">Company</th>
                                <th class="font-weight-medium">Role</th>
                                <th class="font-weight-medium">Phone</th>
                                <th class="font-weight-medium">E-Mail</th>
                                <th class="font-weight-medium">Relationship</th>
                            </tr>
                            </thead>

                            <tbody class="font-14">


                            <?php
                            if (count($showsquery) > 0) {
                                foreach ($showsquery as $showsrow) {
                                    //<td>' . $showsrow['MAINCONTACTID'] . '</td>
                                    echo '<tr>
                                <td><a href="#custom-modal" data-animation="fadein" data-toggle="modal" data-overlayColor="#38414a" onclick="javascript:openModal(\'View Contact\',\'ajax/ajaxmodalviewcontact.php?contactid=' . $showsrow['MAINCONTACTID'] . '\');"><b>' . $showsrow['FIRSTNAME'] . ' ' . $showsrow['LASTNAME'] . '</b></a></td>
                                <td>' . $showsrow['COMPANY'] . '</td>
                                <td>' . $showsrow['ROLE'] . '</td>
                                <td>' . $showsrow['PHONE'] . '</td>
                                <td>' . $showsrow['EMAIL'] . '</td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">' . $showsrow['RELATEDARTISTS'] . ' ' . $showsrow['RELATEDVENDORS'] . ' ' . $showsrow['RELATEDVENUES'] . '</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>';
                                }
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>

                </div><!-- end col -->
                </div>
            </div>
            <!-- end row -->



        </div> <!-- container -->
