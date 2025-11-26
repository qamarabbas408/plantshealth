<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    // 
public function show($username,$slug): View
{
    // Find post by slug, or show 404 if missing
    // We also load the 'author' and 'tags' to display them
    $post = Post::with(['author', 'tags'])
                ->where('slug', $slug)
                ->where('is_published', true)
                ->firstOrFail();

    return view('posts.show', compact('post'));
}

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {
         // Validation
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required', // This is the HTML from Quill
            'featured_image' => 'nullable|image|max:5120', // Max 5MB
        ]);

        // 1. Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts', 'public');
        }

         // 2. Create Post
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            // Create a slug (e.g., "My Title" -> "my-title-xl3s")
            'slug' => Str::slug($request->title) . '-' . Str::random(5), 
            'body' => $request->body,
            // Create excerpt from HTML body (first 150 chars)
            'excerpt' => Str::limit(strip_tags($request->body), 150),
            'image_path' => $imagePath,
            'is_published' => true,
        ]);

          // 3. Handle Tags (Input: "Tech, Science")
        if ($request->tags) {
            $tagNames = explode(',', $request->tags);
            foreach ($tagNames as $name) {
                $cleanName = trim($name);
                if (!empty($cleanName)) {
                    // Find tag or create it if it doesn't exist
                    $tag = Tag::firstOrCreate(['name' => $cleanName]);
                    // Link to post
                    $post->tags()->attach($tag->id);
                }
            }
        }

        return redirect()->route('home');

    }
}


