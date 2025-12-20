@extends('layouts.app')

@section('title', 'Post New Topic')

@section('content')
    <div class="container mt-4">
        <h2>Post a New Topic</h2>
        <form action="{{ route('topics.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="Topic_Title">Topic Title</label>
                <input type="text" name="Topic_Title" id="Topic_Title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="Topic_Description">Description</label>
                <textarea name="Topic_Description" id="Topic_Description" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-success mt-3">Post Topic</button>
        </form>
    </div>
@endsection
