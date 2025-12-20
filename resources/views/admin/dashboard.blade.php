@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="h3">Admin Dashboard</h1>
    </div>

    <!-- Quick Stats Section -->
    <div class="row">
        <!-- Total Users Card -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-4">{{ $totalUsers ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Applications Card -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pending Applications</h5>
                    <p class="card-text display-4">{{ $pendingApplications ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Supervisors Card -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Supervisors</h5>
                    <p class="card-text display-4">{{ $supervisors ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Reports Generated -->
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Reports Generated</h5>
                    <p class="card-text display-4">{{ $reportsGenerated ?? 0 }}</p>
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
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">View and manage all users in the system.</p>
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>

        <!-- Manage Quotas -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Manage Quotas</h5>
                    <p class="card-text">Set and manage supervisor quotas.</p>
                    <a href="{{ route('quota.index') }}" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>

        <!-- Generate Reports -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Generate Reports</h5>
                    <p class="card-text">Export system reports for review.</p>
                    <a href="{{ route('reports.users') }}" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
