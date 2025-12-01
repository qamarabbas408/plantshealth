<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // 1. Show All Notifications with Pagination
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    // 2. Mark a Single Notification as Read
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        // FIX: If the request comes from JavaScript, return JSON instead of redirecting
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    // 3. Mark ALL as Read
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    // Return JSON count of unread notifications
    public function count()
    {
        return response()->json([
            'count' => Auth::user()->unreadNotifications()->count(),
        ]);
    }
}
