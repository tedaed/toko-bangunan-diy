<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiyRecipe;
use App\Models\Project;
use Illuminate\Http\Request;

class DiyRecipeController extends Controller
{
    public function index()
    {
        $recipes = DiyRecipe::with('project')
            ->latest()
            ->get();

        return view('admin.recipes.index', compact('recipes'));
    }

    public function create()
    {
        $projects = Project::all();

        return view('admin.recipes.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'length' => 'nullable|integer|min:0',
            'width' => 'nullable|integer|min:0',
            'height' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        DiyRecipe::create($validated);

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Resep DIY berhasil ditambahkan.');
    }

    public function edit(DiyRecipe $recipe)
    {
        $projects = Project::all();

        return view('admin.recipes.edit', compact('recipe', 'projects'));
    }

    public function update(Request $request, DiyRecipe $recipe)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'length' => 'nullable|integer|min:0',
            'width' => 'nullable|integer|min:0',
            'height' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $recipe->update($validated);

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Resep DIY berhasil diperbarui.');
    }

    public function destroy(DiyRecipe $recipe)
    {
        $recipe->delete();

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Resep DIY berhasil dihapus.');
    }
}