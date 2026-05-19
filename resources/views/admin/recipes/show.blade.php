@extends('layouts.admin')

@section('title', 'Kelola Komponen Resep')
@section('page-title', 'Kelola Komponen Resep')

@section('content')

    <div class="mb-6 bg-white rounded-xl shadow p-6">
        <h3 class="text-2xl font-bold">
            {{ $recipe->name }}
        </h3>

        <p class="text-gray-600 mt-1">
            Project: {{ $recipe->project->name }}
        </p>

        <p class="text-gray-600">
            Ukuran:
            {{ $recipe->length ?? '-' }} x {{ $recipe->width ?? '-' }}
            @if ($recipe->height)
                x {{ $recipe->height }}
            @endif
            cm
        </p>

        <a href="{{ route('admin.recipes.index') }}" class="inline-block mt-4 bg-gray-600 text-white px-4 py-2 rounded">
            Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

            @forelse($recipe->components as $component)
                <div class="bg-white rounded-xl shadow p-6">

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="text-xl font-bold">
                                {{ $component->component_name }}
                            </h4>

                            <p class="text-sm text-gray-500">
                                {{ ucfirst($component->component_type) }}
                                -
                                {{ $component->is_required ? 'Wajib' : 'Opsional' }}
                            </p>
                        </div>

                        <form action="{{ route('admin.recipe-components.destroy', $component->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus komponen ini?')">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-600 text-white px-3 py-1 rounded">
                                Hapus Komponen
                            </button>
                        </form>
                    </div>

                    <h5 class="font-bold mb-3">Opsi Produk</h5>

                    <div class="space-y-3 mb-6">
                        @forelse($component->options as $option)
                            <div class="border rounded p-4 flex items-center justify-between">
                                <div>
                                    <p class="font-semibold">
                                        {{ $option->product->name }}
                                        -
                                        {{ $option->product->specification }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Rekomendasi:
                                        {{ $option->recommended_quantity }}
                                        {{ $option->product->unit }}
                                        |
                                        Harga:
                                        Rp {{ number_format($option->product->price, 0, ',', '.') }}
                                        |
                                        Stok:
                                        {{ $option->product->stock }}
                                    </p>

                                    @if ($option->is_default)
                                        <span
                                            class="inline-block mt-2 bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs font-bold">
                                            Default
                                        </span>
                                    @endif
                                </div>

                                <form action="{{ route('admin.component-options.destroy', $option->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus opsi ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="bg-red-600 text-white px-3 py-1 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-500">
                                Belum ada opsi produk untuk komponen ini.
                            </p>
                        @endforelse
                    </div>

                    <form action="{{ route('admin.component-options.store', $component->id) }}" method="POST"
                        class="border-t pt-4">
                        @csrf

                        <h5 class="font-bold mb-3">Tambah Opsi Produk</h5>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-sm font-semibold mb-1">
                                    Produk
                                </label>

                                @php
                                    $filteredProducts = $products->filter(function ($product) use ($component) {
                                        return str_contains(
                                            strtolower($product->name),
                                            strtolower($component->component_name),
                                        );
                                    });

                                    if ($filteredProducts->isEmpty()) {
                                        $filteredProducts = $products;
                                    }
                                @endphp

                                <select name="product_id" class="w-full border rounded p-2">
                                    <option value="">-- Pilih Produk --</option>

                                    @foreach ($filteredProducts as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }}
                                            -
                                            {{ $product->specification }}
                                            |
                                            Stok: {{ $product->stock }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-1">
                                    Quantity Rekomendasi
                                </label>

                                <input type="number" name="recommended_quantity" min="1"
                                    class="w-full border rounded p-2">
                            </div>

                            <div class="flex items-end">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="is_default" value="1">
                                    Jadikan default
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                            Tambah Opsi
                        </button>
                    </form>

                </div>
            @empty
                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-gray-500">
                        Belum ada komponen pada resep ini.
                    </p>
                </div>
            @endforelse

        </div>

        <div class="bg-white rounded-xl shadow p-6 h-fit">
            <h4 class="text-xl font-bold mb-4">Tambah Komponen</h4>

            <form action="{{ route('admin.recipe-components.store', $recipe->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold mb-1">
                        Nama Komponen
                    </label>

                    <input type="text" name="component_name" class="w-full border rounded p-2"
                        placeholder="Contoh: Sekrup, Papan Kayu, Fisher">

                    @error('component_name')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">
                        Tipe Komponen
                    </label>

                    <select name="component_type" class="w-full border rounded p-2">
                        <option value="utama">Utama</option>
                        <option value="pelengkap">Pelengkap</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_required" value="1" checked>
                        Komponen wajib
                    </label>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Tambah Komponen
                </button>
            </form>
        </div>

    </div>

@endsection
