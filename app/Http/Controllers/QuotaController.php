<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quota;

class QuotaController extends Controller
{
    public function index()
    {
        $quotas = Quota::with('supervisor')->get(); // Load all quotas with related supervisor details
        return view('quota.index', compact('quotas'));
    }

    public function create()
    {
        // Assuming 'Role' is the field used to define user roles
        $supervisors = \App\Models\User::where('Role', 'supervisor')->get();
        return view('quota.create', compact('supervisors'));
    }

    public function store(Request $request)
{
    $request->validate([
        'Supervisor_ID' => 'required|exists:users,id',
        'QuotaNumber' => 'required|integer|min:1|max:15',
    ]);

    // Check if the supervisor already has a quota
    $existingQuota = Quota::where('Supervisor_ID', $request->Supervisor_ID)->first();
    if ($existingQuota) {
        return redirect()->back()->with('error', 'The selected supervisor already has a quota.');
    }

    // Create the quota
    Quota::create($request->all());

    return redirect()->route('quota.index')->with('success', 'Quota created successfully.');
}


    public function edit($id)
    {
        $quota = Quota::findOrFail($id);
        return view('quota.edit', compact('quota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'QuotaNumber' => 'required|integer|min:1|max:15',
        ]);

        $quota = Quota::findOrFail($id);

        // Update the quota
        $quota->update($request->only('QuotaNumber'));

        // Create a notification for the supervisor
        \DB::table('notifications')->insert([
            'user_id' => $quota->Supervisor_ID, // Send to the supervisor
            'message' => 'Your quota has been updated to ' . $request->QuotaNumber . '.',
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('quota.index')->with('success', 'Quota updated successfully.');
    }

    public function destroy($id)
    {
        $quota = Quota::findOrFail($id);
        $quota->delete();

        return redirect()->route('quota.index')->with('success', 'Quota deleted successfully.');
    }
}
