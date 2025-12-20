@extends('layouts.app')

@section('title', 'User Report by Program')

@section('content')

<div class="container mt-4">
    <h1>User Report by Program</h1>

    <!-- Display the user report in a table -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Program</th>
                <th>Total Users</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usersByProgram as $program)
                <tr>
                    <td>{{ $program->Program ?? 'Not Assigned' }}</td>
                    <td>{{ $program->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Button to export the report -->
    <a href="{{ route('reports.users.export.pdf') }}" class="btn btn-secondary mt-3">Export as PDF</a>
</div>

@endsection
