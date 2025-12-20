@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Review Applications</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Student</th>
                <th>Topic Title</th>
                <th>Remarks</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applications as $application)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $application->student_name }}</td>
                    <td>{{ $application->topic_title }}</td>
                    <td>{{ $application->remarks ?? 'None' }}</td>
                    <td>{{ $application->status }}</td>
                    <td>
                        <form method="POST" action="{{ route('applications.review', $application->application_id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="decision_{{ $application->application_id }}">Decision</label>
                                <select name="action" id="decision_{{ $application->application_id }}" class="form-control" required>
                                    <option value="accept">Accept</option>
                                    <option value="reject">Reject</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="remarks_{{ $application->application_id }}">Remarks</label>
                                <textarea name="remarks" id="remarks_{{ $application->application_id }}" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mt-2">Submit</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No applications found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
