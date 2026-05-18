<?php

namespace App\Http\Controllers;

use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('recipes')->get();

        return view('home', compact('projects'));
    }
}