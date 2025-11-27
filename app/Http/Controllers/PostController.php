<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; 

class PostController extends Controller
{
    public function toggleCommentStatus($id)
    {
        $post = Post::findOrFail($id);

        // Security Check: Only the author can close/open comments
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Toggle the boolean value (True -> False, False -> True)
        $post->comments_open = ! $post->comments_open;
        $post->save();

        $status = $post->comments_open ? 'reopened' : 'closed';

        return back()->with('success', "Discussion has been $status.");
    }

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
        $post = Post::with(['author', 'tags', 'comments.user'])
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
        // 1. Determine Status based on which button was clicked
        // We will send an input named 'status' with value 'publish' or 'draft'
        $isPublished = $request->input('status') === 'publish';

        // 2. Validation
        // If it's a draft, we might be lenient, but for now let's keep title/body required
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        // 3. Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts', 'public');
        }

        // 4. Create Post
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title).'-'.bin2hex(random_bytes(6)),
            'body' => $request->body,
            'excerpt' => Str::limit(strip_tags($request->body), 150),
            'image_path' => $imagePath,
            'is_published' => $isPublished, // <--- Dynamic Status
            // If checked, it returns true (1). If unchecked, false (0).
            'comments_open' => $request->boolean('allow_comments'),

        ]);

        // 5. Handle Tags
        if ($request->tags) {
            $tagNames = explode(',', $request->tags);
            foreach ($tagNames as $name) {
                $cleanName = trim($name);
                if (! empty($cleanName)) {
                    $tag = Tag::firstOrCreate(['name' => $cleanName]);
                    $post->tags()->attach($tag->id);
                }
            }
        }

        // 6. Return with specific message
        $message = $isPublished ? 'Story published!' : 'Draft saved successfully.';

        return redirect()->route('dashboard')->with('success', $message);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Security: Ensure only the author can edit
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        // Determine status
        $isPublished = $request->input('status') === 'publish';

        // Validate
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        // Handle Image Update
        if ($request->hasFile('featured_image')) {
            $post->image_path = $request->file('featured_image')->store('posts', 'public');
        }

        // Update Post Fields
        $post->title = $request->title;
        // We usually don't update the slug to prevent breaking SEO links,
        // but you can if you want. Let's keep slug stable for now.
        $post->body = $request->body;
        $post->excerpt = Str::limit(strip_tags($request->body), 150);
        $post->is_published = $isPublished;

        // If checked, it returns true (1). If unchecked, false (0).
        $post->comments_open = $request->boolean('allow_comments');
        $post->save();

        // Handle Tags (Sync removes old ones and adds new ones)
        if ($request->tags) {
            $tagIds = [];
            $tagNames = explode(',', $request->tags);
            foreach ($tagNames as $name) {
                $cleanName = trim($name);
                if (! empty($cleanName)) {
                    $tag = Tag::firstOrCreate(['name' => $cleanName]);
                    $tagIds[] = $tag->id;
                }
            }
            $post->tags()->sync($tagIds); // 'Sync' is magic for Many-to-Many updates
        }

        $message = $isPublished ? 'Story updated and published!' : 'Draft updated successfully.';

        return redirect()->route('dashboard')->with('success', $message);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // 1. Security Check: Only the author can delete
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Delete the Image from Storage (Cleanup)
        if ($post->image_path) {
            // We use the 'public' disk because that's where we stored it
            Storage::disk('public')->delete($post->image_path);
        }

        // 3. Delete the Post
        // Note: Database 'ON DELETE CASCADE' will automatically remove the related Comments and Tags
        $post->delete();

        return back()->with('success', 'Story deleted successfully.');
    }
}
