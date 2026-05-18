<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\DiyRecipe;
use App\Models\DiyComponentOption;

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

    public function showRecipe(DiyRecipe $recipe)
    {
        $recipe->load('project', 'components.options.product');

        return view('diy.recipe', compact('recipe'));
    }

    public function calculate(Request $request, DiyRecipe $recipe)
    {
        $recipe->load('project', 'components.options.product');

        $selectedComponents = $request->input('components', []);
        $validOptions = $recipe->components
            ->flatMap(function ($component) {
                return $component->options;
            })
            ->keyBy('id');

        $items = [];
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

            $subtotal = $product->price * $quantity;
            $total += $subtotal;

            $items[] = [
                'component_name' => $option->component->component_name,
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'stock_enough' => $product->stock >= $quantity,
            ];
        }

        return view('diy.result', compact('recipe', 'items', 'total'));
    }
}