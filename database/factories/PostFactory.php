<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence;
        
        // Generate valid HTML body to mimic Quill Editor
        $body = '<p>' . implode('</p><p>', $this->faker->paragraphs(5)) . '</p>' .
                '<h2>' . $this->faker->sentence . '</h2>' .
                '<p>' . $this->faker->paragraph . '</p>';

        return [
            // Pick a random user (or create one if none exist)
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            
            'title' => $title,
            
            // Mimic your Controller's ID logic (slug + hex)
            'slug' => Str::slug($title) . '-' . bin2hex(random_bytes(6)),
            
            'excerpt' => $this->faker->text(150),
            'body' => $body,
            
            // Random Unsplash Agriculture Images
            'image_path' => 'https://images.unsplash.com/photo-' . $this->faker->randomElement([
                '1625246333195-5512a96d8a48', // Green Tea
                '1586771107445-d3ca888129ff', // Soil
                '1530836369250-ef72a3f5cda8', // Hydroponics
                '1574943320219-553eb213f72d', // Wheat
                '1592982537480-a684d01d946c', // Tractor
                '1500937386664-56d1dfef3854', // Field
            ]) . '?q=80&w=800&auto=format&fit=crop',
            
            'is_published' => true,
        ];
    }
}