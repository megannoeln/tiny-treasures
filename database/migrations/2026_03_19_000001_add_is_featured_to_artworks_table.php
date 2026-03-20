<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('artworks', 'is_featured')) {
            return;
        }

        Schema::table('artworks', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('image_path');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('artworks', 'is_featured')) {
            return;
        }

        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn('is_featured');
        });
    }
};

