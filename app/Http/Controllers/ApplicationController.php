<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectTopic;


class ApplicationController extends Controller
{
    public function index()
{
    $applications = \DB::table('applications')
        ->join('project_topics', 'applications.topic_id', '=', 'project_topics.id')
        ->join('users', 'applications.student_id', '=', 'users.id')
        ->where('project_topics.Supervisor_ID', auth()->user()->id)
        ->where('applications.status', 'Pending') // Only fetch pending applications
        ->select(
            'applications.id as application_id',
            'users.UserName as student_name',
            'project_topics.Topic_Title as topic_title',
            'applications.remarks',
            'applications.status'
        )
        ->get();

    return view('supervisor.applications', compact('applications'));
}



public function review(Request $request, $id)
{
    // Fetch the application and the student
    $application = \DB::table('applications')
        ->join('project_topics', 'applications.topic_id', '=', 'project_topics.id')
        ->where('applications.id', $id)
        ->first(['applications.id as application_id', 'project_topics.Supervisor_ID as supervisor_id', 'applications.topic_id', 'applications.student_id']);

    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    if ($request->action === 'accept') {
        // Check quota logic
        $quota = \DB::table('quotas')->where('Supervisor_ID', $application->supervisor_id)->first();
        if ($quota->current_quota >= $quota->QuotaNumber) {
            return redirect()->back()->with('error', 'Quota limit reached. Cannot accept more applications.');
        }

        // Update the application status
        \DB::table('applications')->where('id', $id)->update(['status' => 'Accepted', 'updated_at' => now()]);

        // Update the topic and quota
        \DB::table('project_topics')->where('id', $application->topic_id)->update([
            'Status' => 'Closed',
            'Student_ID' => $application->student_id,
        ]);
        \DB::table('quotas')->where('Supervisor_ID', $application->supervisor_id)->increment('current_quota');

        // Create a notification for the student
        \DB::table('notifications')->insert([
            'user_id' => $application->student_id,
            'message' => 'Your application for the topic has been accepted!',
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a notification for the supervisor
        \DB::table('notifications')->insert([
            'user_id' => $quota->Supervisor_ID, // Send to the supervisor
            'message' => "Your quota has been updated. Current quota: {$quota->current_quota}, Maximum quota: {$quota->QuotaNumber}.",
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        return redirect()->back()->with('success', 'Application accepted successfully.');
    }

    if ($request->action === 'reject') {
        // Update the application status
        \DB::table('applications')->where('id', $id)->update(['status' => 'Rejected', 'updated_at' => now()]);

        // Create a notification for the student
        \DB::table('notifications')->insert([
            'user_id' => $application->student_id,
            'message' => 'Your application for the topic has been rejected.',
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a notification for the supervisor
        \DB::table('notifications')->insert([
            'user_id' => $application->supervisor_id,
            'message' => 'You have rejected an application for the topic.',
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Application rejected successfully.');
    }

    return redirect()->back()->with('error', 'Invalid action.');
}









}
