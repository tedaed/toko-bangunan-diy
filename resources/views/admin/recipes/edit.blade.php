@extends('layouts.admin')

@section('title', 'Edit Resep DIY')
@section('page-title', 'Edit Resep DIY')

@section('content')

    <div class="bg-white rounded-xl shadow p-6 max-w-3xl">

        <h3 class="text-xl font-bold mb-6">Form Edit Resep DIY</h3>

        <form action="{{ route('admin.recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-1">Project DIY</label>
                <select name="project_id" class="w-full border rounded p-2">
                    <option value="">-- Pilih Project --</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}"
                            {{ old('project_id', $recipe->project_id) == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>

                @error('project_id')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Nama Resep</label>
                <input type="text" name="name" value="{{ old('name', $recipe->name) }}"
                    class="w-full border rounded p-2">

                @error('name')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block font-semibold mb-1">Panjang (cm)</label>
                    <input type="number" name="length" value="{{ old('length', $recipe->length) }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Lebar (cm)</label>
                    <input type="number" name="width" value="{{ old('width', $recipe->width) }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Tinggi (cm)</label>
                    <input type="number" name="height" value="{{ old('height', $recipe->height) }}"
                        class="w-full border rounded p-2">
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Upload Gambar</label>

                @if ($recipe->image)
                    <div class="mb-3">
                        <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>

                        @if (str_starts_with($recipe->image, 'http'))
                            <img src="{{ $recipe->image }}" class="w-32 h-32 object-cover rounded border">
                        @else
                            <img src="{{ asset('storage/' . $recipe->image) }}"
                                class="w-32 h-32 object-cover rounded border">
                        @endif
                    </div>
                @endif

                <input type="file" name="image" accept="image/*" class="w-full border rounded p-2 bg-white">

                <p class="text-sm text-gray-500 mt-1">
                    Kosongkan jika tidak ingin mengganti gambar.
                </p>

                @error('image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border rounded p-2">{{ old('description', $recipe->description) }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded font-semibold">
                    Update
                </button>

                <a href="{{ route('admin.recipes.index') }}" class="bg-gray-600 text-white px-5 py-2 rounded">
                    Batal
                </a>
            </div>

        </form>

    </div>

@endsection
