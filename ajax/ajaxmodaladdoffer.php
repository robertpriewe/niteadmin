<?php
session_start();
error_reporting(E_ALL);
include ('../modules/sql.php');

/*


 */

?>
<div class="col-lg-12">
    <div class="card-box">

        <div id="btnwizard">
            <ul class="nav nav-pills nav-justified form-wizard-header mb-4">
                <li class="nav-item">
                    <a href="#tab12" data-toggle="tab" class="nav-link pt-2 pb-2">
                        <span class="number">1</span>
                        <span class="d-none d-sm-inline">Event</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#tab22" data-toggle="tab" class="nav-link pt-2 pb-2">
                        <span class="number">2</span>
                        <span class="d-none d-sm-inline">Artist</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#tab32" data-toggle="tab" class="nav-link pt-2 pb-2">
                        <span class="number">3</span>
                        <span class="d-none d-sm-inline">Fields</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content mb-0 b-0">

                <div class="tab-pane fade" id="tab12">
                    <div class="row">
                        <div class="col-9">

                            <div id="divSelectEvent"></div>

                            <div style="display:none;" id="divNewEvent"></div>
                            <div>
                                <a href="javascript:toggleEvents();" id="eventText">Event not found? Click to create</a>
                            </div>
                            <br>
                            <br><br>


                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>

                <div class="tab-pane fade" id="tab22">
                    <div class="row">
                        <div class="col-12">

                            <div id="divSelectArtist"></div>
                            <div style="display:none;" id="divNewArtist">
                                <h6>Add new artist</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="newArtistName">
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-success waves-effect waves-light" onclick="javscript:checkArtist();">Add</button>
                                    </div>
                                </div>
                            </div>

                            <div><a href="javascript:toggleArtists();" id="artistText">Artist not found? Click to create</a></div>
                            <br>
                            <br><br>

                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>

                <div class="tab-pane" id="tab32">
                    <div class="row">
                        <div class="col-12">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="offer">Offer PDF</label><br>
                                        <input type="file" id="offer" name="offer" value="Select file" class="btn btn-primary form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="guarantee">Guarantee</label>
                                        <input type="text" class="form-control" id="guarantee" aria-describedby="guaranteehelp" placeholder="E.g. $5000">
                                        <small id="guaranteehelp" class="form-text text-muted">USD amount</small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="hotel">Hotel</label>
                                        <input type="text" class="form-control" id="hotel" aria-describedby="hotelhelp" placeholder="E.g. $300">
                                        <small id="hotelhelp" class="form-text text-muted">USD amount</small>
                                    </div>
                                    <div class="form-group col-md-3"><br><br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="custom-control-input" id="buyouthotelcheck">
                                        <label class="custom-control-label" for="buyouthotelcheck">Hotel buyout?</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="hotelnotes">Hotel Notes</label>
                                        <input type="text" class="form-control" id="hotelnotes" placeholder="E.g. Marriott Downtown">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="groundtransportation">Ground Transportation</label>
                                        <input type="text" class="form-control" id="groundtransportation" aria-describedby="groundhelp" placeholder="E.g. $200">
                                        <small id="groundhelp" class="form-text text-muted">USD amount</small>
                                    </div>
                                    <div class="form-group col-md-3"><br><br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="custom-control-input" id="buyoutgroundcheck">
                                        <label class="custom-control-label" for="buyoutgroundcheck">Ground buyout?</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="groundnotes">Ground Transportation Notes</label>
                                        <input type="text" class="form-control" id="groundnotes" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="hospitality">Hospitality</label>
                                        <input type="text" class="form-control" id="hospitality" aria-describedby="hospitalityhelp" placeholder="E.g. $300">
                                        <small id="hospitalityhelp" class="form-text text-muted">USD amount</small>
                                    </div>
                                    <div class="form-group col-md-3"><br><br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="custom-control-input" id="buyouthospitalitycheck">
                                        <label class="custom-control-label" for="buyouthospitalitycheck">Hospitality buyout?</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="hospitalitynotes">Hospitality Notes</label>
                                        <input type="text" class="form-control" id="hospitalitynotes" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="setduration">Minumum Set Duration</label>
                                        <input type="text" class="form-control" id="setduration" aria-describedby="setdurationhelp" placeholder="E.g. 120">
                                        <small id="setdurationhelp" class="form-text text-muted">Minimum set duration in minutes</small>
                                    </div>
                                </div>
                            </form>

                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>

                <div class="float-right">
                    <input type='button' class='btn btn-primary button-finish' name='finish' value='Finish' id="button-finish" style="display:none;" onclick="javascript:validateOfferForm();"/>
                    <input type='button' class='btn btn-secondary button-next' name='next' value='Next' />
                </div>
                <div class="float-left">
                    <input type='button' class='btn btn-secondary button-previous' name='previous' value='Previous' />
                </div>

                <div class="clearfix"></div>

            </div> <!-- tab-content -->
        </div> <!-- end #btnwizard-->


    </div>
</div> <!-- end card-box -->

<script type="text/javascript">
    function checkArtist() {
        if (displayList == "newArtist") {
            var newArtistName = $('#newArtistName').val();
            if (newArtistName == "") {
                alert ("Please type in a new artist name");
            } else {
                $.ajax({
                    type: "POST",
                    data: {newArtistName: newArtistName},
                    url: 'ajax/checkartistexists.php',
                    context: document.body
                }).done(function (response) {
                    artistStatus = response;
                    if (artistStatus == "new") {
                        addNewArtist(newArtistName)
                    } else {
                        alert('Artist ' + newArtistName + ' already exists, please select from dropdown!');
                        toggleArtists();
                        $('#selectArtists').val(artistStatus); // Select the option with a value of '1'
                        $('#selectArtists').trigger('change'); // Notify any JS components that the value changed
                    }
                }).fail(function () {
                    alert("Error");
                });
            }
        } else {
            assignToEvent("");
        }
    }

    function addNewArtist(newArtistName) {
        $.ajax({
            type: "POST",
            data: {artistname: newArtistName},
            url: 'ajax/addartist.php',
            context: document.body
        }).done(function (response) {
            artistid = response;
            if (artistid != "") {
                alert('New artist created');
                listArtists();
                $(".select2").select2();
                $('#selectArtists').val(artistid); // Select the option with a value of '1'
                $('#selectArtists').trigger('change'); // Notify any JS components that the value changed
                toggleArtists();

            } else {
                alert('Error generating artistid');
            }
        }).fail(function () {
            alert("Error");
        });
    }


    var displayList = "artistList"
    function toggleArtists() {
        $('#divSelectArtist').slideToggle();
        $('#divNewArtist').slideToggle(function(){
            if ($('#divNewArtist').is(":visible") == true) {
                $('#artistText').html("Pick existing artist from list");
                displayList = "newArtist";
            } else {
                $('#artistText').html("Artist not found? Click to create");
                displayList = "artistList";
            }
        });
    }

    var displayListEvents = "eventList"
    function toggleEvents() {
        $('#divSelectEvent').slideToggle();
        $('#divNewEvent').slideToggle();
        if (displayListEvents == 'eventList') {
            $('#eventText').html("Pick existing event from list");
            displayListEvents = "newEvent";
        } else {
            $('#eventText').html("Event not found? Click to create");
            displayListEvents = "eventList";
        }
    }

    function listEvents() {
        $.ajax({
            type: "GET",
            url: 'ajax/importoffer/listevents.php',
            context: document.body
        }).done(function(response) {
            $('#divSelectEvent').html(response);
            $(".select2").select2();
            document.styleSheets[0].insertRule('.select2-container--open { z-index: 999999; }', 0);
        }).fail(function() {
            alert("Error");
        });
    }

    function loadNewEventForm() {
        $.ajax({
            type: "GET",
            url: 'ajax/ajaxmodaladdnewevent.php',
            context: document.body
        }).done(function(response) {
            $('#divNewEvent').html(response);
            $(".select2").select2();
            document.styleSheets[0].insertRule('.select2-container--open { z-index: 999999; }', 0);
        }).fail(function() {
            alert("Error");
        });
    }


    function listArtists() {
        $.ajax({
            type: "GET",
            url: 'ajax/importoffer/listartists.php',
            context: document.body
        }).done(function(response) {
            $('#divSelectArtist').html(response);
            $(".select2").select2();
            document.styleSheets[0].insertRule('.select2-container--open { z-index: 999999; }', 0);
        }).fail(function() {
            alert("Error");
        });
    }


    function validateOfferForm() {
        var selectEventAjax = $('#selectEventAjax').val();
        var selectArtistsAjax = $('#selectArtistsAjax').val();
        var offer = $('#offer').val();
        var guarantee = $('#guarantee').val();
        var hotel = $('#hotel').val();
        var buyouthotelcheck = $('#buyouthotelcheck').is(":checked");
        var hotelnotes = $('#hotelnotes').val();
        var groundtransportation = $('#groundtransportation').val();
        var buyoutgroundcheck = $('#buyoutgroundcheck').is(":checked");
        var groundnotes = $('#groundnotes').val();
        var hospitality = $('#hospitality').val();
        var buyouthospitalitycheck = $('#buyouthospitalitycheck').is(":checked");
        var hospitalitynotes = $('#hospitalitynotes').val();
        var setduration = $('#setduration').val();

        var showid;
        if (selectEventAjax == "Select") {
            alert("You have to select a valid event!");
        } else if (selectArtistsAjax == "Select") {
            alert("You have to select a valid artist!");
        } else {
            $.ajax({
                type: "GET",
                url: 'ajax/assignartist.php?eventid=' + selectEventAjax + '&artistid=' + selectArtistsAjax,
                context: document.body
            }).done(function (response) {
                alert(response);
                showid = response;
            }).fail(function () {
                alert("Error");
            });

            $.ajax({
                type: "POST",
                data: {
                    offer: offer,
                    guarantee: guarantee,
                    hotel: hotel,
                    buyouthotelcheck: buyouthotelcheck,
                    hotelnotes: hotelnotes,
                    groundtransportation: groundtransportation,
                    buyoutgroundcheck: buyoutgroundcheck,
                    groundnotes: groundnotes,
                    hospitality: hospitality,
                    buyouthospitalitycheck: buyouthospitalitycheck,
                    hospitalitynotes: hospitalitynotes,
                    setduration: setduration
                },
                url: 'ajax/importoffer/addnewoffer.php?showid=' + showid,
                context: document.body
            }).done(function (response) {
                alert(response);
            }).fail(function () {
                alert("Error");
            });
        }
    }

    function validateOfferForm2() {
        var offer = $('#offer').val();
        var buyouthotelcheck = $('#buyouthotelcheck');
        alert(buyouthotelcheck);
    }
</script>

<script src="../assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $("#btnwizard").bootstrapWizard({
        nextSelector: ".button-next",
        previousSelector: ".button-previous",
        finishSelector: ".button-finish",
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onTabShow: function(tab, navigation, index) {
            if (index == 2) {
                $('#button-finish').show();
            } else {
                $('#button-finish').hide();
            }
        }
    });

    listEvents();
    loadNewEventForm();

    listArtists();
});
</script>

<style>
    .nav-link.pt-2 {
        pointer-events: none;
        cursor: default;
    }
</style>