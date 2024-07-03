<!DOCTYPE html>
<html>
<head>
    <title>Schedule App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
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
            <h1>Welcome to Sistem Jadwal Dekan</h1>
        </div>
        <div class="list-group">
            <a href="{{ route('schedule-form') }}" class="list-group-item list-group-item-action">Schedule Form</a>
            <a href="{{ route('status') }}" class="list-group-item list-group-item-action">Status</a>
            <a href="{{ route('schedule-calendar') }}" class="list-group-item list-group-item-action">Schedule Calendar</a>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
