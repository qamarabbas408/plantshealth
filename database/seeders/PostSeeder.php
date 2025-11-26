<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Realistic Tags
        $tags = [
            'Agriculture', 'Technology', 'Sustainability', 'Hydroponics', 
            'Genetics', 'Policy', 'Climate Change', 'Organic', 
            'Smart Farming', 'Economics', 'Soil Health', 'Water'
        ];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate(['name' => $tagName]);
        }

        // 2. Get all Tags from DB
        $allTags = Tag::all();

        // 3. Create 25 Posts
        // We use the 'make' method first so we can modify relationships before saving
        Post::factory()
            ->count(25) 
            ->create()
            ->each(function ($post) use ($allTags) {
                // 4. Attach 1 to 3 random tags to each post
                $post->tags()->attach(
                    $allTags->random(rand(1, 3))->pluck('id')
                );
            });
    }
}