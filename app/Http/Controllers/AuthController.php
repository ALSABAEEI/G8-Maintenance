<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Redirect based on role
            if ($user->Role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->Role === 'supervisor') {
                return redirect()->route('supervisor.dashboard');
            } elseif ($user->Role === 'student') {
                return redirect()->route('student.dashboard');
            }

            return redirect()->route('login'); // Fallback in case role is not recognized
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
