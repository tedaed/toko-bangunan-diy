<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diy_component_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diy_recipe_component_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('product_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->integer('recommended_quantity');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diy_component_options');
    }
};