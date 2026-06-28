<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('safaris', function (Blueprint $table) {
            $table->longText('excluded')->nullable()->after('included');
        });
    }

    public function down(): void
    {
        Schema::table('safaris', function (Blueprint $table) {
            $table->dropColumn('excluded');
        });
    }
};
