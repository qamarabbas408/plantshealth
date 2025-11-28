<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    public function toggleLike($id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        // Toggle logic: If attached, detach. If not, attach.
        $post->likes()->toggle($user->id);

        return response()->json([
            'status' => 'success',
            'liked' => $post->isLikedBy($user),
            'count' => $post->likes()->count()
        ]);
    }

    public function toggleBookmark($id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        $post->bookmarks()->toggle($user->id);

        return response()->json([
            'status' => 'success',
            'bookmarked' => $post->isBookmarkedBy($user)
        ]);
    }
}