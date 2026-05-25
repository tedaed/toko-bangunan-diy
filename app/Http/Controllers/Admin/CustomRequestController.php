<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomRequest;
use Illuminate\Http\Request;

class CustomRequestController extends Controller
{
    public function index()
    {
        $customRequests = CustomRequest::with('project')
            ->latest()
            ->get();

        return view('admin.custom_requests.index', compact('customRequests'));
    }

    public function show(CustomRequest $customRequest)
    {
        $customRequest->load('project');

        return view('admin.custom_requests.show', compact('customRequest'));
    }

    public function updateStatus(Request $request, CustomRequest $customRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processed,completed,rejected',
            'status_note' => 'nullable|string|max:1000',
        ]);

        if ($validated['status'] === 'rejected' && empty($validated['status_note'])) {
            return redirect()
                ->route('admin.custom-requests.show', $customRequest->id)
                ->with('error', 'Alasan penolakan wajib diisi.');
        }

        $customRequest->update([
            'status' => $validated['status'],
            'status_note' => $validated['status_note'] ?? $customRequest->status_note,
        ]);

        return redirect()
            ->route('admin.custom-requests.show', $customRequest->id)
            ->with('success', 'Status permintaan custom berhasil diperbarui.');
    }
}
