@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')

<div class="bg-white rounded-xl shadow p-6 max-w-3xl">

    <h3 class="text-xl font-bold mb-6">Form Tambah Produk</h3>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block font-semibold mb-1">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border rounded p-2">

                @error('name')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">Kategori</label>
                <input type="text" name="category" value="{{ old('category') }}"
                       class="w-full border rounded p-2">

                @error('category')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">Spesifikasi</label>
                <input type="text" name="specification" value="{{ old('specification') }}"
                       class="w-full border rounded p-2"
                       placeholder="Contoh: 60x20 cm, S-6, 3 cm">

                @error('specification')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">Satuan</label>
                <input type="text" name="unit" value="{{ old('unit') }}"
                       class="w-full border rounded p-2"
                       placeholder="pcs, lembar, meter">

                @error('unit')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">Harga</label>
                <input type="number" name="price" value="{{ old('price') }}"
                       class="w-full border rounded p-2">

                @error('price')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">Stok</label>
                <input type="number" name="stock" value="{{ old('stock') }}"
                       class="w-full border rounded p-2">

                @error('stock')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mt-4">
            <label class="block font-semibold mb-1">Gambar Produk</label>

            <input type="file"
                   name="image"
                   accept="image/*"
                   class="w-full border rounded p-2">

            <p class="text-sm text-gray-500 mt-1">
                Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
            </p>

            @error('image')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="description"
                      class="w-full border rounded p-2"
                      rows="4">{{ old('description') }}</textarea>

            @error('description')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded font-semibold">
                Simpan
            </button>

            <a href="{{ route('admin.products.index') }}"
               class="bg-gray-600 text-white px-5 py-2 rounded">
                Batal
            </a>
        </div>

    </form>

</div>

@endsection