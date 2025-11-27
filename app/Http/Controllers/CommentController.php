<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate(['body' => 'required|max:1000']);

        $post = Post::findOrFail($postId);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body
        ]);

        return back()->with('success', 'Response published.');
    }
}