@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Manage Quotas</h2>
        <a href="{{ route('quota.create') }}" class="btn btn-primary mb-3">Add Quota</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supervisor</th>
                    <th>Quota</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotas as $quota)
                    <tr>
                        <td>{{ $quota->id }}</td>
                        <td>{{ $quota->supervisor->UserName }}</td>
                        <td>{{ $quota->QuotaNumber }}</td>
                        <td>
                            <a href="{{ route('quota.edit', $quota->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('quota.destroy', $quota->id) }}" method="POST" style="display:inline;">
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
