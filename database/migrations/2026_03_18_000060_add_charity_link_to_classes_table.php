<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('classes', 'charity_link')) {
            return;
        }

        Schema::table('classes', function (Blueprint $table) {
            $table->string('charity_link')->nullable()->after('deposit');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('classes', 'charity_link')) {
            return;
        }

        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('charity_link');
        });
    }
};

