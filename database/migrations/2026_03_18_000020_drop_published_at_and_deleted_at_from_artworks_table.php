<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $drop = [];
        if (Schema::hasColumn('artworks', 'published_at')) {
            $drop[] = 'published_at';
        }
        if (Schema::hasColumn('artworks', 'deleted_at')) {
            $drop[] = 'deleted_at';
        }

        if ($drop === []) {
            return;
        }

        Schema::table('artworks', function (Blueprint $table) use ($drop) {
            $table->dropColumn($drop);
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('artworks', 'published_at')) {
            Schema::table('artworks', function (Blueprint $table) {
                $table->timestamp('published_at')->nullable()->index();
            });
        }

        if (! Schema::hasColumn('artworks', 'deleted_at')) {
            Schema::table('artworks', function (Blueprint $table) {
                $table->timestamp('deleted_at')->nullable()->index();
            });
        }
    }
};
