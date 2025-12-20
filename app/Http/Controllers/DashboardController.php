<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Application;
use App\Models\Quota;


class DashboardController extends Controller
{
    public function adminDashboard()
    {
        // Fetch stats for the admin dashboard
        $totalUsers = User::count();
        $pendingApplications = Application::where('status', 'Pending')->count();
        $supervisors = User::where('Role', 'supervisor')->count();
        $reportsGenerated = 0; // Replace this with logic for counting reports if applicable

        return view('admin.dashboard', compact('totalUsers', 'pendingApplications', 'supervisors', 'reportsGenerated'));
    }

    public function supervisorDashboard()
    {
        // Logic for supervisor-specific data if needed
        return view('supervisor.dashboard');
    }

    public function studentDashboard()
    {
        return view('students.dashboard');
    }
}
