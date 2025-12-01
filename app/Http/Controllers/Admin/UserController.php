<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 1. List all users
    public function index()
    {
        $users = User::where('role', '!=', 'admin') // Don't list admins
                    ->latest()
                    ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    // 2. Toggle Block/Unblock
    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);
        
        // Toggle the boolean value
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        $status = $user->is_blocked ? 'blocked' : 'unblocked';
        return back()->with('success', "User has been {$status}.");
    }

    // 3. Delete User
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Optional: Delete their avatar from storage if exists
        // Storage::disk('public')->delete($user->avatar);
        
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}