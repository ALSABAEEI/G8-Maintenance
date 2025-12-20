<?php

namespace App\Http\Controllers;

use App\Models\ProjectTopic;

class AdminController extends Controller
{
    public function viewAllTopics()
    {
        // Ensure only admin can access this page
        // Get all topics
        $topics = ProjectTopic::all();

        return view('admin.topics', compact('topics'));
    }
}
