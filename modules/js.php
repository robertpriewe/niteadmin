<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>

<!-- third party js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<script src="assets/libs/moment/min/moment.min.js"></script>
<script src="assets/libs/x-editable/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<!-- third party js ends -->

<!-- init js -->

<script type="text/javascript">
    $(document).ready(function() {
        $.fn.editable.defaults.mode = 'inline';
        $.fn.combodate.defaults.maxYear = 2022;
        $.fn.combodate.defaults.minYear = 2019;




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
        }).fail(function() {
            alert( "Error" );
        });
    }

    function clickEdit() {
        $('.changefield').editable('toggleDisabled');
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

    function refreshSearch() {
        if ($('#top-search').val().length >= 2) {
            $('#searchBody').html('');
            $('#searchTitle').html('Searching..<br><div class="spinner-border text-primary m-2" role="status"><span class="sr-only">Loading...</span></div>');
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

<!-- Modal-Effect -->
<script src="assets/libs/custombox/custombox.min.js"></script>

<!-- Tippy js-->
<script src="../assets/libs/tippy.js/tippy.all.min.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>

</body>
</html>