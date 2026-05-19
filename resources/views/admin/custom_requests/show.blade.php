@extends('layouts.admin')

@section('title', 'Detail Permintaan Custom')
@section('page-title', 'Detail Permintaan Custom')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">

        <div class="flex items-center justify-between border-b pb-4 mb-6">
            <div>
                <h3 class="text-2xl font-bold">
                    {{ $customRequest->customer_name }}
                </h3>

                <p class="text-gray-500">
                    Diajukan pada {{ $customRequest->created_at->format('d-m-Y H:i') }}
                </p>
            </div>

            <span class="px-4 py-2 rounded font-bold
                {{ $customRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $customRequest->status === 'processed' ? 'bg-blue-100 text-blue-700' : '' }}
                {{ $customRequest->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                {{ $customRequest->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                {{ strtoupper($customRequest->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-gray-500">Nama Pelanggan</p>
                <p class="font-bold">{{ $customRequest->customer_name }}</p>
            </div>

            <div>
                <p class="text-gray-500">Nomor WhatsApp</p>
                <p class="font-bold">{{ $customRequest->phone }}</p>
            </div>

            <div>
                <p class="text-gray-500">Project DIY</p>
                <p class="font-bold">{{ $customRequest->project->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Kualitas Bahan</p>
                <p class="font-bold">{{ $customRequest->quality ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Panjang</p>
                <p class="font-bold">{{ $customRequest->length ?? '-' }} cm</p>
            </div>

            <div>
                <p class="text-gray-500">Lebar</p>
                <p class="font-bold">{{ $customRequest->width ?? '-' }} cm</p>
            </div>

            <div>
                <p class="text-gray-500">Tinggi</p>
                <p class="font-bold">{{ $customRequest->height ?? '-' }} cm</p>
            </div>
        </div>

        <div class="bg-gray-100 rounded p-4">
            <p class="font-bold mb-2">Catatan Kebutuhan:</p>
            <p>{{ $customRequest->note }}</p>
        </div>

    </div>

    <div class="bg-white rounded-xl shadow p-6 h-fit">
        <h3 class="text-xl font-bold mb-4">
            Ubah Status
        </h3>

        <form action="{{ route('admin.custom-requests.update-status', $customRequest->id) }}"
              method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Status Permintaan
                </label>

                <select name="status" class="w-full border rounded p-2">
                    <option value="pending" {{ $customRequest->status === 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="processed" {{ $customRequest->status === 'processed' ? 'selected' : '' }}>
                        Processed
                    </option>

                    <option value="completed" {{ $customRequest->status === 'completed' ? 'selected' : '' }}>
                        Completed
                    </option>

                    <option value="rejected" {{ $customRequest->status === 'rejected' ? 'selected' : '' }}>
                        Rejected
                    </option>
                </select>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded font-semibold">
                Update Status
            </button>
        </form>

        <a href="{{ route('admin.custom-requests.index') }}"
           class="inline-block mt-4 bg-gray-600 text-white px-4 py-2 rounded">
            Kembali
        </a>
    </div>

</div>

@endsection