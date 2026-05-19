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
        // Produk berasal dari data toko dan beberapa data penyesuaian untuk kebutuhan resep DIY.
        // =========================

        $papanKayu40x20 = Product::create([
            'name' => 'Papan Kayu',
            'category' => 'Material DIY',
            'specification' => '40x20 cm',
            'price' => 55000,
            'stock' => 8,
            'unit' => 'lembar',
            'description' => 'Papan kayu ukuran 40x20 cm untuk rak kecil.',
            'image' => 'https://via.placeholder.com/300'
        ]);

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

        $papanKayu100x30 = Product::create([
            'name' => 'Papan Kayu',
            'category' => 'Material DIY',
            'specification' => '100x30 cm',
            'price' => 130000,
            'stock' => 7,
            'unit' => 'lembar',
            'description' => 'Papan kayu ukuran 100x30 cm untuk rak ambalan besar.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $papanKayu120x30 = Product::create([
            'name' => 'Papan Kayu',
            'category' => 'Material DIY',
            'specification' => '120x30 cm',
            'price' => 155000,
            'stock' => 5,
            'unit' => 'lembar',
            'description' => 'Papan kayu ukuran 120x30 cm untuk rak ambalan panjang.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $papanKayu150x40 = Product::create([
            'name' => 'Papan Kayu',
            'category' => 'Material DIY',
            'specification' => '150x40 cm',
            'price' => 220000,
            'stock' => 3,
            'unit' => 'lembar',
            'description' => 'Papan kayu ukuran 150x40 cm untuk rak ambalan ekstra besar.',
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

        $paku = Product::create([
            'name' => 'Paku',
            'category' => 'Fastener',
            'specification' => '3 cm',
            'price' => 300,
            'stock' => 200,
            'unit' => 'pcs',
            'description' => 'Paku untuk pemasangan material kayu ringan.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $engsel = Product::create([
            'name' => 'Engsel',
            'category' => 'Aksesoris Bangunan',
            'specification' => '2 inch',
            'price' => 7000,
            'stock' => 30,
            'unit' => 'pcs',
            'description' => 'Engsel untuk pintu kandang atau box penyimpanan.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $triplek = Product::create([
            'name' => 'Triplek',
            'category' => 'Material DIY',
            'specification' => '60x40 cm',
            'price' => 65000,
            'stock' => 12,
            'unit' => 'lembar',
            'description' => 'Triplek untuk kebutuhan perabot penyimpanan sederhana.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $lemKayu = Product::create([
            'name' => 'Lem Kayu',
            'category' => 'Perekat',
            'specification' => '250 gram',
            'price' => 18000,
            'stock' => 20,
            'unit' => 'pcs',
            'description' => 'Lem kayu untuk memperkuat sambungan material kayu.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $handle = Product::create([
            'name' => 'Handle',
            'category' => 'Aksesoris Perabot',
            'specification' => '10 cm',
            'price' => 10000,
            'stock' => 25,
            'unit' => 'pcs',
            'description' => 'Handle untuk box atau perabot penyimpanan.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $relLaci = Product::create([
            'name' => 'Rel Laci',
            'category' => 'Aksesoris Perabot',
            'specification' => '30 cm',
            'price' => 28000,
            'stock' => 14,
            'unit' => 'pasang',
            'description' => 'Rel laci untuk perabot penyimpanan sederhana.',
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

        $kaca80x40 = Product::create([
            'name' => 'Kaca',
            'category' => 'Material DIY',
            'specification' => '80x40 cm',
            'price' => 160000,
            'stock' => 5,
            'unit' => 'lembar',
            'description' => 'Kaca ukuran 80x40 cm untuk etalase sederhana.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $besiHollow = Product::create([
            'name' => 'Besi Hollow',
            'category' => 'Material DIY',
            'specification' => '2x2 cm',
            'price' => 45000,
            'stock' => 18,
            'unit' => 'batang',
            'description' => 'Besi hollow untuk rangka etalase sederhana.',
            'image' => 'https://via.placeholder.com/300'
        ]);

        $lemKaca = Product::create([
            'name' => 'Lem Kaca',
            'category' => 'Perekat',
            'specification' => '300 ml',
            'price' => 32000,
            'stock' => 10,
            'unit' => 'pcs',
            'description' => 'Lem kaca untuk pemasangan kaca etalase sederhana.',
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
        // 3. HELPER PEMBUAT RESEP DIY
        // =========================

        $createRecipe = function ($project, array $recipeData, array $components) {
            $recipe = DiyRecipe::create([
                'project_id' => $project->id,
                'name' => $recipeData['name'],
                'length' => $recipeData['length'],
                'width' => $recipeData['width'],
                'height' => $recipeData['height'] ?? null,
                'description' => $recipeData['description'],
                'image' => $recipeData['image'] ?? 'https://via.placeholder.com/300'
            ]);

            foreach ($components as $componentData) {
                $component = DiyRecipeComponent::create([
                    'diy_recipe_id' => $recipe->id,
                    'component_name' => $componentData['name'],
                    'component_type' => $componentData['type'] ?? 'utama',
                    'is_required' => $componentData['required'] ?? true,
                ]);

                foreach ($componentData['options'] as $optionData) {
                    DiyComponentOption::create([
                        'diy_recipe_component_id' => $component->id,
                        'product_id' => $optionData['product']->id,
                        'recommended_quantity' => $optionData['qty'],
                        'is_default' => $optionData['default'] ?? false,
                    ]);
                }
            }

            return $recipe;
        };

        // =========================
        // 4. 6 RESEP RAK AMBALAN
        // =========================

        $createRecipe($rakAmbalan, [
            'name' => 'Rak Ambalan 40x20 cm',
            'length' => 40,
            'width' => 20,
            'description' => 'Resep DIY rak ambalan kecil ukuran 40x20 cm.'
        ], [
            ['name' => 'Papan Kayu', 'type' => 'utama', 'options' => [
                ['product' => $papanKayu40x20, 'qty' => 1, 'default' => true],
            ]],
            ['name' => 'Plat Siku', 'type' => 'utama', 'options' => [
                ['product' => $platSiku, 'qty' => 2, 'default' => true],
            ]],
            ['name' => 'Sekrup', 'type' => 'pelengkap', 'options' => [
                ['product' => $sekrupBiasa, 'qty' => 6, 'default' => true],
                ['product' => $sekrupAwet, 'qty' => 6, 'default' => false],
            ]],
            ['name' => 'Fisher', 'type' => 'pelengkap', 'options' => [
                ['product' => $fisher, 'qty' => 4, 'default' => true],
            ]],
        ]);

        $createRecipe($rakAmbalan, [
            'name' => 'Rak Ambalan 60x20 cm',
            'length' => 60,
            'width' => 20,
            'description' => 'Resep DIY rak ambalan ukuran 60x20 cm.'
        ], [
            ['name' => 'Papan Kayu', 'type' => 'utama', 'options' => [
                ['product' => $papanKayu60x20, 'qty' => 1, 'default' => true],
            ]],
            ['name' => 'Plat Siku', 'type' => 'utama', 'options' => [
                ['product' => $platSiku, 'qty' => 2, 'default' => true],
            ]],
            ['name' => 'Sekrup', 'type' => 'pelengkap', 'options' => [
                ['product' => $sekrupBiasa, 'qty' => 8, 'default' => true],
                ['product' => $sekrupAwet, 'qty' => 8, 'default' => false],
            ]],
            ['name' => 'Fisher', 'type' => 'pelengkap', 'options' => [
                ['product' => $fisher, 'qty' => 4, 'default' => true],
            ]],
        ]);

        $createRecipe($rakAmbalan, [
            'name' => 'Rak Ambalan 80x30 cm',
            'length' => 80,
            'width' => 30,
            'description' => 'Resep DIY rak ambalan ukuran 80x30 cm.'
        ], [
            ['name' => 'Papan Kayu', 'type' => 'utama', 'options' => [
                ['product' => $papanKayu80x30, 'qty' => 1, 'default' => true],
            ]],
            ['name' => 'Plat Siku', 'type' => 'utama', 'options' => [
                ['product' => $platSiku, 'qty' => 3, 'default' => true],
            ]],
            ['name' => 'Sekrup', 'type' => 'pelengkap', 'options' => [
                ['product' => $sekrupBiasa, 'qty' => 10, 'default' => true],
                ['product' => $sekrupAwet, 'qty' => 10, 'default' => false],
            ]],
            ['name' => 'Fisher', 'type' => 'pelengkap', 'options' => [
                ['product' => $fisher, 'qty' => 6, 'default' => true],
            ]],
        ]);

        $createRecipe($rakAmbalan, [
            'name' => 'Rak Ambalan 100x30 cm',
            'length' => 100,
            'width' => 30,
            'description' => 'Resep DIY rak ambalan ukuran 100x30 cm.'
        ], [
            ['name' => 'Papan Kayu', 'type' => 'utama', 'options' => [
                ['product' => $papanKayu100x30, 'qty' => 1, 'default' => true],
            ]],
            ['name' => 'Plat Siku', 'type' => 'utama', 'options' => [
                ['product' => $platSiku, 'qty' => 3, 'default' => true],
            ]],
            ['name' => 'Sekrup', 'type' => 'pelengkap', 'options' => [
                ['product' => $sekrupBiasa, 'qty' => 12, 'default' => true],
                ['product' => $sekrupAwet, 'qty' => 12, 'default' => false],
            ]],
            ['name' => 'Fisher', 'type' => 'pelengkap', 'options' => [
                ['product' => $fisher, 'qty' => 6, 'default' => true],
            ]],
        ]);

        $createRecipe($rakAmbalan, [
            'name' => 'Rak Ambalan 120x30 cm',
            'length' => 120,
            'width' => 30,
            'description' => 'Resep DIY rak ambalan ukuran 120x30 cm.'
        ], [
            ['name' => 'Papan Kayu', 'type' => 'utama', 'options' => [
                ['product' => $papanKayu120x30, 'qty' => 1, 'default' => true],
            ]],
            ['name' => 'Plat Siku', 'type' => 'utama', 'options' => [
                ['product' => $platSiku, 'qty' => 4, 'default' => true],
            ]],
            ['name' => 'Sekrup', 'type' => 'pelengkap', 'options' => [
                ['product' => $sekrupBiasa, 'qty' => 14, 'default' => true],
                ['product' => $sekrupAwet, 'qty' => 14, 'default' => false],
            ]],
            ['name' => 'Fisher', 'type' => 'pelengkap', 'options' => [
                ['product' => $fisher, 'qty' => 8, 'default' => true],
            ]],
        ]);

        $createRecipe($rakAmbalan, [
            'name' => 'Rak Ambalan 150x40 cm',
            'length' => 150,
            'width' => 40,
            'description' => 'Resep DIY rak ambalan ekstra besar ukuran 150x40 cm.'
        ], [
            ['name' => 'Papan Kayu', 'type' => 'utama', 'options' => [
                ['product' => $papanKayu150x40, 'qty' => 1, 'default' => true],
            ]],
            ['name' => 'Plat Siku', 'type' => 'utama', 'options' => [
                ['product' => $platSiku, 'qty' => 4, 'default' => true],
            ]],
            ['name' => 'Sekrup', 'type' => 'pelengkap', 'options' => [
                ['product' => $sekrupBiasa, 'qty' => 16, 'default' => true],
                ['product' => $sekrupAwet, 'qty' => 16, 'default' => false],
            ]],
            ['name' => 'Fisher', 'type' => 'pelengkap', 'options' => [
                ['product' => $fisher, 'qty' => 8, 'default' => true],
            ]],
        ]);

        // =========================
        // 5. 3 RESEP KANDANG AYAM
        // =========================

        $createRecipe($kandangAyam, [
            'name' => 'Kandang Ayam 80x50x60 cm',
            'length' => 80,
            'width' => 50,
            'height' => 60,
            'description' => 'Resep DIY kandang ayam kecil untuk penggunaan sederhana.'
        ], [
            ['name' => 'Blok Kayu', 'type' => 'utama', 'options' => [
                ['product' => $blokKayu, 'qty' => 4, 'default' => true],
            ]],
            ['name' => 'Kawat Ayam', 'type' => 'utama', 'options' => [
                ['product' => $kawatAyam, 'qty' => 2, 'default' => true],
            ]],
            ['name' => 'Paku', 'type' => 'pelengkap', 'options' => [
                ['product' => $paku, 'qty' => 20, 'default' => true],
            ]],
            ['name' => 'Engsel', 'type' => 'pelengkap', 'options' => [
                ['product' => $engsel, 'qty' => 2, 'default' => true],
            ]],
        ]);

        $createRecipe($kandangAyam, [
            'name' => 'Kandang Ayam 100x60x80 cm',
            'length' => 100,
            'width' => 60,
            'height' => 80,
            'description' => 'Resep DIY kandang ayam sedang dengan rangka kayu dan kawat ayam.'
        ], [
            ['name' => 'Blok Kayu', 'type' => 'utama', 'options' => [
                ['product' => $blokKayu, 'qty' => 6, 'default' => true],
            ]],
            ['name' => 'Kawat Ayam', 'type' => 'utama', 'options' => [
                ['product' => $kawatAyam, 'qty' => 3, 'default' => true],
            ]],
            ['name' => 'Paku', 'type' => 'pelengkap', 'options' => [
                ['product' => $paku, 'qty' => 30, 'default' => true],
            ]],
            ['name' => 'Engsel', 'type' => 'pelengkap', 'options' => [
                ['product' => $engsel, 'qty' => 2, 'default' => true],
            ]],
        ]);

        $createRecipe($kandangAyam, [
            'name' => 'Kandang Ayam 120x80x100 cm',
            'length' => 120,
            'width' => 80,
            'height' => 100,
            'description' => 'Resep DIY kandang ayam besar dengan tambahan alas triplek.'
        ], [
            ['name' => 'Blok Kayu', 'type' => 'utama', 'options' => [
                ['product' => $blokKayu, 'qty' => 8, 'default' => true],
            ]],
            ['name' => 'Kawat Ayam', 'type' => 'utama', 'options' => [
                ['product' => $kawatAyam, 'qty' => 4, 'default' => true],
            ]],
            ['name' => 'Triplek', 'type' => 'utama', 'options' => [
                ['product' => $triplek, 'qty' => 1, 'default' => true],
            ]],
            ['name' => 'Paku', 'type' => 'pelengkap', 'options' => [
                ['product' => $paku, 'qty' => 40, 'default' => true],
            ]],
            ['name' => 'Engsel', 'type' => 'pelengkap', 'options' => [
                ['product' => $engsel, 'qty' => 3, 'default' => true],
            ]],
        ]);

        // =========================
        // 6. 2 RESEP ETALASE KACA
        // =========================

        $createRecipe($etalaseKaca, [
            'name' => 'Etalase Kaca 60x40x50 cm',
            'length' => 60,
            'width' => 40,
            'height' => 50,
            'description' => 'Resep DIY etalase kaca sederhana ukuran 60x40x50 cm.'
        ], [
            ['name' => 'Kaca', 'type' => 'utama', 'options' => [
                ['product' => $kaca, 'qty' => 2, 'default' => true],
            ]],
            ['name' => 'Besi Hollow', 'type' => 'utama', 'options' => [
                ['product' => $besiHollow, 'qty' => 4, 'default' => true],
            ]],
            ['name' => 'Sekrup', 'type' => 'pelengkap', 'options' => [
                ['product' => $sekrupBiasa, 'qty' => 8, 'default' => true],
                ['product' => $sekrupAwet, 'qty' => 8, 'default' => false],
            ]],
            ['name' => 'Lem Kaca', 'type' => 'pelengkap', 'options' => [
                ['product' => $lemKaca, 'qty' => 1, 'default' => true],
            ]],
            ['name' => 'Roda Etalase', 'type' => 'pelengkap', 'required' => false, 'options' => [
                ['product' => $rodaEtalase, 'qty' => 4, 'default' => true],
            ]],
        ]);

        $createRecipe($etalaseKaca, [
            'name' => 'Etalase Kaca 80x40x60 cm',
            'length' => 80,
            'width' => 40,
            'height' => 60,
            'description' => 'Resep DIY etalase kaca sedang ukuran 80x40x60 cm.'
        ], [
            ['name' => 'Kaca', 'type' => 'utama', 'options' => [
                ['product' => $kaca80x40, 'qty' => 2, 'default' => true],
            ]],
            ['name' => 'Besi Hollow', 'type' => 'utama', 'options' => [
                ['product' => $besiHollow, 'qty' => 5, 'default' => true],
            ]],
            ['name' => 'Sekrup', 'type' => 'pelengkap', 'options' => [
                ['product' => $sekrupBiasa, 'qty' => 10, 'default' => true],
                ['product' => $sekrupAwet, 'qty' => 10, 'default' => false],
            ]],
            ['name' => 'Lem Kaca', 'type' => 'pelengkap', 'options' => [
                ['product' => $lemKaca, 'qty' => 1, 'default' => true],
            ]],
            ['name' => 'Roda Etalase', 'type' => 'pelengkap', 'required' => false, 'options' => [
                ['product' => $rodaEtalase, 'qty' => 4, 'default' => true],
            ]],
        ]);

        // =========================
        // 7. 4 RESEP PERABOT PENYIMPANAN
        // =========================

        $createRecipe($perabotPenyimpanan, [
            'name' => 'Rak Sepatu 60x30x80 cm',
            'length' => 60,
            'width' => 30,
            'height' => 80,
            'description' => 'Resep DIY rak sepatu sederhana.'
        ], [
            ['name' => 'Triplek', 'type' => 'utama', 'options' => [
                ['product' => $triplek, 'qty' => 2, 'default' => true],
            ]],
            ['name' => 'Blok Kayu', 'type' => 'utama', 'options' => [
                ['product' => $blokKayu, 'qty' => 4, 'default' => true],
            ]],
            ['name' => 'Sekrup', 'type' => 'pelengkap', 'options' => [
                ['product' => $sekrupBiasa, 'qty' => 12, 'default' => true],
                ['product' => $sekrupAwet, 'qty' => 12, 'default' => false],
            ]],
            ['name' => 'Lem Kayu', 'type' => 'pelengkap', 'options' => [
                ['product' => $lemKayu, 'qty' => 1, 'default' => true],
            ]],
        ]);

        $createRecipe($perabotPenyimpanan, [
            'name' => 'Rak Bumbu 40x15x50 cm',
            'length' => 40,
            'width' => 15,
            'height' => 50,
            'description' => 'Resep DIY rak bumbu kecil untuk dapur.'
        ], [
            ['name' => 'Papan Kayu', 'type' => 'utama', 'options' => [
                ['product' => $papanKayu40x20, 'qty' => 1, 'default' => true],
            ]],
            ['name' => 'Blok Kayu', 'type' => 'utama', 'options' => [
                ['product' => $blokKayu, 'qty' => 2, 'default' => true],
            ]],
            ['name' => 'Sekrup', 'type' => 'pelengkap', 'options' => [
                ['product' => $sekrupBiasa, 'qty' => 8, 'default' => true],
                ['product' => $sekrupAwet, 'qty' => 8, 'default' => false],
            ]],
            ['name' => 'Fisher', 'type' => 'pelengkap', 'options' => [
                ['product' => $fisher, 'qty' => 4, 'default' => true],
            ]],
        ]);

        $createRecipe($perabotPenyimpanan, [
            'name' => 'Box Penyimpanan 60x40x40 cm',
            'length' => 60,
            'width' => 40,
            'height' => 40,
            'description' => 'Resep DIY box penyimpanan sederhana.'
        ], [
            ['name' => 'Triplek', 'type' => 'utama', 'options' => [
                ['product' => $triplek, 'qty' => 2, 'default' => true],
            ]],
            ['name' => 'Engsel', 'type' => 'pelengkap', 'options' => [
                ['product' => $engsel, 'qty' => 2, 'default' => true],
            ]],
            ['name' => 'Handle', 'type' => 'pelengkap', 'options' => [
                ['product' => $handle, 'qty' => 1, 'default' => true],
            ]],
            ['name' => 'Sekrup', 'type' => 'pelengkap', 'options' => [
                ['product' => $sekrupBiasa, 'qty' => 12, 'default' => true],
                ['product' => $sekrupAwet, 'qty' => 12, 'default' => false],
            ]],
        ]);

        $createRecipe($perabotPenyimpanan, [
            'name' => 'Rak Alat 100x30x120 cm',
            'length' => 100,
            'width' => 30,
            'height' => 120,
            'description' => 'Resep DIY rak penyimpanan alat sederhana.'
        ], [
            ['name' => 'Papan Kayu', 'type' => 'utama', 'options' => [
                ['product' => $papanKayu100x30, 'qty' => 2, 'default' => true],
            ]],
            ['name' => 'Blok Kayu', 'type' => 'utama', 'options' => [
                ['product' => $blokKayu, 'qty' => 6, 'default' => true],
            ]],
            ['name' => 'Sekrup', 'type' => 'pelengkap', 'options' => [
                ['product' => $sekrupBiasa, 'qty' => 16, 'default' => true],
                ['product' => $sekrupAwet, 'qty' => 16, 'default' => false],
            ]],
            ['name' => 'Rel Laci', 'type' => 'pelengkap', 'required' => false, 'options' => [
                ['product' => $relLaci, 'qty' => 1, 'default' => true],
            ]],
        ]);
    }
}