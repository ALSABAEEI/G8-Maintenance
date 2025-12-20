@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="h3">Student Dashboard</h1>
    </div>
    <!-- Quick Stats Section -->
    <div class="row">

        <!-- Reports Generated -->
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Topics</h5>
                    <p class="card-text display-4">{{ $topics ?? 0 }}</p>
                </div>
            </div>
        </div>
</div>

    <!-- Actions Section -->
    <div class="row mt-4">
        <!-- Manage Users -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">View Topics</h5>
                    <p class="card-text">View and manage your topics in the system.</p>
                    <a href="{{ route('students.view-topics') }}" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">View Topics Status</h5>
                    <p class="card-text">View and your topics status in the system.</p>
                    <a href="{{ route('students.view-status') }}" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
