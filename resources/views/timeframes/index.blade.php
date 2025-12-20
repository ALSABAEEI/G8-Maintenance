@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Manage Timeframes</h2>
        <a href="{{ route('timeframes.create') }}" class="btn btn-primary mb-3">Add Timeframe</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Semester</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timeframes as $timeframe)
                    <tr>
                        <td>{{ $timeframe->id }}</td>
                        <td>{{ $timeframe->Event_Type }}</td> <!-- Display the Event Type -->
                        <td>{{ $timeframe->Start_Date }}</td>
                        <td>{{ $timeframe->End_Date }}</td>
                        <td>{{ $timeframe->Semester }}</td>
                        <td>
                            <a href="{{ route('timeframes.edit', $timeframe->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('timeframes.destroy', $timeframe->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
