<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password; 
class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'academic_title' => 'nullable|string|max:20',
            'affiliation' => 'nullable|string|max:255',
            'orcid_id' => 'nullable|string|max:50',
            'url_google_scholar' => 'nullable|url',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Handle Avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // Update Fields
        $user->name = $request->name;
        $user->academic_title = $request->academic_title;
        $user->affiliation = $request->affiliation;
        $user->orcid_id = $request->orcid_id;
        $user->url_google_scholar = $request->url_google_scholar;
        $user->bio = $request->bio;

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // 1. Show the Password View
    public function editPassword()
    {
        return view('profile.password');
    }

    // 2. Handle the Update
    public function updatePassword(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()], // defaults = min 8 chars
        ]);

        // Update Password
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
}
