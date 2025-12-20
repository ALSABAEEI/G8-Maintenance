@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="UserName">User Name:</label>
            <input type="text" name="UserName" class="form-control" value="{{ $user->UserName }}" required>
        </div>

        <div class="form-group">
            <label for="Email">Email:</label>
            <input type="email" name="Email" class="form-control" value="{{ $user->Email }}" required>
        </div>

        <div class="form-group">
            <label for="Role">Role:</label>
            <select name="Role" class="form-control" required>
                <option value="admin" {{ $user->Role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="supervisor" {{ $user->Role === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                <option value="student" {{ $user->Role === 'student' ? 'selected' : '' }}>Student</option>
            </select>
        </div>

        <div class="form-group">
            <label for="Program">Program:</label>
            <input type="text" name="Program" class="form-control" value="{{ $user->Program }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
