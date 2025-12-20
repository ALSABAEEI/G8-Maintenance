<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectTopic;
use App\Models\User; // Import the User model


class TopicController extends Controller
{
    public function index()
    {
        // Fetch topics for the logged-in supervisor
        $topics = ProjectTopic::where('Supervisor_ID', auth()->user()->id)->get();
        return view('topics.index', compact('topics'));
    }

    public function create()
    {
        return view('topics.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Topic_Title' => 'required|string|max:255',
            'Topic_Description' => 'required|string',
        ]);

        ProjectTopic::create([
            'Supervisor_ID' => auth()->user()->id,
            'Topic_Title' => $request->Topic_Title,
            'Topic_Description' => $request->Topic_Description,
            'Status' => 'Open',
        ]);

        return redirect()->route('topics.index')->with('success', 'Topic created successfully.');
    }

    public function viewTopics()
{
    // Get supervisors for the dropdown
    $supervisors = User::where('Role', 'supervisor')->get();
    return view('students.view-topics', compact('supervisors'));
}


public function viewTopicStatus()
{
    // Get the currently logged-in user
    $studentId = auth()->user()->id;

    // Get topics for the logged-in student
    $topics = ProjectTopic::where('Student_ID', $studentId)->get();

    return view('students.view-status', compact('topics'));
}

public function searchTopics(Request $request)
{
    $request->validate([
        'supervisor_id' => 'required|exists:users,id',
    ]);

    $supervisor = User::find($request->supervisor_id);
    $topics = ProjectTopic::where('Supervisor_ID', $supervisor->id)
        ->where('Status', 'Open') // Only show open topics
        ->get();

    $supervisors = User::where('Role', 'supervisor')->get();

    return view('students.view-topics', compact('topics', 'supervisor', 'supervisors'));

}

public function applyTopic($id)
{
    $studentId = auth()->user()->id;

    // Update the topic with the student ID
    $topic = ProjectTopic::find($id);
    $topic->Student_ID = $studentId;
    $topic->Status = 'Closed'; // Optionally, mark the topic as closed
    $topic->save();

    return redirect()->back()->with('success', 'You have successfully applied for the topic.');
}



public function apply($id)
{
    $topic = ProjectTopic::findOrFail($id);

    // Check if the topic is still open
    if ($topic->Status !== 'Open') {
        return redirect()->route('students.view-topics')->with('error', 'This topic is no longer available.');
    }

    // Check if the student has already applied for this topic
    $existingApplication = \DB::table('applications')
        ->where('student_id', auth()->user()->id)
        ->where('topic_id', $id)
        ->first();

    if ($existingApplication) {
        return redirect()->route('students.view-topics')->with('error', 'You have already applied for this topic.');
    }

    // Create a new application
    \DB::table('applications')->insert([
        'student_id' => auth()->user()->id,
        'topic_id' => $id,
        'status' => 'Pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('students.view-topics')->with('success', 'Application submitted successfully.');
}




}
