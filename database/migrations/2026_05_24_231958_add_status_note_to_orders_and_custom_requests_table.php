<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('status_note')->nullable()->after('status');
        });

        Schema::table('custom_requests', function (Blueprint $table) {
            $table->text('status_note')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status_note');
        });

        Schema::table('custom_requests', function (Blueprint $table) {
            $table->dropColumn('status_note');
        });
    }
};