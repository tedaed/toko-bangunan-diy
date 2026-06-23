<?php

namespace App\Http\Controllers;

use App\Models\CustomRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomRequestController extends Controller
{
    public function create(Request $request)
    {
        $projects = Project::orderBy('name')->get();
        $selectedProjectId = $request->query('project_id');

        return view('custom_requests.create', compact('projects', 'selectedProjectId'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'project_id' => 'required|exists:projects,id',
            'quality' => 'required|in:Ekonomis,Standar,Premium',
            'length' => 'required|numeric|min:1',
            'width' => 'required|numeric|min:1',
            'height' => 'nullable|numeric|min:1',
            'note' => 'nullable|string|max:1000',
        ], [
            'customer_name.required' => 'Nama pelanggan wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.regex' => 'Nomor WhatsApp harus berisi 10 sampai 15 digit angka.',
            'project_id.required' => 'Project DIY wajib dipilih.',
            'project_id.exists' => 'Project DIY yang dipilih tidak valid.',
            'quality.required' => 'Kualitas bahan wajib dipilih.',
            'quality.in' => 'Kualitas bahan tidak valid.',
            'length.required' => 'Panjang wajib diisi.',
            'length.numeric' => 'Panjang harus berupa angka.',
            'length.min' => 'Panjang minimal 1 cm.',
            'width.required' => 'Lebar wajib diisi.',
            'width.numeric' => 'Lebar harus berupa angka.',
            'width.min' => 'Lebar minimal 1 cm.',
            'height.numeric' => 'Tinggi harus berupa angka.',
            'height.min' => 'Tinggi minimal 1 cm.',
            'note.max' => 'Catatan kebutuhan maksimal 1000 karakter.',
        ]);

        $validator->after(function ($validator) use ($request) {
            $project = Project::find($request->project_id);

            if (!$project) {
                return;
            }

            $projectName = strtolower($project->name);

            $limits = [
                'default' => [
                    'label' => 'Project DIY',
                    'length' => 300,
                    'width' => 200,
                    'height' => 250,
                ],
                'rak_ambalan' => [
                    'label' => 'Rak Ambalan',
                    'length' => 500,
                    'width' => 80,
                    'height' => 50,
                ],
                'kandang_ayam' => [
                    'label' => 'Kandang Ayam',
                    'length' => 200,
                    'width' => 150,
                    'height' => 200,
                ],
                'etalase_kaca' => [
                    'label' => 'Etalase Kaca',
                    'length' => 150,
                    'width' => 80,
                    'height' => 150,
                ],
                'perabot_penyimpanan' => [
                    'label' => 'Perabot Penyimpanan',
                    'length' => 200,
                    'width' => 100,
                    'height' => 200,
                ],
            ];

            $selectedLimit = $limits['default'];

            if (str_contains($projectName, 'rak ambalan')) {
                $selectedLimit = $limits['rak_ambalan'];
            } elseif (str_contains($projectName, 'kandang')) {
                $selectedLimit = $limits['kandang_ayam'];
            } elseif (str_contains($projectName, 'etalase')) {
                $selectedLimit = $limits['etalase_kaca'];
            } elseif (str_contains($projectName, 'perabot') || str_contains($projectName, 'penyimpanan')) {
                $selectedLimit = $limits['perabot_penyimpanan'];
            }

            $length = (float) $request->input('length', 0);
            $width = (float) $request->input('width', 0);
            $height = $request->filled('height') ? (float) $request->input('height') : null;

            if ($length > $selectedLimit['length']) {
                $validator->errors()->add(
                    'length',
                    'Panjang melebihi batas maksimal untuk ' . $selectedLimit['label'] .
                    ', yaitu ' . $selectedLimit['length'] . ' cm.'
                );
            }

            if ($width > $selectedLimit['width']) {
                $validator->errors()->add(
                    'width',
                    'Lebar melebihi batas maksimal untuk ' . $selectedLimit['label'] .
                    ', yaitu ' . $selectedLimit['width'] . ' cm.'
                );
            }

            if ($height !== null && $height > $selectedLimit['height']) {
                $validator->errors()->add(
                    'height',
                    'Tinggi melebihi batas maksimal untuk ' . $selectedLimit['label'] .
                    ', yaitu ' . $selectedLimit['height'] . ' cm.'
                );
            }
        });

        $validated = $validator->validate();

        $customRequest = CustomRequest::create([
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'project_id' => $validated['project_id'],
            'quality' => $validated['quality'],
            'length' => $validated['length'],
            'width' => $validated['width'],
            'height' => $validated['height'] ?? null,
            'note' => $validated['note'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('custom-requests.success', $customRequest->id);
    }

    public function success(CustomRequest $customRequest)
    {
        $customRequest->load('project');

        return view('custom_requests.success', compact('customRequest'));
    }
}