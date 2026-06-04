@extends('layouts.admin')

@section('title', 'Tambah Project DIY')
@section('page-title', 'Tambah Project DIY')

@section('content')

    <div class="bg-white rounded-xl shadow p-6 max-w-3xl">

        <h3 class="text-xl font-bold mb-6">Form Tambah Project DIY</h3>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Nama Project <span class="text-red-600">*</span>
                </label>

                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2"
                    placeholder="Contoh: Meja Makan">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Deskripsi <span class="text-red-600">*</span>
                </label>

                <textarea name="description" class="w-full border rounded p-2" rows="4"
                    placeholder="Contoh: Project DIY untuk membuat meja makan sederhana.">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Upload Gambar
                </label>

                <input type="file" name="image" accept="image/*" class="w-full border rounded p-2 bg-white">

                <p class="text-sm text-gray-500 mt-1">
                    Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                </p>
            </div>

            <input type="text" name="image" value="{{ old('image') }}" class="w-full border rounded p-2"
                placeholder="Opsional, contoh: https://via.placeholder.com/300">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded font-semibold hover:bg-blue-700">
        Simpan Project
    </button>

    <a href="{{ route('admin.projects.index') }}" class="inline-block ml-2 bg-gray-600 text-white px-5 py-2 rounded">
        Kembali
    </a>
    </form>

    </div>

@endsection
