<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>



<!-- third party js -->
<script src="assets/libs/clockpicker/bootstrap-clockpicker.min.js"></script>
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
<script src="assets/libs/selectize/js/standalone/selectize.min.js"></script>


<script src="assets/libs/moment/min/moment.min.js"></script>
<script src="assets/libs/x-editable/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<!-- third party js ends -->

<!-- Modal-Effect -->
<script src="assets/libs/custombox/custombox.min.js"></script>

<!-- init js -->

<script type="text/javascript">
$(document).ready(function() {
    $.fn.editable.defaults.mode = 'inline';
    $.fn.combodate.defaults.maxYear = 2022;
    $.fn.combodate.defaults.minYear = 2019;
    $.fn.editableform.buttons = '<button type="submit" class="btn btn-primary editable-submit btn-sm waves-effect waves-light"><i class="mdi mdi-check"></i></button><button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect"><i class="mdi mdi-close"></i></button>';

    $(".selectize-close-btn").selectize({
        plugins: ["remove_button"],
        persist: !1,
        create: !0,
        render: {
            item: function (e, t) {
                return '<div>"' + t(e.text) + '"</div>'
            }
        },
        onDelete: function (e) {
            return confirm(1 < e.length ? "Are you sure you want to remove these " + e.length + " items?" : 'Are you sure you want to remove "' + e[0] + '"?')
        }
    });
    $(".selectize-optgroup").selectize({
        sortField: "text",
        plugins: ["remove_button"],
        persist: !1,
        create: !0,
        render: {
            item: function (e, t) {
                return '<div>' + t(e.text) + '</div>'
            }
        },
        onDelete: function (e) {

        },
        onItemAdd: function(e) {
            userid = e.split('-')[0];
            fieldid = e.split('-')[1];
            idtype = e.split('-')[2];
            $.ajax({
                type: "GET",
                url: 'ajax/assignfieldadd.php?idtype=' + idtype + '&userid=' + userid + '&fieldid=' + fieldid + '&table=<?php if(isset($_GET['setid'])) { echo "shows"; } else { echo "events"; } ?>',
                context: document.body
            }).done(function(response) {

            }).fail(function() {
                alert("Error");
            });
        },
        onItemRemove: function(e, t) {
            userid = e.split('-')[0];
            fieldid = e.split('-')[1];
            idtype = e.split('-')[2];
            $.ajax({
                type: "GET",
                url: 'ajax/assignfielddelete.php?idtype=' + idtype + '&userid=' + userid + '&fieldid=' + fieldid + '&table=<?php if(isset($_GET['setid'])) { echo "shows"; } else { echo "events"; } ?>',
                context: document.body
            }).done(function(response) {

            }).fail(function() {
                alert("Error");
            });
        }

    });


    $('.changefield').editable({
        url: 'ajax/updateshowfield.php?page=showevents',
        disabled: true
    });


    $("#tickets-table").DataTable({
        "aaSorting": [],
        "columnDefs": [
            {
                "targets": ['hide-col'],
                "visible": false,
                "searchable": true
            }],
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    })

    $("#advancing-table").DataTable({
        "aaSorting": [],
        "paging": false,
        "columnDefs": [
            {
                "targets": ['hide-col'],
                "visible": false,
                "searchable": true
            }]
    })

    $(".select2").select2();

    $('#customSwitch1').change(function() {
        filterTable();
    });

    function filterTable() {
        if ($('#customSwitch1').prop('checked') == false) {
            var table = $('#tickets-table').DataTable();
            var filteredData = table
                .column(':contains(PAST/UPCOMING)')
                .search('UPCOMING')
                .draw();
        } else {
            var table = $('#tickets-table').DataTable();
            var filteredData = table
                .column(':contains(PAST/UPCOMING)')
                .search('')
                .draw();
        }
    }

    filterTable();

    <?php
        if ($_GET['page'] == "setdetails" || $_GET['page'] == "eventdetails") {
            echo "
        if (window.location.hash) {
            var hash = window.location.hash.substring(1);
            $('#nav' + hash).tab('show');
            if (hash == 'artistdetails') {
                loadArtistDetails();
            }
        }";
        }
    if ($_GET['page'] == "showcontacts" && isset($_GET['contactid'])) {
        echo "
        openModal('View Contact','ajax/ajaxmodalviewcontact.php?contactid=" . $_GET['contactid'] . "');
        ";
    }
    ?>

});

function openModal(title, ajaxfilename) {
    $('#modalContent').html('<div class="spinner-border avatar-lg text-primary m-2" role="status"></div>');
    var title;
    var ajaxfilename;
    $('#modalTitle').html(title);
    $.ajax({
        type: "GET",
        url: ajaxfilename,
        context: document.body
    }).done(function(response) {
        $('#modalContent').html(response);
        $(".select2").select2();
        document.styleSheets[0].insertRule('.select2-container--open { z-index: 999999; }', 0);
        $('#custom-modal').modal('show');
    }).fail(function() {
        alert( "Error" );
    });
}

function clickEdit() {
    $('.changefield').editable('toggleDisabled');
}

function clickAsssignedTo(fieldid) {
    $('#assignedto_view-' + fieldid).hide();
    $('#assignedto_edit-' + fieldid).show();
}

function loadRider(setid) {
    var setid;
    $('#rider').html('Loading...');
    $.ajax({
        type: "GET",
        url: 'content/components/loadrider.php?setid=' + setid,
        context: document.body
    }).done(function(response) {
        $('#rider').html(response);
    }).fail(function() {
        alert("Error");
    });
}

var firstTime;
function doSearch() {
    if ($('#top-search').val().length == 0) {
        $('#searchTitle').html('Please type some keywords..');
        $('#searchBody').html('');
    } else {
        $('#searchBody').html('');
        $('#searchTitle').html('Searching..<br><div class="spinner-border text-primary m-2" role="status"><span class="sr-only">Loading...</span></div>');
        firstTime = new Date().getTime();
        setTimeout(checkSearch, 2000);
    }
}

function checkSearch() {
    timeDiff = new Date().getTime() - firstTime;
    if (timeDiff < 3000) {
        refreshSearch();
    }
}

function refreshSearch() {
    if ($('#top-search').val().length >= 2) {
        $.ajax({
            type: "POST",
            data: {'query': $('#top-search').val() },
            url: 'ajax/topsearch.php',
            context: document.body
        }).done(function(response) {
            $('#searchTitle').html('');
            $('#searchBody').html(response);
        }).fail(function() {
            alert("Error");
        });
    } else {
        $('#searchTitle').html('Please type some keywords..');
        $('#searchBody').html('');
    }
}

</script>


<!-- Plugins Js -->
<script src="assets/libs/select2/js/select2.min.js"></script>

<!-- Tippy js-->
<script src="assets/libs/tippy.js/tippy.all.min.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>


