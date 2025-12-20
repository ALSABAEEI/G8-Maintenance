<form method="POST" action="{{ route('appointments.create') }}">
    @csrf
    <select name="supervisor_id" required>
        @foreach ($supervisors as $supervisor)
        <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
        @endforeach
    </select>
    <input type="date" name="appointment_date" required>
    <input type="time" name="appointment_time" required>
    <button type="submit">Request Appointment</button>
</form>
@endsection
