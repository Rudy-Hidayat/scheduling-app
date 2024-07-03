<!DOCTYPE html>
<html>
<head>
    <title>Schedule Status</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }
        .thead-dark th {
            background-color: #343a40;
            color: #fff;
        }
        .container {
            max-width: 90%;
        }
        .title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="title-container">
            <h2>Status Pengajuan</h2>
        </div>
        <table class="table table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Nama</th>
                    <th>NPM</th>
                    <th>Instansi</th>
                    <th>WhatsApp</th>
                    <th>Purpose</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Place</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody id="scheduleStatusBody"></tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/api/schedules/status',
                method: 'GET',
                success: function(response) {
                    response.forEach(function(schedule) {
                        $('#scheduleStatusBody').append(
                            '<tr>' +
                                '<td>' + schedule.name + '</td>' +
                                '<td>' + schedule.npm + '</td>' +
                                '<td>' + schedule.asal_instansi + '</td>' +
                                '<td>' + schedule.nomor_whatsapp + '</td>' +
                                '<td>' + schedule.purpose + '</td>' +
                                '<td>' + schedule.date + '</td>' +
                                '<td>' + schedule.time + '</td>' +
                                '<td>' + schedule.end_time + '</td>' +
                                '<td>' + schedule.status + '</td>' +
                                '<td>' + schedule.place + '</td>' +
                                '<td>' + schedule.notes + '</td>' +
                            '</tr>'
                        );
                    });
                },
                error: function(error) {
                    console.log(error);
                    alert('There was an error fetching the schedule status.');
                }
            });
        });
    </script>
</body>
</html>
