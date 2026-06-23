@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')

    <div class="bg-white rounded-xl shadow p-6 max-w-3xl">

        <h3 class="text-xl font-bold mb-6">Form Edit Produk</h3>
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-300 text-red-700 p-4 rounded">
                <p class="font-bold mb-2">Produk belum berhasil diperbarui:</p>

                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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
                    <select name="category" class="w-full border rounded p-2">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Material DIY"
                            {{ old('category', $product->category) == 'Material DIY' ? 'selected' : '' }}>Material DIY
                        </option>
                        <option value="Aksesoris Bangunan"
                            {{ old('category', $product->category) == 'Aksesoris Bangunan' ? 'selected' : '' }}>Aksesoris
                            Bangunan</option>
                        <option value="Fastener" {{ old('category', $product->category) == 'Fastener' ? 'selected' : '' }}>
                            Fastener</option>
                        <option value="Aksesoris Etalase"
                            {{ old('category', $product->category) == 'Aksesoris Etalase' ? 'selected' : '' }}>Aksesoris
                            Etalase</option>
                        <option value="Aksesoris Perabot"
                            {{ old('category', $product->category) == 'Aksesoris Perabot' ? 'selected' : '' }}>Aksesoris
                            Perabot</option>
                        <option value="Perekat" {{ old('category', $product->category) == 'Perekat' ? 'selected' : '' }}>
                            Perekat</option>
                        <option value="Alat Pendukung"
                            {{ old('category', $product->category) == 'Alat Pendukung' ? 'selected' : '' }}>Alat Pendukung
                        </option>
                    </select>

                    @error('category')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Jenis Material</label>
                    <select name="material_type" class="w-full border rounded p-2">
                        <option value="">-- Pilih Jenis Material --</option>
                        <option value="kayu"
                            {{ old('material_type', $product->material_type) == 'kayu' ? 'selected' : '' }}>Kayu</option>
                        <option value="besi"
                            {{ old('material_type', $product->material_type) == 'besi' ? 'selected' : '' }}>Besi</option>
                        <option value="kaca"
                            {{ old('material_type', $product->material_type) == 'kaca' ? 'selected' : '' }}>Kaca</option>
                        <option value="fastener"
                            {{ old('material_type', $product->material_type) == 'fastener' ? 'selected' : '' }}>Fastener
                        </option>
                        <option value="aksesoris"
                            {{ old('material_type', $product->material_type) == 'aksesoris' ? 'selected' : '' }}>Aksesoris
                        </option>
                        <option value="perekat"
                            {{ old('material_type', $product->material_type) == 'perekat' ? 'selected' : '' }}>Perekat
                        </option>
                    </select>

                    @error('material_type')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Spesifikasi</label>
                    <input type="text" name="specification" value="{{ old('specification', $product->specification) }}"
                        class="w-full border rounded p-2" placeholder="Contoh: 60x20 cm, S-6, 3 cm">

                    @error('specification')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Panjang (cm)</label>
                    <input type="number" step="0.01" name="length_cm"
                        value="{{ old('length_cm', $product->length_cm) }}" class="w-full border rounded p-2"
                        placeholder="Contoh: 100">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Lebar (cm)</label>
                    <input type="number" step="0.01" name="width_cm" value="{{ old('width_cm', $product->width_cm) }}"
                        class="w-full border rounded p-2" placeholder="Contoh: 30">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Ketebalan (cm)</label>
                    <input type="number" step="0.01" name="thickness_cm"
                        value="{{ old('thickness_cm', $product->thickness_cm) }}" class="w-full border rounded p-2"
                        placeholder="Contoh: 2">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Diameter (mm)</label>
                    <input type="number" step="0.01" name="diameter_mm"
                        value="{{ old('diameter_mm', $product->diameter_mm) }}" class="w-full border rounded p-2"
                        placeholder="Contoh: 6">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Ukuran Inch</label>
                    <input type="number" step="0.01" name="size_inch"
                        value="{{ old('size_inch', $product->size_inch) }}" class="w-full border rounded p-2"
                        placeholder="Contoh: 1.5">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Satuan</label>
                    <select name="unit" class="w-full border rounded p-2">
                        <option value="">-- Pilih Satuan --</option>
                        <option value="pcs" {{ old('unit', $product->unit) == 'pcs' ? 'selected' : '' }}>pcs</option>
                        <option value="lembar" {{ old('unit', $product->unit) == 'lembar' ? 'selected' : '' }}>lembar
                        </option>
                        <option value="batang" {{ old('unit', $product->unit) == 'batang' ? 'selected' : '' }}>batang
                        </option>
                        <option value="meter" {{ old('unit', $product->unit) == 'meter' ? 'selected' : '' }}>meter
                        </option>
                        <option value="roll" {{ old('unit', $product->unit) == 'roll' ? 'selected' : '' }}>roll</option>
                        <option value="set" {{ old('unit', $product->unit) == 'set' ? 'selected' : '' }}>set</option>
                        <option value="botol" {{ old('unit', $product->unit) == 'botol' ? 'selected' : '' }}>botol
                        </option>
                    </select>

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


                <div class="mt-4">
                    <label class="block font-semibold mb-1">Deskripsi</label>

                    <textarea name="description" rows="4" class="w-full border rounded p-2">{{ old('description', $product->description) }}</textarea>

                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


            </div>
            <div class="mt-4 flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded font-semibold hover:bg-blue-700">
                Update Produk
            </button>

            <a href="{{ route('admin.products.index') }}"
                class="bg-gray-600 text-white px-5 py-2 rounded hover:bg-gray-700">
                Batal
            </a>
        </div>
        </form>
        

    </div>

@endsection
