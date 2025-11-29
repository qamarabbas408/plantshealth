<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Stats
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $publishedPosts = Post::where('status', 'published')->count(); // Updated
        $draftPosts = Post::where('status', 'pending')->count();       // Updated

        // 2. Pending Queue
        $pendingReviews = Post::with('author')
            ->where('status', 'pending') // Updated
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalPosts', 'publishedPosts', 'draftPosts', 'pendingReviews', 'recentUsers'));
    }

    public function review($id)
    {
        // Admin can view the post even if it's pending/draft
        $post = Post::with(['author', 'tags'])->findOrFail($id);

        return view('admin.posts.review', compact('post'));
    }

    public function approve($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 'published'; // <--- Update Status
        $post->save();

        return redirect()->route('admin.dashboard')->with('success', 'Article approved and published!');
    }

    public function reject($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 'rejected'; // <--- Update Status
        $post->save();

        return redirect()->route('admin.dashboard')->with('success', 'Article rejected.');
    }
}
    