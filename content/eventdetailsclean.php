<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                                <li class="breadcrumb-item"><a href="?page=showsets">Shows / Sets List</a></li>
                                <li class="breadcrumb-item active"><?php echo $title; ?></li>
                            </ol>
                        </div>
                        <h4 class="page-title">test</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
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
                                        <a href="#rider" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-paper-cut-vertical mr-1"></i>Rider
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <div class="text-lg-right mt-3 mt-lg-0">
                                    <button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="javascript:clickEdit();"><i class="mdi mdi-settings"></i> Edit</button>
                                    <button type="button" class="btn btn-primary waves-effect waves-light mr-1"><i class="mdi mdi-information"></i> Artist Info</button>
                                </div>
                            </div><!-- end col-->
                        </div> <!-- end row -->
                    </div> <!-- end card-box -->
                </div><!-- end col-->
            </div> <!-- end row -->



            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card-box">
                        <div class="tab-content">

                            <div class="tab-pane show active" id="setinfo">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            asddasfsa
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="tab-pane" id="contract">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            placeholder
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="tab-pane" id="other">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            placeholder232424
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="stage">
                                <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Stage Information</h5>
                                Placeholder
                            </div>


                            <div class="tab-pane" id="rider">
                                <form>
                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Rider Information</h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="firstname">Rider fields</label>
                                                <input type="text" class="form-control" id="firstname" placeholder="rider">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lastname">More Info</label>
                                                <input type="text" class="form-control" id="lastname" placeholder="more">
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </form>
                            </div> <!-- end settings content-->


                        </div> <!-- end tab-content -->
                    </div> <!-- end card-box-->


                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <div class="card-box"><h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i>
                                    Other shows</h5>
                                <div class="table-responsive">
                                    test
                                </div>
                            </div>
                        </div>
                    </div>


                </div> <!-- end col -->
            </div>  <!-- end row-->
        </div> <!-- container -->
    </div> <!-- content -->
</div> <!-- content-page -->
