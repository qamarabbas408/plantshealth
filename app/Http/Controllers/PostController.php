<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    //

    // public function index()
    // {
    //     // 1. Fetch posts with relationships (Author, Tags)
    //     // 2. Filter only published
    //     // 3. Order by Newest
    //     // 4. Paginate (9 posts per page)
    //     $posts = Post::with(['author', 'tags'])
    //                 ->where('is_published', true)
    //                 ->latest()
    //                 ->paginate(3);

    //     return view('posts.index', compact('posts'));
    // }

    public function index(Request $request)
    {
        // 1. Start the query
        $query = Post::with(['author', 'tags'])
            ->where('is_published', true);

        // 2. Filter by Tag (if selected)
        if ($request->has('tag')) {
            $tagName = $request->tag;
            $query->whereHas('tags', function ($q) use ($tagName) {
                $q->where('name', $tagName);
            });
        }

        // 3. Get Results
        $posts = $query->latest()->paginate(9);

        // 4. Get all Tags that actually have posts (Empty tags shouldn't show)
        // $tags = Tag::has('posts')->get();

        // 4. NEW LOGIC: Get tags sorted by how many posts they have
        $tags = Tag::withCount('posts')
            ->having('posts_count', '>', 0)
            ->orderBy('posts_count', 'desc') // Most popular first
            ->get();

        // 5. Pass everything to view
        return view('posts.index', compact('posts', 'tags'));
    }

    public function show($username, $slug): View
    {
        // Find post by slug, or show 404 if missing
        // We also load the 'author' and 'tags' to display them
        $post = Post::with(['author', 'tags'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
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
            'slug' => Str::slug($request->title).'-'.Str::random(5),
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
                if (! empty($cleanName)) {
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
