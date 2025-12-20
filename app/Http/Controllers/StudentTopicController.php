<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectTopic;
use App\Models\User;


class StudentTopicController extends Controller
{
    public function index()
    {
        $supervisors = User::where('Role', 'supervisor')->get();
        return view('students.choose-supervisor', compact('supervisors'));
    }

    public function apply(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:project_topics,id',
        ]);

        $topic = ProjectTopic::find($request->topic_id);

        if ($topic->Status !== 'Open') {
            return redirect()->back()->with('error', 'This topic is no longer available.');
        }

        $topic->update([
            'Student_ID' => auth()->user()->id,
            'Status' => 'Pending',
        ]);

        return redirect()->route('students.choose-supervisor')->with('success', 'Application submitted successfully.');
    }
}
