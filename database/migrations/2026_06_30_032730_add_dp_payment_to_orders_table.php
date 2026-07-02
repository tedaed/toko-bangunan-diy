<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // SIDANG EDIT: DP pembayaran sebelum invoice dibuat
            $table->integer('dp_amount')->default(0)->after('total_price');
            $table->string('payment_proof')->nullable()->after('dp_amount');
            $table->string('payment_status')->default('waiting_dp')->after('payment_proof');
            $table->timestamp('dp_expired_at')->nullable()->after('payment_status');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'dp_amount',
                'payment_proof',
                'payment_status',
                'dp_expired_at',
            ]);
        });
    }
};