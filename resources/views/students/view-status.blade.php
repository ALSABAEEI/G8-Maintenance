@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Review Topics</h2>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Topic Title</th>
                <th>Topic Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($topics as $topic)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $topic->Topic_Title }}</td>
                    <td>{{ $topic->Topic_Description }}</td>
                    <td>{{ $topic->Status }}</td>
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
