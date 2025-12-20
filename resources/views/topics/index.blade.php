@extends('layouts.app')

@section('title', 'Manage Topics')

@section('content')
    <div class="container mt-4">
        <h2>Manage Topics</h2>
        <a href="{{ route('topics.create') }}" class="btn btn-primary mb-3">Post New Topic</a>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topics as $topic)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $topic->Topic_Title }}</td>
                        <td>{{ $topic->Topic_Description }}</td>
                        <td>{{ $topic->Status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
