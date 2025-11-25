<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // 1. Show the Form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // 2. Handle the Submission
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' checks password_confirmation field
        ]);

        // Create User (Default role is 'author' from migration)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'author', 
        ]);

        // Auto Login after registration
        Auth::login($user);

        // Redirect to Dashboard
        return redirect()->route('dashboard');
    }
}