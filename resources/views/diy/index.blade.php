@extends('layouts.customer')

@section('title', 'Panduan DIY')

@section('content')

<div class="bg-blue-600 text-white py-16 text-center">
    <h1 class="text-4xl font-bold">
        Panduan DIY
    </h1>
    <p class="mt-4 text-lg">
        Pilih proyek DIY yang ingin Anda buat
    </p>
</div>

<div class="max-w-7xl mx-auto px-6 py-10">
    <h2 class="text-2xl font-bold mb-6">
        Project DIY Tersedia
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach ($projects as $project)
            <div class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition">
                <img src="{{ $project->image }}"
                     class="rounded-lg mb-4 w-full h-40 object-cover">

                <h2 class="font-bold text-lg">
                    {{ $project->name }}
                </h2>

                <p class="text-gray-600 text-sm mt-2">
                    {{ $project->description }}
                </p>

                <p class="text-sm text-gray-500 mt-3">
                    {{ $project->recipes_count }} resep tersedia
                </p>

                <a href="{{ route('diy.project', $project->id) }}"
                   class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Pilih Project
                </a>
            </div>
        @endforeach
    </div>
</div>

@endsection