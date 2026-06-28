<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('traveler_name');
            $table->string('country')->nullable();
            $table->foreignId('tour_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('safari_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title')->nullable();
            $table->tinyInteger('rating')->unsigned();
            $table->longText('description');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
