<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeFrame;
use App\Models\User;

class TimeFrameController extends Controller
{
    public function index()
    {
        $timeframes = TimeFrame::all();
        return view('timeframes.index', compact('timeframes'));
    }

    public function create()
    {
        return view('timeframes.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'Event_Type' => 'required|string|max:255',
        'Start_Date' => 'required|date',
        'End_Date' => 'required|date|after_or_equal:Start_Date',
        'Semester' => 'required|string|max:255',
    ]);

    // Create the new timeframe
    $timeframe = TimeFrame::create($request->all());

    // Notify all students and supervisors
    $users = User::whereIn('Role', ['student', 'supervisor'])->get();
    foreach ($users as $user) {
        \DB::table('notifications')->insert([
            'user_id' => $user->id,
            'message' => "A new timeframe for '{$timeframe->Event_Type}' has been created. It starts on {$timeframe->Start_Date} and ends on {$timeframe->End_Date}.",
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->route('timeframes.index')->with('success', 'Timeframe created successfully and notifications sent.');
}

public function edit($id)
{
    // Find the specific timeframe by ID
    $timeframe = TimeFrame::findOrFail($id);

    // Return the edit view with the timeframe details
    return view('timeframes.edit', compact('timeframe'));
}



    public function update(Request $request, $id)
    {
        $timeframe = TimeFrame::findOrFail($id);

        $request->validate([
            'Event_Type' => 'required|string|max:255',
            'Start_Date' => 'required|date',
            'End_Date' => 'required|date|after_or_equal:Start_Date',
            'Semester' => 'required|string|max:255',
        ]);

        // Update the time frame
        $timeframe->update([
            'Event_Type' => $request->Event_Type,
            'Start_Date' => $request->Start_Date,
            'End_Date' => $request->End_Date,
            'Semester' => $request->Semester,
        ]);

        // Send notifications to all supervisors and students
        $supervisors = User::where('Role', 'supervisor')->get();
        $students = User::where('Role', 'student')->get();

        $notifications = [];

        foreach ($supervisors as $supervisor) {
            $notifications[] = [
                'user_id' => $supervisor->id,
                'message' => "The time frame for '{$request->Event_Type}' has been updated. Please check the new dates.",
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($students as $student) {
            $notifications[] = [
                'user_id' => $student->id,
                'message' => "The time frame for '{$request->Event_Type}' has been updated. Please check the new dates.",
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert notifications into the database
        \DB::table('notifications')->insert($notifications);

        return redirect()->route('timeframes.index')->with('success', 'Timeframe updated successfully, and notifications sent.');
    }

    public function destroy($id)
    {
        $timeframe = TimeFrame::findOrFail($id);
        $timeframe->delete();

        return redirect()->route('timeframes.index')->with('success', 'Timeframe deleted successfully.');
    }

    public function viewStudentTimeframes()
{
    // Fetch ongoing timeframes and those starting in the next 10 days
    $currentDate = now();
    $futureDate = now()->addDays(10);

    $timeframes = TimeFrame::where(function ($query) use ($currentDate, $futureDate) {
        $query->where('Start_Date', '<=', $currentDate) // Ongoing timeframes
              ->orWhereBetween('Start_Date', [$currentDate, $futureDate]); // Starting in the next 10 days
    })->get();

    return view('timeframes.student', compact('timeframes'));
}


public function viewSupervisorTimeframes()
{
    // Fetch ongoing timeframes and those starting in the next 10 days
    $currentDate = now();
    $futureDate = now()->addDays(10);

    $timeframes = TimeFrame::where(function ($query) use ($currentDate, $futureDate) {
        $query->where('Start_Date', '<=', $currentDate) // Ongoing timeframes
              ->orWhereBetween('Start_Date', [$currentDate, $futureDate]); // Starting in the next 10 days
    })->get();

    return view('timeframes.supervisor', compact('timeframes'));
}


}
