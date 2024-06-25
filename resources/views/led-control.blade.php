<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LED Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">ESP32 LED Control</h1>
        <div id="status" class="text-center mt-3"></div>
        <div id="led-status" class="text-center mt-3"></div>
        <div class="d-flex justify-content-center mt-4">
            <button id="led-on" class="btn btn-success btn-lg mx-2" disabled>Turn ON</button>
            <button id="led-off" class="btn btn-danger btn-lg mx-2" disabled>Turn OFF</button>
        </div>
        <div id="message" class="text-center mt-3"></div>
    </div>

    <script>
        $(document).ready(function() {
            function checkStatus() {
                $.ajax({
                    url: '/led-status',
                    type: 'GET',
                    success: function(response) {
                        $('#led-status').text('LED Status: ' + (response.led_status == "1" ? "ON" :
                            "OFF")).removeClass().addClass('alert alert-success');
                        $('#led-on').prop('disabled', false);
                        $('#led-off').prop('disabled', false);
                    },
                    error: function(xhr) {
                        $('#led-status').text('LED Status: Unknown').removeClass().addClass(
                            'alert alert-danger');
                    }
                });

                $.ajax({
                    url: '/led-status',
                    type: 'GET',
                    success: function(response) {
                        $('#status').text('Status: ' + response.status).removeClass().addClass(
                            'alert alert-success');
                    },
                    error: function(xhr) {
                        $('#status').text('Status: Disconnected').removeClass().addClass(
                            'alert alert-danger');
                    }
                });
            }

            $('#led-on').click(function() {
                $.ajax({
                    url: '/led-control',
                    type: 'POST',
                    data: {
                        state: 1,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#message').text(response.message).removeClass().addClass(
                            'alert alert-success');
                        checkStatus(); // Update LED status after action
                    },
                    error: function(xhr) {
                        $('#message').text(xhr.responseJSON.message).removeClass().addClass(
                            'alert alert-danger');
                    }
                });
            });

            $('#led-off').click(function() {
                $.ajax({
                    url: '/led-control',
                    type: 'POST',
                    data: {
                        state: 0,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#message').text(response.message).removeClass().addClass(
                            'alert alert-success');
                        checkStatus(); // Update LED status after action
                    },
                    error: function(xhr) {
                        $('#message').text(xhr.responseJSON.message).removeClass().addClass(
                            'alert alert-danger');
                    }
                });
            });

            // Check the status on page load
            checkStatus();

            // Check the status every 5 seconds
            setInterval(checkStatus, 5000);
        });
    </script>
</body>

</html>
