<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('starts_at')->index();
            $table->unsignedInteger('capacity')->nullable();
            $table->boolean('sold_out')->default(false);
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('deposit', 10, 2)->nullable();
            $table->string('charity_link')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
