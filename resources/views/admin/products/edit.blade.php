@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')

    <div class="bg-white rounded-xl shadow p-6 max-w-3xl">

        <h3 class="text-xl font-bold mb-6">Form Edit Produk</h3>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block font-semibold mb-1">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                        class="w-full border rounded p-2">
                    @error('name')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Kategori</label>
                    <input type="text" name="category" value="{{ old('category', $product->category) }}"
                        class="w-full border rounded p-2">
                    @error('category')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Spesifikasi</label>
                    <input type="text" name="specification" value="{{ old('specification', $product->specification) }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Satuan</label>
                    <input type="text" name="unit" value="{{ old('unit', $product->unit) }}"
                        class="w-full border rounded p-2">
                    @error('unit')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Harga</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}"
                        class="w-full border rounded p-2">
                    @error('price')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                        class="w-full border rounded p-2">
                    @error('stock')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-4">
                <label class="block font-semibold mb-1">Upload Gambar</label>

                @if ($product->image)
                    <div class="mb-3">
                        <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>

                        @if (str_starts_with($product->image, 'http'))
                            <img src="{{ $product->image }}" class="w-32 h-32 object-cover rounded border">
                        @else
                            <img src="{{ asset('storage/' . $product->image) }}"
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

            <div class="mt-4">
                <label class="block font-semibold mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border rounded p-2" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded font-semibold">
                    Update
                </button>

                <a href="{{ route('admin.products.index') }}" class="bg-gray-600 text-white px-5 py-2 rounded">
                    Batal
                </a>
            </div>

        </form>

    </div>

@endsection
