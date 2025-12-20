<h1>Your Appointments</h1>
<table>
    <thead>
        <tr>
            <th>Supervisor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($appointments as $appointment)
        <tr>
            <td>{{ $appointment->supervisor->name }}</td>
            <td>{{ $appointment->appointment_date }}</td>
            <td>{{ $appointment->appointment_time }}</td>
            <td>{{ $appointment->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>