<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    // 1. Show the Login Form
    public function showLogin()
    {
        return view('auth.login');
    }

    // 2. Handle the Form Submission
    public function login(Request $request)
    {
        // A. Validate the inputs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // B. Attempt to log in (Checks DB hash automatically)
        if (Auth::attempt($credentials)) {
            
            // Security: Regenerate session ID to prevent fixation attacks
            $request->session()->regenerate();

            // C. THE REDIRECT LOGIC (Your requirement)
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // Default for authors/users
            return redirect()->route('dashboard');
        }

        // D. If login fails, go back with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // 3. Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}