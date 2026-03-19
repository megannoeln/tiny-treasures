<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('inquiries', 'status')) {
            return;
        }

        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('inquiries', 'status')) {
            return;
        }

        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('status')->default('new')->after('message');
        });
    }
};

