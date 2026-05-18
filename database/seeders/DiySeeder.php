<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Product;
use App\Models\DiyRecipe;
use App\Models\DiyRecipeComponent;
use App\Models\DiyComponentOption;

class DiySeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // 1. DATA PROJECT DIY
        // =========================

        $rakAmbalan = Project::create([
            'name' => 'Rak Ambalan',
            'description' => 'Proyek DIY untuk membuat rak dinding sederhana dengan bahan kayu dan aksesoris pemasangan.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $kandangAyam = Project::create([
            'name' => 'Kandang Ayam Sederhana',
            'description' => 'Proyek DIY untuk membuat kandang ayam sederhana menggunakan rangka kayu dan kawat ayam.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $etalaseKaca = Project::create([
            'name' => 'Etalase Kaca Sederhana',
            'description' => 'Proyek DIY untuk membuat etalase kaca sederhana dengan rangka, kaca, dan aksesoris pendukung.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $perabotPenyimpanan = Project::create([
            'name' => 'Perabot Penyimpanan',
            'description' => 'Proyek DIY untuk membuat rak atau tempat penyimpanan sederhana.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        // =========================
        // 2. DATA PRODUK
        // =========================

        $papanKayu60x20 = Product::create([
            'name' => 'Papan Kayu',
            'category' => 'Material DIY',
            'specification' => '60x20 cm',
            'price' => 75000,
            'stock' => 10,
            'unit' => 'lembar',
            'description' => 'Papan kayu ukuran 60x20 cm untuk rak ambalan.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $papanKayu80x30 = Product::create([
            'name' => 'Papan Kayu',
            'category' => 'Material DIY',
            'specification' => '80x30 cm',
            'price' => 100000,
            'stock' => 5,
            'unit' => 'lembar',
            'description' => 'Papan kayu ukuran 80x30 cm untuk rak ambalan ukuran besar.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $platSiku = Product::create([
            'name' => 'Plat Siku',
            'category' => 'Aksesoris Bangunan',
            'specification' => '1,5 inch',
            'price' => 8000,
            'stock' => 20,
            'unit' => 'pcs',
            'description' => 'Plat siku untuk penyangga rak atau rangka sederhana.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $sekrupBiasa = Product::create([
            'name' => 'Sekrup Biasa',
            'category' => 'Fastener',
            'specification' => '3 cm',
            'price' => 500,
            'stock' => 100,
            'unit' => 'pcs',
            'description' => 'Sekrup biasa untuk pemasangan material ringan.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $sekrupAwet = Product::create([
            'name' => 'Sekrup Stainless',
            'category' => 'Fastener',
            'specification' => '3 cm',
            'price' => 1000,
            'stock' => 40,
            'unit' => 'pcs',
            'description' => 'Sekrup stainless yang lebih awet dan tahan karat.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $fisher = Product::create([
            'name' => 'Fisher',
            'category' => 'Aksesoris Bangunan',
            'specification' => 'S-6',
            'price' => 1000,
            'stock' => 50,
            'unit' => 'pcs',
            'description' => 'Fisher untuk pemasangan sekrup pada dinding.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $kawatAyam = Product::create([
            'name' => 'Kawat Ayam',
            'category' => 'Material DIY',
            'specification' => '1 meter',
            'price' => 25000,
            'stock' => 20,
            'unit' => 'meter',
            'description' => 'Kawat ayam untuk pembuatan kandang sederhana.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $blokKayu = Product::create([
            'name' => 'Blok Kayu',
            'category' => 'Material DIY',
            'specification' => '2x4 cm',
            'price' => 35000,
            'stock' => 15,
            'unit' => 'batang',
            'description' => 'Blok kayu untuk rangka kandang atau perabot sederhana.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $kaca = Product::create([
            'name' => 'Kaca',
            'category' => 'Material DIY',
            'specification' => '60x40 cm',
            'price' => 120000,
            'stock' => 6,
            'unit' => 'lembar',
            'description' => 'Kaca untuk kebutuhan etalase sederhana.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $rodaEtalase = Product::create([
            'name' => 'Roda Etalase',
            'category' => 'Aksesoris Etalase',
            'specification' => '1 inch',
            'price' => 12000,
            'stock' => 16,
            'unit' => 'pcs',
            'description' => 'Roda kecil untuk etalase agar mudah dipindahkan.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        // =========================
        // 3. RESEP RAK AMBALAN 60x20
        // =========================

        $rak60x20 = DiyRecipe::create([
            'project_id' => $rakAmbalan->id,
            'name' => 'Rak Ambalan 60x20 cm',
            'length' => 60,
            'width' => 20,
            'height' => null,
            'description' => 'Resep DIY rak ambalan ukuran 60x20 cm.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $komponenPapan = DiyRecipeComponent::create([
            'diy_recipe_id' => $rak60x20->id,
            'component_name' => 'Papan Kayu',
            'component_type' => 'utama',
            'is_required' => true
        ]);

        DiyComponentOption::create([
            'diy_recipe_component_id' => $komponenPapan->id,
            'product_id' => $papanKayu60x20->id,
            'recommended_quantity' => 1,
            'is_default' => true
        ]);

        $komponenPlatSiku = DiyRecipeComponent::create([
            'diy_recipe_id' => $rak60x20->id,
            'component_name' => 'Plat Siku',
            'component_type' => 'utama',
            'is_required' => true
        ]);

        DiyComponentOption::create([
            'diy_recipe_component_id' => $komponenPlatSiku->id,
            'product_id' => $platSiku->id,
            'recommended_quantity' => 2,
            'is_default' => true
        ]);

        $komponenSekrup = DiyRecipeComponent::create([
            'diy_recipe_id' => $rak60x20->id,
            'component_name' => 'Sekrup',
            'component_type' => 'pelengkap',
            'is_required' => true
        ]);

        DiyComponentOption::create([
            'diy_recipe_component_id' => $komponenSekrup->id,
            'product_id' => $sekrupBiasa->id,
            'recommended_quantity' => 8,
            'is_default' => true
        ]);

        DiyComponentOption::create([
            'diy_recipe_component_id' => $komponenSekrup->id,
            'product_id' => $sekrupAwet->id,
            'recommended_quantity' => 8,
            'is_default' => false
        ]);

        $komponenFisher = DiyRecipeComponent::create([
            'diy_recipe_id' => $rak60x20->id,
            'component_name' => 'Fisher',
            'component_type' => 'pelengkap',
            'is_required' => true
        ]);

        DiyComponentOption::create([
            'diy_recipe_component_id' => $komponenFisher->id,
            'product_id' => $fisher->id,
            'recommended_quantity' => 4,
            'is_default' => true
        ]);

        // =========================
        // 4. RESEP ETALASE KACA 60x40x50
        // =========================

        $etalase60x40 = DiyRecipe::create([
            'project_id' => $etalaseKaca->id,
            'name' => 'Etalase Kaca 60x40x50 cm',
            'length' => 60,
            'width' => 40,
            'height' => 50,
            'description' => 'Resep DIY etalase kaca sederhana ukuran 60x40x50 cm.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $komponenKaca = DiyRecipeComponent::create([
            'diy_recipe_id' => $etalase60x40->id,
            'component_name' => 'Kaca',
            'component_type' => 'utama',
            'is_required' => true
        ]);

        DiyComponentOption::create([
            'diy_recipe_component_id' => $komponenKaca->id,
            'product_id' => $kaca->id,
            'recommended_quantity' => 2,
            'is_default' => true
        ]);

        $komponenRoda = DiyRecipeComponent::create([
            'diy_recipe_id' => $etalase60x40->id,
            'component_name' => 'Roda Etalase',
            'component_type' => 'pelengkap',
            'is_required' => false
        ]);

        DiyComponentOption::create([
            'diy_recipe_component_id' => $komponenRoda->id,
            'product_id' => $rodaEtalase->id,
            'recommended_quantity' => 4,
            'is_default' => true
        ]);
    }
}