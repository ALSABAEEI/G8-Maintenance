<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class PasswordChangeController extends Controller
{
    /**
     * Show the form for the user to change their password.
     */
    public function edit()
    {
        // Return the password change view (create this view as 'auth.change_password')
        return view('auth.change_password');
    }

    /**
     * Handle the password update request.
     */
    public function update(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Update the password and password_changed directly using the database
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($request->new_password),
                'password_changed' => true,
                'updated_at' => now(), // Ensure `updated_at` is updated
            ]);

        // Redirect based on user role
        if ($user->Role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Your password has been updated successfully.');
        } elseif ($user->Role === 'supervisor') {
            return redirect()->route('supervisor.dashboard')->with('success', 'Your password has been updated successfully.');
        } elseif ($user->Role === 'student') {
            return redirect()->route('student.dashboard')->with('success', 'Your password has been updated successfully.');
        }

        // Default redirect if no role matches
        return redirect()->route('login')->with('error', 'No valid dashboard found for your role.');
    }
}
