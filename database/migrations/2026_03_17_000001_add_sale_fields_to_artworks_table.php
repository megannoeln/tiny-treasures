<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->boolean('is_for_sale')->default(false)->index();
            $table->unsignedInteger('price_cents')->nullable();
            $table->boolean('is_sold')->default(false)->index();
        });
    }

    public function down(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn(['is_for_sale', 'price_cents', 'is_sold']);
        });
    }
};

