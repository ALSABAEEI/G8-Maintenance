@extends('layouts.app')

@section('title', 'User Report by Program')

@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">User Report by Program</h1>

        <!-- Filter Form with Better Design -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('reports.users') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label for="program" class="form-label fw-semibold">
                                <i class="bi bi-funnel"></i> Filter by Program
                            </label>
                            <select name="program" id="program" class="form-select">
                                <option value="">All Programs</option>
                                @foreach ($allPrograms as $prog)
                                    <option value="{{ $prog }}" {{ request('program') == $prog ? 'selected' : '' }}>
                                        {{ $prog }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Apply Filter
                            </button>
                        </div>
                        @if (request('program'))
                            <div class="col-md-2">
                                <a href="{{ route('reports.users') }}" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-x-circle"></i> Clear
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Detailed Users Table (User Name + Program) -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">User Details</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>User Name</th>
                                <th>Program</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->UserName }}</td>
                                    <td>{{ $user->Program }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-4">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Button to export the report (Summary by Program) -->
        <div class="mt-4">
            <a href="{{ route('reports.users.export.pdf') }}" class="btn btn-secondary">
                <i class="bi bi-file-earmark-pdf"></i> Export as PDF
            </a>
        </div>
    </div>

@endsection
