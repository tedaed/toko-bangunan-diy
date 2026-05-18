<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('diy_recipe_components', function (Blueprint $table) {
        $table->id();
        $table->foreignId('diy_recipe_id')->constrained()->onDelete('cascade');
        $table->string('component_name');
        $table->enum('component_type', ['utama', 'pelengkap'])->default('utama');
        $table->boolean('is_required')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diy_recipe_components');
    }
};
