<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Project;
use App\Models\DiyRecipe;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalProjects = Project::count();
        $totalRecipes = DiyRecipe::count();

        $lowStockProducts = Product::where('stock', '<=', 10)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalProjects',
            'totalRecipes',
            'lowStockProducts'
        ));
    }
}