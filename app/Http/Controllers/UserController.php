<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $users = User::paginate($request->get('per_page', 10)); // Fetch users with pagination
        return view('admin.upload_users', compact('users'));
    }

    /**
     * Store newly uploaded users in bulk.
     */
    public function store(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $fileData = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($fileData); // Read the header row

        while ($row = fgetcsv($fileData)) {
            $data = array_combine($header, $row);

            // Validate required fields
            if (empty($data['UserName']) || empty($data['password']) || empty($data['Role'])) {
                continue; // Skip this row if required fields are missing
            }

            // Create user in the database
            $user = User::create([
                'UserName' => $data['UserName'],
                'password' => Hash::make($data['password']),
                'Email' => !empty($data['Email']) ? $data['Email'] : $data['UserName'] . '@example.com', // Default email if missing
                'Role' => $data['Role'],
                'Program' => $data['Program'] ?? null,
                'password_changed' => false, // New users must change their password
            ]);

            // Sending email notification

            try {
                Mail::to($user->Email)->send(new \App\Mail\UserCredentialsMail($user, $data['password']));
            } catch (\Exception $e) {
                try {
                    Mail::to($user->Email)->send(new \App\Mail\UserCredentialsMail($user, $data['password']));
                } catch (\Exception $e) {
                    Log::error('Failed to send email to: ' . $user->Email . ' Error: ' . $e->getMessage());
                }
            }
        }

        return redirect()->back()->with('success', 'Users uploaded successfully.');
    }

    /**
     * Show the form for editing a user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); // Find the user by ID or throw a 404
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in the database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'UserName' => 'required|string|max:255',
            'Email' => 'required|email|max:255',
            'Role' => 'required|string',
            'Program' => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $data = $request->only(['UserName', 'Email', 'Role', 'Program']);

        // Avoid overwriting sensitive fields unless provided
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from the database.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Find the user by ID
        $user->delete(); // Delete the user

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
