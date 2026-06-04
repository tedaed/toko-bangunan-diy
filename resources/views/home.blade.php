@extends('layouts.customer')

@section('title', 'Beranda - Toko Bangunan XYZ')

@section('content')

    <div class="bg-blue-600 text-white py-20 text-center">
        <h1 class="text-4xl md:text-5xl font-bold">
            DIY Bangunan by Toko Bangunan XYZ
        </h1>

        <p class="mt-4 text-lg">
            Temukan proyek DIY dan bahan yang dibutuhkan sesuai kebutuhan Anda
        </p>

        <a href="{{ route('catalog.index') }}"
            class="inline-block mt-6 bg-white text-blue-600 px-6 py-3 rounded font-bold hover:bg-gray-100">
            Lihat Katalog Produk
        </a>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">
                Project DIY
            </h2>

            <a href="{{ route('diy.index') }}" class="text-blue-600 font-semibold hover:underline">
                Lihat Semua
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            @foreach ($projects as $project)
                <div class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition">

                    @if ($project->image)
                        @if (str_starts_with($project->image, 'http'))
                            <img src="{{ $project->image }}" class="rounded-lg mb-4 w-full h-40 object-cover"
                                alt="{{ $project->name }}">
                        @else
                            <img src="{{ asset('storage/' . $project->image) }}"
                                class="rounded-lg mb-4 w-full h-40 object-cover" alt="{{ $project->name }}">
                        @endif
                    @else
                        <div
                            class="rounded-lg mb-4 w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                            Tidak ada gambar
                        </div>
                    @endif

                    <h3 class="font-bold text-lg">
                        {{ $project->name }}
                    </h3>

                    <p class="text-gray-600 text-sm mt-2">
                        {{ $project->description }}
                    </p>

                    <p class="text-sm text-gray-500 mt-3">
                        {{ $project->recipes_count }} resep tersedia
                    </p>

                    <a href="{{ route('diy.project', $project->id) }}"
                        class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Lihat Detail
                    </a>

                </div>
            @endforeach

        </div>

    </div>

@endsection
