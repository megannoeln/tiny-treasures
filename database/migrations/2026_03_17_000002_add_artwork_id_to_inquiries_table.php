<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->foreignId('artwork_id')->nullable()->after('id')->constrained('artworks')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('artwork_id');
        });
    }
};

