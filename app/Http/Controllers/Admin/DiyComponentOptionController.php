<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiyRecipeComponent;
use App\Models\DiyComponentOption;
use Illuminate\Http\Request;

class DiyComponentOptionController extends Controller
{
    public function store(Request $request, DiyRecipeComponent $component)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'recommended_quantity' => 'required|integer|min:1',
            'is_default' => 'nullable|boolean',
        ]);

        $validated['diy_recipe_component_id'] = $component->id;
        $validated['is_default'] = $request->has('is_default');

        if ($validated['is_default']) {
            $component->options()->update([
                'is_default' => false
            ]);
        }

        DiyComponentOption::create($validated);

        return redirect()
            ->route('admin.recipes.show', $component->diy_recipe_id)
            ->with('success', 'Opsi produk berhasil ditambahkan.');
    }

    public function destroy(DiyComponentOption $option)
    {
        $recipeId = $option->component->diy_recipe_id;

        $option->delete();

        return redirect()
            ->route('admin.recipes.show', $recipeId)
            ->with('success', 'Opsi produk berhasil dihapus.');
    }
}