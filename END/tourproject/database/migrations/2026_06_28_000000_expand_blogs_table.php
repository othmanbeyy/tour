<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
            $table->text('excerpt')->nullable()->after('slug');
            $table->renameColumn('description', 'content');
            $table->string('location')->nullable()->after('content');
            $table->string('category')->default('General')->after('location');
            $table->string('tags')->nullable()->after('category');
            $table->string('duration')->nullable()->after('tags');
            $table->enum('status', ['draft', 'published'])->default('draft')->after('duration');
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete()->after('status');
        });

        // Generate unique slugs for existing records
        $blogs = DB::table('blogs')->select('id', 'title')->get();
        foreach ($blogs as $blog) {
            $slug = Str::slug($blog->title ?? 'untitled');
            $originalSlug = $slug;
            $counter = 1;
            while (DB::table('blogs')->where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            DB::table('blogs')->where('id', $blog->id)->update(['slug' => $slug]);
        }

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('slug')->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropColumn(['slug', 'excerpt', 'location', 'category', 'tags', 'duration', 'status', 'author_id']);
            $table->renameColumn('content', 'description');
        });
    }
};
