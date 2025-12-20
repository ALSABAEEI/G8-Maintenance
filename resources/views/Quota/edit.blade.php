@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Edit Quota</h2>

        <form action="{{ route('quota.update', $quota->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="QuotaNumber">Quota</label>
                <input type="number" name="QuotaNumber" id="QuotaNumber" value="{{ $quota->QuotaNumber }}" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Update</button>
        </form>
    </div>
@endsection
