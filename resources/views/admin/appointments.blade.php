@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Appointments</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Supervisor Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->student->name }}</td>
                <td>{{ $appointment->slot->supervisor->name }}</td>
                <td>{{ $appointment->slot->date }}</td>
                <td>{{ $appointment->slot->time }}</td>
                <td>{{ $appointment->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection