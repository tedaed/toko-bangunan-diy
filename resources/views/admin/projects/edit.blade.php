@extends('layouts.admin')

@section('title', 'Edit Project DIY')
@section('page-title', 'Edit Project DIY')

@section('content')

<div class="bg-white rounded-xl shadow p-6 max-w-3xl">

    <h3 class="text-xl font-bold mb-6">Form Edit Project DIY</h3>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1">
                Nama Project <span class="text-red-600">*</span>
            </label>

            <input type="text"
                   name="name"
                   value="{{ old('name', $project->name) }}"
                   class="w-full border rounded p-2"
                   placeholder="Contoh: Meja Makan">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">
                Deskripsi <span class="text-red-600">*</span>
            </label>

            <textarea name="description"
                      class="w-full border rounded p-2"
                      rows="4"
                      placeholder="Contoh: Project DIY untuk membuat meja makan sederhana.">{{ old('description', $project->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">
                Upload Gambar
            </label>

            @if ($project->image)
                <div class="mb-3">
                    <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>

                    @if (str_starts_with($project->image, 'http'))
                        <img src="{{ $project->image }}"
                             class="w-32 h-32 object-cover rounded border">
                    @else
                        <img src="{{ asset('storage/' . $project->image) }}"
                             class="w-32 h-32 object-cover rounded border">
                    @endif
                </div>
            @endif

            <input type="file"
                   name="image"
                   accept="image/*"
                   class="w-full border rounded p-2 bg-white">

            <p class="text-sm text-gray-500 mt-1">
                Kosongkan jika tidak ingin mengganti gambar. Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
            </p>
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded font-semibold hover:bg-blue-700">
            Update Project
        </button>

        <a href="{{ route('admin.projects.index') }}"
           class="inline-block ml-2 bg-gray-600 text-white px-5 py-2 rounded">
            Kembali
        </a>
    </form>

</div>

@endsection