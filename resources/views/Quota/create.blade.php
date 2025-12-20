@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Create New Quota</h2>

        <form action="{{ route('quota.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="Supervisor_ID">Supervisor</label>
                <select name="Supervisor_ID" id="Supervisor_ID" class="form-control">
                    @foreach($supervisors as $supervisor)
                        <option value="{{ $supervisor->id }}">{{ $supervisor->UserName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="QuotaNumber">Quota</label>
                <input type="number" name="QuotaNumber" id="QuotaNumber" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Save</button>
        </form>
    </div>

    

@endsection
