<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('classes', 'sold_out')) {
            return;
        }

        Schema::table('classes', function (Blueprint $table) {
            $table->boolean('sold_out')->default(false)->after('capacity');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('classes', 'sold_out')) {
            return;
        }

        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('sold_out');
        });
    }
};
