<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DiyRecipe;
use App\Models\Product;
use App\Services\RuleBasedRecommendationService;
use Illuminate\Http\Request;

class RuleRecommendationController extends Controller
{
    public function show(Request $request, RuleBasedRecommendationService $service)
    {
        $validated = $request->validate([
            'recipe_id' => 'required|exists:diy_recipes,id',
            'main_product_id' => 'required|exists:products,id',
        ]);

        $recipe = DiyRecipe::with('project', 'components.options.product')
            ->findOrFail($validated['recipe_id']);

        $mainProduct = Product::findOrFail($validated['main_product_id']);

        $result = $service->recommend($recipe, $mainProduct);

        return response()->json($result);
    }
}