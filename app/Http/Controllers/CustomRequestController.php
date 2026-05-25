<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\CustomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomRequestController extends Controller
{
    public function create(Request $request)
    {
        $projects = Project::all();

        $selectedProjectId = $request->query('project_id');

        return view('custom_requests.create', compact('projects', 'selectedProjectId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'customer_name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'length' => 'required|integer|min:1',
            'width' => 'required|integer|min:1|lte:length',
            'height' => 'nullable|integer|min:1',
            'quality' => 'nullable|string|max:100',
            'note' => 'required|string',
        ], [
            'customer_name.required' => 'Nama pelanggan wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.regex' => 'Nomor WhatsApp harus berupa angka 10 sampai 15 digit.',
            'length.required' => 'Panjang wajib diisi.',
            'width.required' => 'Lebar wajib diisi.',
            'width.lte' => 'Lebar tidak boleh lebih besar dari panjang.',
            'note.required' => 'Catatan kebutuhan wajib diisi.',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $customRequest = CustomRequest::create($validated);

        return redirect()->route('custom-requests.success', $customRequest->id);
    }

    public function success(CustomRequest $customRequest)
    {
        $customRequest->load('project');

        return view('custom_requests.success', compact('customRequest'));
    }
}
