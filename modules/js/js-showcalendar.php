<script src="assets/libs/@fullcalendar/core/main.min.js"></script>
<script src="assets/libs/@fullcalendar/bootstrap/main.min.js"></script>
<script src="assets/libs/@fullcalendar/daygrid/main.min.js"></script>
<script src="assets/libs/@fullcalendar/timegrid/main.min.js"></script>
<script src="assets/libs/@fullcalendar/list/main.min.js"></script>
<script src="assets/libs/@fullcalendar/interaction/main.min.js"></script>

<!-- Calendar init -->
<script type="text/javascript">
    ! function (l) {
        "use strict";
        function e() {
            this.$body = l("body"), this.$modal = l("#event-modal"), this.$calendar = l("#calendar"), this.$formEvent = l("#form-event"), this.$btnNewEvent = l("#btn-new-event"), this.$btnDeleteEvent = l("#btn-delete-event"), this.$btnSaveEvent = l("#btn-save-event"), this.$modalTitle = l("#modal-title"), this.$calendarObj = null, this.$selectedEvent = null, this.$newEventData = null
        }
         e.prototype.init = function () {
            var e = new Date(l.now());
            var t = [
                    <?php
                    $query = mysqli_query($mysqli, "SELECT * FROM events");
                    $totalrows = $query->num_rows;
                    $i = 0;
                    while($row = $query->fetch_array()) {
                        if ($row['EVENTSTATUS'] == 'Confirmed') {
                            $status = 'bg-primary';
                            $text = '';
                        } elseif ($row['EVENTSTATUS'] == 'Pending') {
                            $status = 'bg-warning';
                            $text = ' (Pending)';
                        } elseif ($row['EVENTSTATUS'] == 'Hold') {
                            $status = 'bg-dark';
                            $text = ' (Hold)';
                        } elseif ($row['EVENTSTATUS'] == 'Cancelled') {
                            $status = 'bg-danger';
                            $text = ' (Cancelled)';
                        } else {
                            $status = 'bg-dark';
                            $text = ' (NA)';
                        }
                        echo '{title: "' . $row['EVENTNAME'] . $text . '",
                        start: new Date("' . $row['EVENTSTARTDATE'] . '"),
                        url: "?page=eventdetails&eventid=' . $row['EVENTID'] . '",
                        className: "' . $status . '"}';
                        if ($i < $totalrows) {
                            echo ',
                            ';
                        }
                        $i++;
                    }
                    ?>],
                a = this;
            a.$calendarObj = new FullCalendar.Calendar(a.$calendar[0], {
                plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid", "list"],
                slotDuration: "00:15:00",
                themeSystem: "bootstrap",
                bootstrapFontAwesome: !1,
                buttonText: {
                    today: "Today",
                    month: "Month",
                    week: "Week",
                    day: "Day",
                    list: "List",
                    prev: "Prev",
                    next: "Next"
                },
                defaultView: "dayGridMonth",
                handleWindowResize: !0,
                height: l(window).height() - 200,
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                },
                events: t,
                displayEventTime : false,
                editable: !0,
                droppable: !0,
                eventLimit: !0,
                selectable: !0,
                dateClick: function (e) {
                    a.onSelect(e)
                },
                eventClick: function (info) {
                }
            }), a.$calendarObj.render()
        }, l.CalendarApp = new e, l.CalendarApp.Constructor = e
    }(window.jQuery),
        function () {
            "use strict";
            window.jQuery.CalendarApp.init()
        }();
</script>