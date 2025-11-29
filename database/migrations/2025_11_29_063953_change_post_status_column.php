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
        Schema::table('posts', function (Blueprint $table) {
            // 1. Add new column
            $table->string('status')->default('draft')->after('slug'); // draft, pending, published, rejected
        });

        // 2. Migrate old data (Safety Step)
        // If it was published=true, make it 'published'. Else 'draft'.
        DB::statement("UPDATE posts SET status = 'published' WHERE is_published = 1");
        DB::statement("UPDATE posts SET status = 'draft' WHERE is_published = 0");

        // 3. Drop old column
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse process
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_published')->default(false);
        });

        DB::statement("UPDATE posts SET is_published = 1 WHERE status = 'published'");

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
