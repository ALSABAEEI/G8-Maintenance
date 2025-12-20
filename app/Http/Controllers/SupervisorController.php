<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectTopic;
use App\Models\User; // Import the User model
use App\Models\Application;


class SupervisorController extends Controller {
    public function dashboard()
    {
        $supervisorId = auth()->user()->id;

        // Get topics supervised by the logged-in supervisor
        $topics = ProjectTopic::where('Supervisor_ID', $supervisorId)->get();

        // Get pending applications for the supervisor's topics
        $pendingApplications = Application::whereHas('topic', function ($query) use ($supervisorId) {
            $query->where('Supervisor_ID', $supervisorId);
        })->where('Status', 'Pending')->get();

        return view('supervisor.dashboard', compact('topics', 'pendingApplications'));
    }

}
