<!DOCTYPE html>
<html>
<head>
    <title>Schedule Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
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
            <h2>Pengajuan Jadwal</h2>
        </div>
        <form id="scheduleForm">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" id="name" class="form-control" required />
            </div>
            <div class="form-group">
                <label>NPM:</label>
                <input type="text" id="npm" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Asal Instansi:</label>
                <input type="text" id="asal_instansi" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Nomor Whatsapp:</label>
                <input type="text" id="nomor_whatsapp" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Purpose:</label>
                <input type="text" id="purpose" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Date:</label>
                <input type="date" id="date" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Time:</label>
                <input type="time" id="time" class="form-control" required />
            </div>
            <div class="form-group">
                <label>End Time:</label>
                <input type="time" id="end_time" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
        <div id="errorMessage" class="alert alert-danger mt-3" style="display: none;"></div>
    </div>
    <script>
        $(document).ready(function() {
            $('#scheduleForm').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: '/api/schedules',
                    method: 'POST',
                    data: {
                        name: $('#name').val(),
                        npm: $('#npm').val(),
                        asal_instansi: $('#asal_instansi').val(),
                        nomor_whatsapp: $('#nomor_whatsapp').val(),
                        purpose: $('#purpose').val(),
                        date: $('#date').val(),
                        time: $('#time').val(),
                        end_time: $('#end_time').val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Schedule submitted successfully');
                        $('#scheduleForm')[0].reset();
                        $('#errorMessage').hide();
                    },
                    error: function(response) {
                        if (response.responseJSON && response.responseJSON.errors) {
                            $('#errorMessage').text(response.responseJSON.errors.time[0]).show();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
