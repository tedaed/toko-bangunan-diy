<?php

namespace App\Services;

use App\Models\DiyRecipe;
use App\Models\Product;

class RuleBasedRecommendationService
{
    public function recommend(DiyRecipe $recipe, Product $mainProduct): array
    {
        $recipe->loadMissing('project', 'components.options.product');

        $projectName = strtolower($recipe->project->name ?? '');
        $recipeName = strtolower($recipe->name ?? '');

        if (str_contains($projectName, 'rak ambalan') || str_contains($recipeName, 'rak ambalan')) {
            return $this->recommendRakAmbalan($recipe, $mainProduct);
        }

        if (str_contains($projectName, 'kandang') || str_contains($recipeName, 'kandang')) {
            return $this->recommendKandangAyam($recipe, $mainProduct);
        }

        if (str_contains($projectName, 'etalase') || str_contains($recipeName, 'etalase')) {
            return $this->recommendEtalaseKaca($recipe, $mainProduct);
        }

        if (
            str_contains($projectName, 'perabot') ||
            str_contains($projectName, 'penyimpanan') ||
            str_contains($recipeName, 'rak sepatu') ||
            str_contains($recipeName, 'rak bumbu') ||
            str_contains($recipeName, 'box penyimpanan') ||
            str_contains($recipeName, 'rak alat')
        ) {
            return $this->recommendPerabotPenyimpanan($recipe, $mainProduct);
        }

        return [
            'success' => true,
            'type' => 'default',
            'message' => 'Rule khusus belum tersedia untuk project ini.',
            'main_product' => [
                'id' => $mainProduct->id,
                'name' => $mainProduct->name,
                'specification' => $mainProduct->specification,
            ],
            'recommendations' => [],
            'rules' => [],
        ];
    }

    private function recommendRakAmbalan(DiyRecipe $recipe, Product $mainProduct): array
    {
        $length = $this->getLengthCm($mainProduct);

        if ($length <= 0) {
            $length = $this->getDimensionFromRecipeName($recipe, 0);
        }

        if ($length <= 60) {
            $bracketQty = 2;
            $ruleCode = 'RA-01';
        } elseif ($length <= 100) {
            $bracketQty = 3;
            $ruleCode = 'RA-02';
        } else {
            $bracketQty = 4;
            $ruleCode = 'RA-03';
        }

        $screwQty = $bracketQty * 4;
        $fisherQty = $bracketQty * 2;

        $components = $recipe->components;

        $platSikuComponent = $this->findComponent($components, ['plat siku', 'bracket']);
        $sekrupComponent = $this->findComponent($components, ['sekrup', 'screw']);
        $fisherComponent = $this->findComponent($components, ['fisher']);

        $platSikuOption = $this->pickOption($platSikuComponent, function (Product $product) {
            return $this->getSizeInch($product) == 1.5;
        });

        $sekrupOption = $this->pickOption($sekrupComponent, function (Product $product) {
            return $this->getLengthCm($product) == 3;
        });

        $fisherOption = $this->pickOption($fisherComponent, function (Product $product) {
            return $this->getDiameterMm($product) == 6;
        });

        return [
            'success' => true,
            'type' => 'rak_ambalan',
            'main_product' => [
                'id' => $mainProduct->id,
                'name' => $mainProduct->name,
                'specification' => $mainProduct->specification,
                'length_cm' => $length,
            ],
            'recommendations' => [
                'plat_siku' => $this->formatRecommendation($platSikuComponent, $platSikuOption, $bracketQty),
                'sekrup' => $this->formatRecommendation($sekrupComponent, $sekrupOption, $screwQty),
                'fisher' => $this->formatRecommendation($fisherComponent, $fisherOption, $fisherQty),
            ],
            'rules' => [
                [
                    'code' => $ruleCode,
                    'if' => "IF project = Rak Ambalan AND panjang papan = {$length} cm",
                    'then' => "THEN jumlah plat siku = {$bracketQty} pcs",
                ],
                [
                    'code' => 'RA-04',
                    'if' => "IF jumlah plat siku = {$bracketQty}",
                    'then' => "THEN jumlah sekrup = {$bracketQty} × 4 = {$screwQty} pcs",
                ],
                [
                    'code' => 'RA-05',
                    'if' => "IF jumlah plat siku = {$bracketQty}",
                    'then' => "THEN jumlah fisher = {$bracketQty} × 2 = {$fisherQty} pcs",
                ],
            ],
        ];
    }

    private function recommendKandangAyam(DiyRecipe $recipe, Product $mainProduct): array
    {
        $length = $this->getDimensionFromRecipeName($recipe, 0);
        $width = $this->getDimensionFromRecipeName($recipe, 1);
        $height = $this->getDimensionFromRecipeName($recipe, 2);

        if ($length <= 0) {
            $length = $this->getLengthCm($mainProduct);
        }

        if ($width <= 0) {
            $width = $this->getWidthCm($mainProduct);
        }

        $perimeter = 2 * ($length + $width);

        if ($perimeter <= 300) {
            $wireQty = 3;
            $woodQty = 8;
            $ruleCode = 'KA-01';
        } elseif ($perimeter <= 400) {
            $wireQty = 4;
            $woodQty = 10;
            $ruleCode = 'KA-02';
        } else {
            $wireQty = 5;
            $woodQty = 12;
            $ruleCode = 'KA-03';
        }

        $nailQty = $woodQty * 4;
        $hingeQty = 2;

        $components = $recipe->components;

        $woodComponent = $this->findComponent($components, ['blok kayu', 'balok', 'kayu', 'rangka']);
        $wireComponent = $this->findComponent($components, ['kawat ayam', 'kawat']);
        $nailComponent = $this->findComponent($components, ['paku']);
        $hingeComponent = $this->findComponent($components, ['engsel']);

        $woodOption = $this->pickOption($woodComponent, fn(Product $product) => true);
        $wireOption = $this->pickOption($wireComponent, fn(Product $product) => true);
        $nailOption = $this->pickOption($nailComponent, fn(Product $product) => true);
        $hingeOption = $this->pickOption($hingeComponent, fn (Product $product) => true);

        return [
            'success' => true,
            'type' => 'kandang_ayam',
            'main_product' => [
                'id' => $mainProduct->id,
                'name' => $mainProduct->name,
                'specification' => $mainProduct->specification,
                'length_cm' => $length,
                'width_cm' => $width,
                'height_cm' => $height,
                'perimeter_cm' => $perimeter,
            ],
            'recommendations' => [
                'blok_kayu' => $this->formatRecommendation($woodComponent, $woodOption, $woodQty),
                'kawat_ayam' => $this->formatRecommendation($wireComponent, $wireOption, $wireQty),
                'paku' => $this->formatRecommendation($nailComponent, $nailOption, $nailQty),
                'engsel' => $this->formatRecommendation($hingeComponent, $hingeOption, $hingeQty),
            ],
            'rules' => [
                [
                    'code' => $ruleCode,
                    'if' => "IF project = Kandang Ayam AND keliling alas = {$perimeter} cm",
                    'then' => "THEN kawat ayam = {$wireQty} meter dan blok kayu = {$woodQty} batang",
                ],
                [
                    'code' => 'KA-04',
                    'if' => "IF jumlah blok kayu = {$woodQty}",
                    'then' => "THEN jumlah paku = {$woodQty} × 4 = {$nailQty} pcs",
                ],
                [
                    'code' => 'KA-05',
                    'if' => "IF project = Kandang Ayam",
                    'then' => "THEN jumlah engsel = {$hingeQty} pcs",
                ],
            ],
        ];
    }

    private function recommendEtalaseKaca(DiyRecipe $recipe, Product $mainProduct): array
    {
        $length = $this->getDimensionFromRecipeName($recipe, 0);

        if ($length <= 0) {
            $length = $this->getLengthCm($mainProduct);
        }

        if ($length <= 60) {
            $glassGlueQty = 1;
            $screwQty = 8;
            $ruleCode = 'EK-01';
        } else {
            $glassGlueQty = 2;
            $screwQty = 12;
            $ruleCode = 'EK-02';
        }

        $wheelQty = 4;
        // $hingeQty = 2;

        $components = $recipe->components;

        $glassComponent = $this->findComponent($components, ['kaca']);
        $hollowComponent = $this->findComponent($components, ['hollow', 'besi']);
        $glueComponent = $this->findComponent($components, ['lem kaca', 'lem']);
        $wheelComponent = $this->findComponent($components, ['roda']);
        // $hingeComponent = $this->findComponent($components, ['engsel']);
        $screwComponent = $this->findComponent($components, ['sekrup']);

        $glassOption = $this->pickOption($glassComponent, fn(Product $product) => true);
        $hollowOption = $this->pickOption($hollowComponent, fn(Product $product) => true);
        $glueOption = $this->pickOption($glueComponent, fn(Product $product) => true);
        $wheelOption = $this->pickOption($wheelComponent, fn(Product $product) => true);
        // $hingeOption = $this->pickOption($hingeComponent, fn (Product $product) => true);
        $screwOption = $this->pickOption($screwComponent, fn(Product $product) => true);

        return [
            'success' => true,
            'type' => 'etalase_kaca',
            'main_product' => [
                'id' => $mainProduct->id,
                'name' => $mainProduct->name,
                'specification' => $mainProduct->specification,
                'length_cm' => $length,
            ],
            'recommendations' => [
                'kaca' => $this->formatRecommendation($glassComponent, $glassOption, 1),
                'besi_hollow' => $this->formatRecommendation($hollowComponent, $hollowOption, 4),
                'lem_kaca' => $this->formatRecommendation($glueComponent, $glueOption, $glassGlueQty),
                'roda' => $this->formatRecommendation($wheelComponent, $wheelOption, $wheelQty),
                // 'engsel' => $this->formatRecommendation($hingeComponent, $hingeOption, $hingeQty),
                'sekrup' => $this->formatRecommendation($screwComponent, $screwOption, $screwQty),
            ],
            'rules' => [
                [
                    'code' => $ruleCode,
                    'if' => "IF project = Etalase Kaca AND panjang etalase = {$length} cm",
                    'then' => "THEN jumlah lem kaca = {$glassGlueQty} pcs dan sekrup = {$screwQty} pcs",
                ],
                [
                    'code' => 'EK-03',
                    'if' => "IF project = Etalase Kaca",
                    'then' => "THEN jumlah roda = {$wheelQty} pcs",
                ],
                [
                    'code' => 'EK-04',
                    'if' => "IF project = Etalase Kaca",
                    'then' => "THEN jumlah besi hollow = 4 batang untuk rangka etalase",
                ],
            ],
        ];
    }

    private function recommendPerabotPenyimpanan(DiyRecipe $recipe, Product $mainProduct): array
    {
        $height = $this->getDimensionFromRecipeName($recipe, 2);

        if ($height <= 0) {
            $height = $this->getHeightCm($mainProduct);
        }

        if ($height <= 80) {
            $boardQty = 3;
            $ruleCode = 'PP-01';
        } else {
            $boardQty = 4;
            $ruleCode = 'PP-02';
        }

        $screwQty = $boardQty * 6;
        $glueQty = 1;
        $handleQty = 1;
        $railQty = str_contains(strtolower($recipe->name), 'box') ? 0 : 2;

        $components = $recipe->components;

        $boardComponent = $this->findComponent($components, ['papan', 'triplek', 'kayu']);
        $screwComponent = $this->findComponent($components, ['sekrup']);
        $glueComponent = $this->findComponent($components, ['lem kayu', 'lem']);
        $handleComponent = $this->findComponent($components, ['handle', 'pegangan']);
        $railComponent = $this->findComponent($components, ['rel laci', 'rel']);

        $boardOption = $this->pickOption($boardComponent, fn(Product $product) => true);
        $screwOption = $this->pickOption($screwComponent, fn(Product $product) => true);
        $glueOption = $this->pickOption($glueComponent, fn(Product $product) => true);
        $handleOption = $this->pickOption($handleComponent, fn(Product $product) => true);
        $railOption = $this->pickOption($railComponent, fn(Product $product) => true);

        return [
            'success' => true,
            'type' => 'perabot_penyimpanan',
            'main_product' => [
                'id' => $mainProduct->id,
                'name' => $mainProduct->name,
                'specification' => $mainProduct->specification,
                'height_cm' => $height,
            ],
            'recommendations' => [
                'papan' => $this->formatRecommendation($boardComponent, $boardOption, $boardQty),
                'sekrup' => $this->formatRecommendation($screwComponent, $screwOption, $screwQty),
                'lem_kayu' => $this->formatRecommendation($glueComponent, $glueOption, $glueQty),
                'handle' => $this->formatRecommendation($handleComponent, $handleOption, $handleQty),
                'rel_laci' => $this->formatRecommendation($railComponent, $railOption, $railQty),
            ],
            'rules' => [
                [
                    'code' => $ruleCode,
                    'if' => "IF project = Perabot Penyimpanan AND tinggi perabot = {$height} cm",
                    'then' => "THEN jumlah papan/triplek = {$boardQty} lembar",
                ],
                [
                    'code' => 'PP-03',
                    'if' => "IF jumlah papan/triplek = {$boardQty}",
                    'then' => "THEN jumlah sekrup = {$boardQty} × 6 = {$screwQty} pcs",
                ],
                [
                    'code' => 'PP-04',
                    'if' => "IF project = Perabot Penyimpanan",
                    'then' => "THEN jumlah lem kayu = {$glueQty} pcs, handle = {$handleQty} pcs, dan rel laci = {$railQty} set",
                ],
            ],
        ];
    }

    private function findComponent($components, array|string $keywords)
    {
        $keywords = is_array($keywords) ? $keywords : [$keywords];

        return $components->first(function ($component) use ($keywords) {
            $componentName = strtolower($component->component_name ?? '');

            foreach ($keywords as $keyword) {
                if (str_contains($componentName, strtolower($keyword))) {
                    return true;
                }
            }

            return false;
        });
    }

    private function pickOption($component, callable $condition)
    {
        if (!$component) {
            return null;
        }

        return $component->options->first(function ($option) use ($condition) {
            return $option->product && $condition($option->product);
        }) ?? $component->options->first();
    }

    private function formatRecommendation($component, $option, int $quantity): ?array
    {
        if (!$component || !$option || !$option->product || $quantity <= 0) {
            return null;
        }

        return [
            'component_id' => $component->id,
            'component_name' => $component->component_name,
            'option_id' => $option->id,
            'recommended_product_id' => $option->product->id,
            'recommended_product_name' => $option->product->name,
            'recommended_product_specification' => $option->product->specification,
            'quantity' => $quantity,
        ];
    }

    private function getLengthCm(Product $product): float
    {
        if ($product->length_cm) {
            return (float) $product->length_cm;
        }

        $dimensions = $this->extractDimensions($product->specification ?? '');

        if (count($dimensions) >= 1) {
            return (float) $dimensions[0];
        }

        $spec = strtolower($product->specification ?? '');

        if (preg_match('/(\d+(?:[,.]\d+)?)\s*cm/', $spec, $matches)) {
            return (float) str_replace(',', '.', $matches[1]);
        }

        return 0;
    }

    private function getWidthCm(Product $product): float
    {
        if ($product->width_cm) {
            return (float) $product->width_cm;
        }

        $dimensions = $this->extractDimensions($product->specification ?? '');

        if (count($dimensions) >= 2) {
            return (float) $dimensions[1];
        }

        return 0;
    }

    private function getHeightCm(Product $product): float
    {
        if ($product->height_cm ?? null) {
            return (float) $product->height_cm;
        }

        $dimensions = $this->extractDimensions($product->specification ?? '');

        if (count($dimensions) >= 3) {
            return (float) $dimensions[2];
        }

        return 0;
    }

    private function getDiameterMm(Product $product): float
    {
        if ($product->diameter_mm) {
            return (float) $product->diameter_mm;
        }

        $spec = strtolower($product->specification ?? '');

        if (preg_match('/s[-\s]?(\d+)/', $spec, $matches)) {
            return (float) $matches[1];
        }

        if (preg_match('/(\d+(?:[,.]\d+)?)\s*mm/', $spec, $matches)) {
            return (float) str_replace(',', '.', $matches[1]);
        }

        return 0;
    }

    private function getSizeInch(Product $product): float
    {
        if ($product->size_inch) {
            return (float) $product->size_inch;
        }

        $spec = strtolower($product->specification ?? '');
        $spec = str_replace(',', '.', $spec);

        if (preg_match('/(\d+(?:\.\d+)?)\s*(inch|inci|")/', $spec, $matches)) {
            return (float) $matches[1];
        }

        return 0;
    }

    private function getDimensionFromRecipeName(DiyRecipe $recipe, int $index): float
    {
        $dimensions = $this->extractDimensions($recipe->name ?? '');

        return isset($dimensions[$index]) ? (float) $dimensions[$index] : 0;
    }

    private function extractDimensions(string $text): array
    {
        $text = strtolower($text);
        $text = str_replace(',', '.', $text);

        if (preg_match('/(\d+(?:\.\d+)?)\s*x\s*(\d+(?:\.\d+)?)(?:\s*x\s*(\d+(?:\.\d+)?))?/', $text, $matches)) {
            $dimensions = [
                (float) $matches[1],
                (float) $matches[2],
            ];

            if (isset($matches[3]) && $matches[3] !== '') {
                $dimensions[] = (float) $matches[3];
            }

            return $dimensions;
        }

        return [];
    }
}
