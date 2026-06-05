<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('material_type')->nullable()->after('category');
            $table->decimal('length_cm', 8, 2)->nullable()->after('specification');
            $table->decimal('width_cm', 8, 2)->nullable()->after('length_cm');
            $table->decimal('thickness_cm', 8, 2)->nullable()->after('width_cm');
            $table->decimal('diameter_mm', 8, 2)->nullable()->after('thickness_cm');
            $table->decimal('size_inch', 8, 2)->nullable()->after('diameter_mm');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'material_type',
                'length_cm',
                'width_cm',
                'thickness_cm',
                'diameter_mm',
                'size_inch',
            ]);
        });
    }
};