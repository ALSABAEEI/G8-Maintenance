@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Appointments</h1>

    <!-- Display the appointments table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->slot->date }}</td>
                <td>{{ $appointment->slot->start_time }} - {{ $appointment->slot->end_time }}</td>
                <td>{{ $appointment->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Display Request Appointment Button if no appointments are pending -->
    @if ($appointments->isEmpty() || $appointments->pluck('status')->contains('Pending'))
    <h2>Request Appointment</h2>
    <form action="{{ route('appointments.request') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="slot_id">Select Available Slot</label>
            <select name="slot_id" id="slot_id" class="form-control" required>
                @foreach ($availableSlots as $slot)
                <option value="{{ $slot->id }}">{{ $slot->date }} - {{ $slot->start_time }} to {{ $slot->end_time }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Request Appointment</button>
    </form>
    @else
    <p>You have already requested an appointment. Please wait for approval.</p>
    @endif
</div>
@endsection