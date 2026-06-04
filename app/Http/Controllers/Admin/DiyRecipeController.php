<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiyRecipe;
use App\Models\Project;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiyRecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = DiyRecipe::with('project');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $recipes = $query->latest()
            ->paginate(10)
            ->withQueryString()
            ->withPath(route('admin.recipes.index', [], false));

        $projects = Project::orderBy('name')->get();

        return view('admin.recipes.index', compact('recipes', 'projects'));
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }
        if ($request->hasFile('image')) {
            if ($recipe->image && !filter_var($recipe->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($recipe->image);
            }

            $validated['image'] = $request->file('image')->store('recipes', 'public');
        } else {
            unset($validated['image']);
        }

        $recipe->update($validated);

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Resep DIY berhasil diperbarui.');
    }

    public function destroy(DiyRecipe $recipe)
    {
        if ($recipe->image && !filter_var($recipe->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($recipe->image);
        }
        $recipe->delete();

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Resep DIY berhasil dihapus.');
    }
    public function show(DiyRecipe $recipe)
    {
        $recipe->load('project', 'components.options.product');

        $products = Product::orderBy('name')->get();

        return view('admin.recipes.show', compact('recipe', 'products'));
    }
}
