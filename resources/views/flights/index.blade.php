<!-- resources/views/flights/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Available Flights</title>
</head>
<body>
    <h1>Available Flights</h1>
    <ul>
        @foreach ($flights as $flight)
            <li>{{ $flight->getDetails()['flight_number'] }} - {{ $flight->getDetails()['destination'] }}</li>
        @endforeach
    </ul>
</body>
</html>
