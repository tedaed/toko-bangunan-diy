<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiyRecipe;
use App\Models\DiyRecipeComponent;
use Illuminate\Http\Request;

class DiyRecipeComponentController extends Controller
{
    public function store(Request $request, DiyRecipe $recipe)
    {
        $validated = $request->validate([
            'component_name' => 'required|string|max:255',
            'component_type' => 'required|in:utama,pelengkap',
            'is_required' => 'nullable|boolean',
        ]);

        $validated['diy_recipe_id'] = $recipe->id;
        $validated['is_required'] = $request->has('is_required');

        DiyRecipeComponent::create($validated);

        return redirect()
            ->route('admin.recipes.show', $recipe->id)
            ->with('success', 'Komponen berhasil ditambahkan.');
    }

    public function destroy(DiyRecipeComponent $component)
    {
        $recipeId = $component->diy_recipe_id;

        $component->delete();

        return redirect()
            ->route('admin.recipes.show', $recipeId)
            ->with('success', 'Komponen berhasil dihapus.');
    }
}