<?php

namespace App\Http\Controllers;

use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('home', compact('projects'));
    }
    public function show($id)
    {
        $project = Project::with('products')->findOrFail($id);

        return view('project-detail', compact('project'));
    }
}