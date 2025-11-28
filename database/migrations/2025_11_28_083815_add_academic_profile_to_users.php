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
         Schema::table('users', function (Blueprint $table) {
        $table->string('academic_title')->nullable()->after('name'); // e.g. Dr., Prof.
        $table->string('affiliation')->nullable()->after('academic_title'); // University Name
        $table->string('orcid_id')->nullable()->after('affiliation');
        $table->string('url_google_scholar')->nullable()->after('orcid_id');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['academic_title', 'affiliation', 'orcid_id', 'url_google_scholar']);
    });
    }
};
