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
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">

                    @error('name')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Kategori</label>
                    <select name="category" class="w-full border rounded p-2">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Material DIY" {{ old('category') == 'Material DIY' ? 'selected' : '' }}>Material DIY
                        </option>
                        <option value="Aksesoris Bangunan" {{ old('category') == 'Aksesoris Bangunan' ? 'selected' : '' }}>
                            Aksesoris Bangunan</option>
                        <option value="Fastener" {{ old('category') == 'Fastener' ? 'selected' : '' }}>Fastener</option>
                        <option value="Aksesoris Etalase" {{ old('category') == 'Aksesoris Etalase' ? 'selected' : '' }}>
                            Aksesoris Etalase</option>
                        <option value="Aksesoris Perabot" {{ old('category') == 'Aksesoris Perabot' ? 'selected' : '' }}>
                            Aksesoris Perabot</option>
                        <option value="Perekat" {{ old('category') == 'Perekat' ? 'selected' : '' }}>Perekat</option>
                        <option value="Alat Pendukung" {{ old('category') == 'Alat Pendukung' ? 'selected' : '' }}>Alat
                            Pendukung</option>
                    </select>

                    @error('category')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Jenis Material</label>
                    <select name="material_type" class="w-full border rounded p-2">
                        <option value="">-- Pilih Jenis Material --</option>
                        <option value="kayu" {{ old('material_type') == 'kayu' ? 'selected' : '' }}>Kayu</option>
                        <option value="besi" {{ old('material_type') == 'besi' ? 'selected' : '' }}>Besi</option>
                        <option value="kaca" {{ old('material_type') == 'kaca' ? 'selected' : '' }}>Kaca</option>
                        <option value="fastener" {{ old('material_type') == 'fastener' ? 'selected' : '' }}>Fastener
                        </option>
                        <option value="aksesoris" {{ old('material_type') == 'aksesoris' ? 'selected' : '' }}>Aksesoris
                        </option>
                        <option value="perekat" {{ old('material_type') == 'perekat' ? 'selected' : '' }}>Perekat</option>
                    </select>

                    @error('material_type')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Spesifikasi</label>
                    <input type="text" name="specification" value="{{ old('specification') }}"
                        class="w-full border rounded p-2" placeholder="Contoh: 60x20 cm, S-6, 3 cm">

                    @error('specification')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Panjang (cm)</label>
                    <input type="number" step="0.01" name="length_cm" value="{{ old('length_cm') }}"
                        class="w-full border rounded p-2" placeholder="Contoh: 100">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Lebar (cm)</label>
                    <input type="number" step="0.01" name="width_cm" value="{{ old('width_cm') }}"
                        class="w-full border rounded p-2" placeholder="Contoh: 30">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Ketebalan (cm)</label>
                    <input type="number" step="0.01" name="thickness_cm" value="{{ old('thickness_cm') }}"
                        class="w-full border rounded p-2" placeholder="Contoh: 2">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Diameter (mm)</label>
                    <input type="number" step="0.01" name="diameter_mm" value="{{ old('diameter_mm') }}"
                        class="w-full border rounded p-2" placeholder="Contoh: 6">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Ukuran Inch</label>
                    <input type="number" step="0.01" name="size_inch" value="{{ old('size_inch') }}"
                        class="w-full border rounded p-2" placeholder="Contoh: 1.5">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Satuan</label>
                    <select name="unit" class="w-full border rounded p-2">
                        <option value="">-- Pilih Satuan --</option>
                        <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>pcs</option>
                        <option value="lembar" {{ old('unit') == 'lembar' ? 'selected' : '' }}>lembar</option>
                        <option value="batang" {{ old('unit') == 'batang' ? 'selected' : '' }}>batang</option>
                        <option value="meter" {{ old('unit') == 'meter' ? 'selected' : '' }}>meter</option>
                        <option value="roll" {{ old('unit') == 'roll' ? 'selected' : '' }}>roll</option>
                        <option value="set" {{ old('unit') == 'set' ? 'selected' : '' }}>set</option>
                        <option value="botol" {{ old('unit') == 'botol' ? 'selected' : '' }}>botol</option>
                    </select>

                    @error('unit')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Harga</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="w-full border rounded p-2">

                    @error('price')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" class="w-full border rounded p-2">

                    @error('stock')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            
            <div class="flex justify-end gap-3 mt-6 pt-5 border-t">
                <a href="{{ route('admin.products.index') }}"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                    Batal
                </a>

                <button type="submit"
                    class="px-5 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                    Simpan Produk
                </button>
            </div>

        </form>


    </div>

@endsection
