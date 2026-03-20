<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('artworks', 'sort_order')) {
            return;
        }

        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('artworks', 'sort_order')) {
            return;
        }

        Schema::table('artworks', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->after('year');
        });
    }
};

