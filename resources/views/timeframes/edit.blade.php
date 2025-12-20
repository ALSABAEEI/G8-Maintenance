@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Edit Timeframe</h2>

        <form action="{{ route('timeframes.update', $timeframe->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
    <label for="Event_Type">Event Type</label>
    <select name="Event_Type" id="Event_Type" class="form-control" required>
        <option value="Choose Supervisor" {{ $timeframe->Event_Type === 'Choose Supervisor' ? 'selected' : '' }}>Choose Supervisor</option>
        <option value="Upload Documents" {{ $timeframe->Event_Type === 'Upload Documents' ? 'selected' : '' }}>Upload Documents</option>
        <option value="Supervisor Post Topics" {{ $timeframe->Event_Type === 'Supervisor Post Topics' ? 'selected' : '' }}>Supervisor Post Topics</option>
        <option value="Student Application" {{ $timeframe->Event_Type === 'Student Application' ? 'selected' : '' }}>Student Application</option>
        <option value="Supervisor Accept Applications" {{ $timeframe->Event_Type === 'Supervisor Accept Applications' ? 'selected' : '' }}>Supervisor Accept Applications</option>
    </select>
</div>


            <div class="form-group">
                <label for="Start_Date">Start Date</label>
                <input type="date" name="Start_Date" id="Start_Date" class="form-control" value="{{ $timeframe->Start_Date }}" required>
            </div>
            <div class="form-group">
                <label for="End_Date">End Date</label>
                <input type="date" name="End_Date" id="End_Date" class="form-control" value="{{ $timeframe->End_Date }}" required>
            </div>
            <div class="form-group">
                <label for="Semester">Semester</label>
                <input type="text" name="Semester" id="Semester" class="form-control" value="{{ $timeframe->Semester }}" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Update</button>
        </form>
    </div>
@endsection
