<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmed</title>
</head>
<body>
    <h2>Hi {{ $appointment->patient->name }},</h2>
    <p>Your appointment with Dr. {{ $appointment->doctor->name }} has been confirmed.</p>
    <p><strong>Date:</strong> {{ $appointment->date }}</p>
    <p><strong>Time:</strong> {{ $appointment->time }}</p>
    <p><strong>Note:</strong>{{ $appointment->notes }}</p>
    <p>Thank you for choosing our hospital.</p>
</body>
</html>
