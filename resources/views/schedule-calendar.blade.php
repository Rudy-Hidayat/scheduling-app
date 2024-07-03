<!DOCTYPE html>
<html>
<head>
    <title>Schedule Calendar</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/daygrid/main.min.css" rel="stylesheet">
    <style>
        body {
            padding: 0;
            margin: 0;
            zoom: 0.75; /* Set default zoom to 75% */
        }
        .container {
            max-width: 100%;
            padding-left: 0;
            padding-right: 0;
        }
        #calendar {
            width: 100vw; /* Make the calendar fill the viewport width */
            max-width: 100%;
            margin: 0 auto;
            font-size: 1.2em;
        }
        .fc-daygrid-day-frame {
            padding: 10px; /* Adjust padding for better fit */
        }
        .title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        /* Add the following CSS */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: black;
            opacity: 0.1;
            z-index: 1040;
        }
        .modal-backdrop.show {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="title-container">
            <h1>Schedule Calendar</h1>
        </div>
        <div id="calendar"></div>
    </div>

    <!-- Modal for event details -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="eventName"></span></p>
                    <p><strong>NPM:</strong> <span id="eventNPM"></span></p>
                    <p><strong>Asal Instansi:</strong> <span id="eventInstansi"></span></p>
                    <p><strong>Purpose:</strong> <span id="eventPurpose"></span></p>
                    <p><strong>Date:</strong> <span id="eventDate"></span></p>
                    <p><strong>Time:</strong> <span id="eventTime"></span></p>
                    <p><strong>End Time:</strong> <span id="eventEndTime"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/daygrid/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/interaction/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '/api/schedules/accepted', // Endpoint API untuk mendapatkan data jadwal
                eventDataTransform: function(event) {
                    return {
                        title: event.time.substr(0, 5) + ' - ' + event.end_time.substr(0, 5) + ' ' + event.purpose,
                        start: event.date + 'T' + event.time,
                        end: event.date + 'T' + event.end_time,
                        extendedProps: {
                            name: event.name,
                            npm: event.npm,
                            asal_instansi: event.asal_instansi,
                            purpose: event.purpose,
                            date: event.date,
                            time: event.time.substr(0, 5),
                            end_time: event.end_time.substr(0, 5)
                        }
                    };
                },
                eventTimeFormat: { // Remove the default time display
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false,
                    meridiem: false
                },
                displayEventTime: false, // Add this line
                eventClick: function(info) {
                    // Set data in modal
                    document.getElementById('eventName').innerText = info.event.extendedProps.name;
                    document.getElementById('eventNPM').innerText = info.event.extendedProps.npm;
                    document.getElementById('eventInstansi').innerText = info.event.extendedProps.asal_instansi;
                    document.getElementById('eventPurpose').innerText = info.event.extendedProps.purpose;
                    document.getElementById('eventDate').innerText = info.event.extendedProps.date;
                    document.getElementById('eventTime').innerText = info.event.extendedProps.time;
                    document.getElementById('eventEndTime').innerText = info.event.extendedProps.end_time;
                    // Show modal
                    $('#eventModal').modal('show');
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>
