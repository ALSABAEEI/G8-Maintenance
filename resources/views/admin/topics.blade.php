@extends('layouts.app')

@section('content')
<div class="container">
<table class="table table-bordered">
<h1>All Topics</h1>
<thead>
                <tr>
                <th>#</th>
                <th>Topic Title</th>
                <th>Topic Description</th>
                <th>Status</th>
                <th>Supervisor ID</th>
                <th>Assigned Student ID</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($topics as $topic)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $topic->Topic_Title }}</td>
                    <td>{{ $topic->Topic_Description }}</td>
                    <td>{{ $topic->Status }}</td>
                    <td>{{ $topic->Supervisor_ID }}</td>
                    <td>{{ $topic->Student_ID }}</td>
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
