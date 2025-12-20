@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Available Slots</h1>

    <form action="{{ route('appointments.addSlot') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" name="date" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" class="form-control" name="start_time" required>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" class="form-control" name="end_time" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Slot</button>
    </form>

    <h2>Available Slots</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Availability</th>
            </tr>
        </thead>
        <tbody>
            @foreach($slots as $slot)
            <tr>
                <td>{{ $slot->date }}</td>
                <td>{{ $slot->start_time }} - {{ $slot->end_time }}</td>
                <td>
                    <form action="{{ route('appointments.toggleAvailability', $slot->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $slot->available ? 'danger' : 'success' }}">
                            {{ $slot->available ? 'Mark Unavailable' : 'Mark Available' }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Manage Appointments</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->student->name }}</td>
                <td>{{ $appointment->slot->date }}</td>
                <td>{{ $appointment->slot->start_time }} - {{ $appointment->slot->end_time }}</td>
                <td>{{ $appointment->status }}</td>
                <td>
                    <button type="button" class="btn btn-primary" onclick="openManageModal({{ $appointment->id }})">
                        Manage
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for Accept/Reject Appointment -->
<div class="modal fade" id="manageModal" tabindex="-1" aria-labelledby="manageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageModalLabel">Manage Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="manageForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="Approved">Approve</option>
                            <option value="Rejected">Reject</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openManageModal(appointmentId) {
        var form = document.getElementById('manageForm');
        form.action = '/appointments/' + appointmentId + '/manage'; // Correct route
        $('#manageModal').modal('show'); // Show the modal
    }
</script>
@endsection