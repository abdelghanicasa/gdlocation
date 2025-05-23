<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title'); // Add slug column as nullable temporarily
        });

        // Populate slug column with unique values
        DB::table('pages')->get()->each(function ($page) {
            $slug = Str::slug($page->title);
            $uniqueSlug = $slug;
            $counter = 1;

            // Ensure the slug is unique
            while (DB::table('pages')->where('slug', $uniqueSlug)->exists()) {
                $uniqueSlug = $slug . '-' . $counter;
                $counter++;
            }

            DB::table('pages')->where('id', $page->id)->update(['slug' => $uniqueSlug]);
        });

        // Make the slug column unique and non-nullable
        Schema::table('pages', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('slug'); // Remove slug column
        });
    }
};
