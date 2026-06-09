<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('class_attendees');
    }

    public function down(): void
    {
        Schema::create('class_attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_listing_id')->constrained('classes')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });
    }
};
