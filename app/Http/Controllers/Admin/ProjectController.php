<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::withCount('recipes');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $projects = $query->latest()
            ->paginate(10)
            ->withQueryString()
            ->withPath(route('admin.projects.index', [], false));

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama project wajib diisi.',
            'description.required' => 'Deskripsi project wajib diisi.',
        ]);

        Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $validated['image'] ?? 'https://via.placeholder.com/300',
        ]);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project DIY berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama project wajib diisi.',
            'description.required' => 'Deskripsi project wajib diisi.',
        ]);

        $project->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $validated['image'] ?? 'https://via.placeholder.com/300',
        ]);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project DIY berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        if ($project->recipes()->count() > 0) {
            return redirect()
                ->route('admin.projects.index')
                ->with('error', 'Project tidak dapat dihapus karena masih memiliki resep DIY.');
        }

        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project DIY berhasil dihapus.');
    }
}