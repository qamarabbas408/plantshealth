<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'slug', 'excerpt', 'body', 'image_path', 'is_published', 'comments_open'];

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
}
