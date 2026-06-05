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

        if (str_contains($projectName, 'rak ambalan')) {
            return $this->recommendRakAmbalan($recipe, $mainProduct);
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
            $length = (float) ($recipe->length ?? 0);
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

        $platSikuComponent = $this->findComponent($components, 'plat siku');
        $sekrupComponent = $this->findComponent($components, 'sekrup');
        $fisherComponent = $this->findComponent($components, 'fisher');

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

    private function findComponent($components, string $keyword)
    {
        return $components->first(function ($component) use ($keyword) {
            return str_contains(strtolower($component->component_name), $keyword);
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
        if (!$component || !$option || !$option->product) {
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

        $spec = strtolower($product->specification ?? '');

        if (preg_match('/(\d+(?:[,.]\d+)?)\s*x\s*(\d+(?:[,.]\d+)?)/', $spec, $matches)) {
            return (float) str_replace(',', '.', $matches[1]);
        }

        if (preg_match('/(\d+(?:[,.]\d+)?)\s*cm/', $spec, $matches)) {
            return (float) str_replace(',', '.', $matches[1]);
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
}