<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validation
        $request->validate([
            'name'  => 'required|string|max:255',
            // 'email' => 'required|email|max:255|unique:users,email,'.$user->id, // Unique but ignore current user
            'bio'   => 'nullable|string|max:500',
            'avatar'=> 'nullable|image|max:2048', // Max 2MB
        ]);

        // 2. Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 3. Update Text Fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        
        // 4. Save
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
    }
}