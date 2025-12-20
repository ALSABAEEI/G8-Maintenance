<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TimeFrame;
use App\Models\ProjectTopic;


class ChooseSupervisorController extends Controller
{
    public function index()
    {
        $currentDate = now();

        // Check if the "Student Application" event is within the active timeframe
        $timeframe = TimeFrame::where('Event_Type', 'Student Application')
            ->where('Start_Date', '<=', $currentDate)
            ->where('End_Date', '>=', $currentDate)
            ->first();

        if (!$timeframe) {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'The application period for choosing a supervisor is not available at this time.');
        }

        // Get supervisors from the users table
        $supervisors = User::where('Role', 'supervisor')->get();

        return view('supervisor.choose-supervisor', compact('supervisors'));
    }

    public function getTopicsBySupervisor($supervisorId)
    {
        // Fetch topics posted by the selected supervisor
        $topics = ProjectTopic::where('Supervisor_ID', $supervisorId)->get();

        return response()->json($topics);
    }

    public function apply(Request $request)
    {
        $request->validate([
            'supervisor_id' => 'required|exists:users,id',
            'topic_id' => 'required|exists:project_topics,id',
        ]);

        // Check if the "Student Application" event is active
        $currentDate = now();
        $timeframe = TimeFrame::where('Event_Type', 'Student Application')
            ->where('Start_Date', '<=', $currentDate)
            ->where('End_Date', '>=', $currentDate)
            ->first();

        if (!$timeframe) {
            return redirect()->back()->with('error', 'The application period for choosing a supervisor is not available at this time.');
        }

        // Logic to save the student's application
        $projectTopic = ProjectTopic::findOrFail($request->input('topic_id'));

        if ($projectTopic->Status === 'Assigned') {
            return redirect()->back()->with('error', 'This topic has already been assigned.');
        }

        $projectTopic->update([
            'Student_ID' => auth()->id(), // Set the current logged-in student
            'Status' => 'Pending',
        ]);

        return redirect()->route('choose-supervisor.index')->with('success', 'Your application has been submitted successfully.');
    }
}
