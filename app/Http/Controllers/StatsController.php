<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch posts with all counters
        $posts = $user->posts()
            ->withCount(['likes', 'comments', 'bookmarks'])
            ->latest()
            ->get();

        // Calculate Totals for the "Summary Cards"
        $totalLikes = $posts->sum('likes_count');
        $totalComments = $posts->sum('comments_count');
        $totalBookmarks = $posts->sum('bookmarks_count');
        $totalStories = $posts->count();

        return view('stats.index', compact('posts', 'totalLikes', 'totalComments', 'totalBookmarks', 'totalStories'));
    }
}