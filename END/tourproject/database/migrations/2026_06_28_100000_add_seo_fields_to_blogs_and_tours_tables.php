<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('seo_meta_title')->nullable()->after('status');
            $table->text('seo_meta_description')->nullable()->after('seo_meta_title');
            $table->string('focus_keyword')->nullable()->after('seo_meta_description');
        });

        Schema::table('tours', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
            $table->string('seo_meta_title')->nullable()->after('excluded');
            $table->text('seo_meta_description')->nullable()->after('seo_meta_title');
            $table->string('focus_keyword')->nullable()->after('seo_meta_description');
        });

        // Generate unique slugs for existing tours
        $tours = \Illuminate\Support\Facades\DB::table('tours')->select('id', 'title')->get();
        foreach ($tours as $tour) {
            $slug = \Illuminate\Support\Str::slug($tour->title ?? 'untitled');
            $originalSlug = $slug;
            $counter = 1;
            while (\Illuminate\Support\Facades\DB::table('tours')->where('slug', $slug)->where('id', '!=', $tour->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            \Illuminate\Support\Facades\DB::table('tours')->where('id', $tour->id)->update(['slug' => $slug]);
        }

        Schema::table('tours', function (Blueprint $table) {
            $table->string('slug')->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['seo_meta_title', 'seo_meta_description', 'focus_keyword']);
        });

        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn(['slug', 'seo_meta_title', 'seo_meta_description', 'focus_keyword']);
        });
    }
};
