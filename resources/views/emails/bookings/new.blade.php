<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Booking Request</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.5;">
    <h2 style="margin-bottom: 12px;">New Booking Request</h2>

    <p style="margin: 0 0 16px 0;">A new booking was submitted on the website.</p>

    <table cellpadding="6" cellspacing="0" border="0" style="border-collapse: collapse; width: 100%; max-width: 720px;">
        <tr><td style="font-weight: 700; width: 220px;">Booking ID</td><td>{{ $booking->id }}</td></tr>
        <tr><td style="font-weight: 700;">Service Type</td><td>{{ $booking->service_type ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Vehicle Type</td><td>{{ $booking->vehicle_type ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Full Name</td><td>{{ $booking->name ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Email</td><td>{{ $booking->email ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Phone</td><td>{{ $booking->phone ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Pickup Address</td><td>{{ $booking->pickup_address ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Pickup Time</td><td>{{ $booking->pickup_time ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Dropoff Address</td><td>{{ $booking->dropoff_address ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Dropoff Time</td><td>{{ $booking->dropoff_time ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Passengers</td><td>{{ $booking->passengers ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Transmission</td><td>{{ $booking->transmission ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Flight Number</td><td>{{ $booking->flight_number ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Reservation Number</td><td>{{ $booking->reservation_number ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">ID Number</td><td>{{ $booking->id_number ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Notes</td><td>{{ $booking->notes ?? '-' }}</td></tr>
        <tr><td style="font-weight: 700;">Submitted At</td><td>{{ optional($booking->created_at)->format('Y-m-d H:i:s') }}</td></tr>
    </table>
</body>
</html>
