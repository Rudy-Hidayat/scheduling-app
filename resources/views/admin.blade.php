<!DOCTYPE html>
<html>
<head>
    <title>Admin - Schedule Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }
        .table th {
            background-color: #f8f9fa;
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
</head>
<body>
    <div class="container mt-5">
        <div class="title-container">
            <h2>Admin - Schedule Management</h2>
        </div>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>NPM</th>
                    <th>Asal Instansi</th>
                    <th>Whatsapp</th>
                    <th>Purpose</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Place</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="scheduleTableBody">
                <!-- Data will be populated here by JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Modal for accepting/rejecting schedule -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Update Schedule Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="scheduleForm">
                        <div class="form-group">
                            <label for="place">Place</label>
                            <input type="text" class="form-control" id="place" name="place" required>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes"></textarea>
                        </div>
                        <input type="hidden" id="scheduleId" name="scheduleId">
                        <input type="hidden" id="actionType" name="actionType">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fetch and display schedules
            fetchSchedules();

            // Handle submit button click
            $('#submitBtn').on('click', function() {
                const scheduleId = $('#scheduleId').val();
                const actionType = $('#actionType').val();
                const place = $('#place').val();
                const notes = $('#notes').val();
                const url = actionType === 'accept' ? `/api/admin/schedules/${scheduleId}/accept` : `/api/admin/schedules/${scheduleId}/reject`;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        place: place,
                        notes: notes,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#scheduleModal').modal('hide');
                        fetchSchedules();
                    },
                    error: function(error) {
                        console.log(error);
                        alert('There was an error updating the schedule.');
                    }
                });
            });
        });

        function fetchSchedules() {
            $.ajax({
                url: '/api/admin/schedules',
                type: 'GET',
                success: function(response) {
                    const scheduleTableBody = $('#scheduleTableBody');
                    scheduleTableBody.empty();
                    response.forEach(schedule => {
                        scheduleTableBody.append(`
                            <tr>
                                <td>${schedule.name}</td>
                                <td>${schedule.npm}</td>
                                <td>${schedule.asal_instansi}</td>
                                <td>${schedule.nomor_whatsapp}</td>
                                <td>${schedule.purpose}</td>
                                <td>${schedule.date}</td>
                                <td>${schedule.time}</td>
                                <td>${schedule.end_time}</td>
                                <td>${schedule.status}</td>
                                <td>${schedule.place}</td>
                                <td>${schedule.notes}</td>
                                <td>
                                    <button class="btn btn-success" onclick="openModal('${schedule.id}', 'accept')">Accept</button>
                                    <button class="btn btn-danger" onclick="openModal('${schedule.id}', 'reject')">Reject</button>
                                </td>
                            </tr>
                        `);
                    });
                },
                error: function(error) {
                    console.log(error);
                    alert('There was an error fetching the schedules.');
                }
            });
        }

        function openModal(scheduleId, actionType) {
            $('#scheduleId').val(scheduleId);
            $('#actionType').val(actionType);
            $('#place').val('');
            $('#notes').val('');
            $('#scheduleModal').modal('show');
        }
    </script>
</body>
</html>
