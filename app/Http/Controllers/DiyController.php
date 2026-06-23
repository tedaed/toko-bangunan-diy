<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\DiyRecipe;
// use App\Models\DiyComponentOption;
use App\Services\RuleBasedRecommendationService;

class DiyController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('recipes')->get();

        return view('diy.index', compact('projects'));
    }

    public function showProject(Project $project)
    {
        $project->load('recipes');

        return view('diy.project', compact('project'));
    }

    //Tampilin Komponen per Resep DIY
    public function showRecipe(DiyRecipe $recipe)
    {
        $recipe->load([
            'components' => function ($query) {
                $query->whereHas('options')
                    ->with('options.product');
            }
        ]);

        return view('diy.recipe', compact('recipe'));
    }

    public function calculate(Request $request, DiyRecipe $recipe, RuleBasedRecommendationService $ruleService)
    {
        $recipe->load('project', 'components.options.product');

        $selectedComponents = $request->input('components', []);

        $missingRequiredComponents = $recipe->components
            ->filter(function ($component) use ($selectedComponents) {
                return $component->is_required && !isset($selectedComponents[$component->id]['selected']);
            })
            ->pluck('component_name')
            ->values();

        if ($missingRequiredComponents->isNotEmpty()) {
            return redirect()
                ->route('diy.recipe', $recipe->id)
                ->withInput()
                ->with('required_warning', 'Material wajib belum lengkap: ' . $missingRequiredComponents->implode(', ') . '. Apakah anda yaking melanjutkan pesanan? Anda bisa memilih kembali material yang diperlukan.');
        }
        $validOptions = $recipe->components
            ->flatMap(function ($component) {
                return $component->options;
            })
            ->keyBy('id');

        /*
    |--------------------------------------------------------------------------
    | Backend Rule-Based Recheck D:
    |--------------------------------------------------------------------------
    | Bagian ini mencari bahan utama dari pilihan user, misalnya Papan Kayu.
    | Setelah itu backend menjalankan ulang RuleBasedRecommendationService.
    | Jadi rule-based tidak hanya berjalan di JavaScript/API, tetapi juga
    | dicek ulang saat user menekan tombol Hitung Estimasi.
    */
        $mainProduct = null;

        foreach ($selectedComponents as $componentId => $data) {
            if (!isset($data['selected'])) {
                continue;
            }

            $optionId = (int) ($data['option_id'] ?? 0);

            if (!$validOptions->has($optionId)) {
                continue;
            }

            $option = $validOptions->get($optionId);

            $componentName = strtolower($option->component->component_name ?? '');

            if (
                str_contains($componentName, 'papan') ||
                str_contains($componentName, 'kayu') ||
                str_contains($componentName, 'kaca') ||
                str_contains($componentName, 'kawat') ||
                str_contains($componentName, 'hollow') ||
                str_contains($componentName, 'triplek') ||
                str_contains($componentName, 'blok')
            ) {
                $mainProduct = $option->product;
                break;
            }
        }

        $ruleBasedResult = null;
        $recommendedByComponent = collect();

        if ($mainProduct) {
            $ruleBasedResult = $ruleService->recommend($recipe, $mainProduct);

            $recommendedByComponent = collect($ruleBasedResult['recommendations'] ?? [])
                ->filter()
                ->keyBy('component_id');
        }

        $items = [];
        $checkoutItems = [];
        $total = 0;

        foreach ($selectedComponents as $componentId => $data) {
            if (!isset($data['selected'])) {
                continue;
            }

            $optionId = (int) ($data['option_id'] ?? 0);
            $quantity = max(1, (int) ($data['quantity'] ?? 1));

            if (!$validOptions->has($optionId)) {
                continue;
            }

            $option = $validOptions->get($optionId);
            $product = $option->product;

            /*
        |--------------------------------------------------------------------------
        | Minimum Quantity Rule:D
        |--------------------------------------------------------------------------
        | Jika komponen ini punya rekomendasi quantity dari rule-based,
        | maka backend memastikan quantity tidak boleh kurang dari minimum rule.
        | User tetap boleh membeli lebih banyak/kurang.
        */
            $ruleRecommendation = $recommendedByComponent->get($option->component->id);

            $minimumRuleQuantity = null;
            $isRuleRecommendedProduct = false;
            $isBelowRecommendedQuantity = false;

            if ($ruleRecommendation) {
                $minimumRuleQuantity = (int) $ruleRecommendation['quantity'];

                $isBelowRecommendedQuantity = $quantity < $minimumRuleQuantity;

                $isRuleRecommendedProduct =
                    (int) $ruleRecommendation['recommended_product_id'] === (int) $product->id;
            }

            if ($ruleRecommendation) {
                $minimumRuleQuantity = (int) $ruleRecommendation['quantity'];

                $ruleRecommendation = $recommendedByComponent->get($option->component->id);

                $minimumRuleQuantity = null;
                $isRuleRecommendedProduct = false;
                $isBelowRecommendedQuantity = false;

                if ($ruleRecommendation) {
                    $minimumRuleQuantity = (int) $ruleRecommendation['quantity'];

                    $isBelowRecommendedQuantity = $quantity < $minimumRuleQuantity;

                    $isRuleRecommendedProduct =
                        (int) $ruleRecommendation['recommended_product_id'] === (int) $product->id;
                }

                $isRuleRecommendedProduct =
                    (int) $ruleRecommendation['recommended_product_id'] === (int) $product->id;
            }

            $subtotal = $product->price * $quantity;
            $total += $subtotal;

            $items[] = [
                'component_name' => $option->component->component_name,
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'stock_enough' => $product->stock >= $quantity,
                'minimum_rule_quantity' => $minimumRuleQuantity,
                'is_rule_recommended_product' => $isRuleRecommendedProduct,
                'is_below_recommended_quantity' => $isBelowRecommendedQuantity,
            ];

            $checkoutItems[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
            ];
        }

        session([
            'checkout' => [
                'recipe_id' => $recipe->id,
                'items' => $checkoutItems,
            ]
        ]);

        return view('diy.result', compact('recipe', 'items', 'total', 'ruleBasedResult'));
    }
}
