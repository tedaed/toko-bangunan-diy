@extends('layouts.admin')

@section('title', 'Permintaan Custom')
@section('page-title', 'Permintaan Custom')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <div class="mb-6">
        <h3 class="text-xl font-bold">Data Permintaan Custom</h3>
        <p class="text-sm text-gray-500">
            Kelola permintaan ukuran atau kebutuhan khusus dari pelanggan.
        </p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3 border">Nama</th>
                    <th class="p-3 border">WhatsApp</th>
                    <th class="p-3 border">Project</th>
                    <th class="p-3 border">Ukuran</th>
                    <th class="p-3 border">Kualitas</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($customRequests as $request)
                    <tr>
                        <td class="p-3 border font-semibold">
                            {{ $request->customer_name }}
                        </td>

                        <td class="p-3 border">
                            {{ $request->phone }}
                        </td>

                        <td class="p-3 border">
                            {{ $request->project->name ?? '-' }}
                        </td>

                        <td class="p-3 border">
                            {{ $request->length ?? '-' }}
                            x
                            {{ $request->width ?? '-' }}

                            @if($request->height)
                                x {{ $request->height }}
                            @endif

                            cm
                        </td>

                        <td class="p-3 border">
                            {{ $request->quality ?? '-' }}
                        </td>

                        <td class="p-3 border">
                            <span class="px-3 py-1 rounded text-sm font-bold
                                {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $request->status === 'processed' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $request->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $request->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ strtoupper($request->status) }}
                            </span>
                        </td>

                        <td class="p--100 text-red-700' : '' }}">
                                {{ strtoupper($request->status) }}
                            </span>
                        </td>

                        <td class="p-3 border">
                            <a href="{{ route('admin.custom-requests.show', $request->id) }}"
                               class="bg-blue-600 text-white px-3 py-1 rounded">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">
                            Belum ada permintaan custom.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection