<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The Author
        $table->string('title');
        $table->string('slug')->unique(); // For URL
        $table->text('excerpt')->nullable(); // Short summary
        $table->longText('body'); // HTML content
        $table->string('image_path')->nullable(); // Cover image
        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
