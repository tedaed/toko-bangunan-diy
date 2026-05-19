@extends('layouts.customer')

@section('title', 'Permintaan Terkirim')

@section('content')

<div class="max-w-3xl mx-auto px-6 py-12">

    <div class="bg-white rounded-xl shadow p-8 text-center">

        <div class="text-green-600 text-5xl mb-4">✓</div>

        <h1 class="text-3xl font-bold mb-4">
            Permintaan Custom Berhasil Dikirim
        </h1>

        <p class="text-gray-600 mb-6">
            Permintaan Anda akan ditinjau oleh admin Toko Bangunan XYZ.
        </p>

        <div class="text-left bg-gray-100 rounded p-4 mb-6">
            <p><strong>Nama:</strong> {{ $customRequest->customer_name }}</p>
            <p><strong>WhatsApp:</strong> {{ $customRequest->phone }}</p>
            <p><strong>Project:</strong> {{ $customRequest->project->name ?? '-' }}</p>
            <p>
                <strong>Ukuran:</strong>
                {{ $customRequest->length ?? '-' }}
                x
                {{ $customRequest->width ?? '-' }}
                @if($customRequest->height)
                    x {{ $customRequest->height }}
                @endif
                cm
            </p>
            <p><strong>Status:</strong> {{ strtoupper($customRequest->status) }}</p>
        </div>

        <a href="{{ route('diy.index') }}"
           class="bg-blue-600 text-white px-5 py-2 rounded">
            Kembali ke Panduan DIY
        </a>

    </div>

</div>

@endsection