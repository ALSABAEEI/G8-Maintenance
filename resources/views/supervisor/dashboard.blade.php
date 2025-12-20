@extends('layouts.app')

@section('title', 'Supervisor Dashboard')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard</title>
</head>
<body>
    <h1>Welcome, Supervisor!</h1>
    <p>This is the supervisor dashboard.</p>

    <h2>Your Topics</h2>
    <ul class="list-group">
        @forelse($topics as $topic)
            <li class="list-group-item">
                <strong>{{ $topic->Topic_Title }}</strong>
                <p>{{ $topic->Topic_Description }}</p>
                <p>Status: {{ $topic->Status }}</p>
                <p>Assigned Student: {{ $topic->student ? $topic->student->UserName : 'Name' }}</p>
            </li>
        @empty
            <li class="list-group-item">You have no topics.</li>
        @endforelse
    </ul>
</body>
</html>
@endsection
