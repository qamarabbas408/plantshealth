<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'slug', 'excerpt', 'body', 'image_path', 'is_published', 'comments_open','status'];

    // Add this Accessor
    public function getReadTimeAttribute()
    {
        // 1. Remove HTML tags so we only count real words
        $cleanContent = strip_tags($this->body);

        // 2. Count words
        $wordCount = str_word_count($cleanContent);

        // 3. Calculate minutes (assuming 200 words per minute)
        $minutes = ceil($wordCount / 200);

        // 4. Return at least 1 min
        return max(1, $minutes);
    }

    // RELATIONSHIPS
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest(); // Newest comments first
    }

    // Add these methods
    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_user_likes');
    }

    public function bookmarks()
    {
        return $this->belongsToMany(User::class, 'post_user_bookmarks');
    }

    // Helper to check if current user liked it
    public function isLikedBy($user)
    {
        if (! $user) {
            return false;
        }

        return $this->likes->contains($user->id);
    }

    // Helper to check if current user bookmarked it
    public function isBookmarkedBy($user)
    {
        if (! $user) {
            return false;
        }

        return $this->bookmarks->contains($user->id);
    }

    // Helper: Post::published()->get()
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Helper: Post::pending()->get()
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
