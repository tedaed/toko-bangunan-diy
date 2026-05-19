@extends('layouts.customer')

@section('title', $project->name)

@section('content')

<div class="bg-blue-600 text-white py-16 text-center">
    <h1 class="text-4xl font-bold">{{ $project->name }}</h1>
    <p class="mt-4">{{ $project->description }}</p>
</div>

<div class="max-w-7xl mx-auto px-6 py-10">

    <h2 class="text-2xl font-bold mb-6">
        Pilih Ukuran / Resep
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($project->recipes as $recipe)
            <div class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition">
                <img src="{{ $recipe->image }}"
                     class="rounded-lg mb-4 w-full h-40 object-cover"
                     alt="{{ $recipe->name }}">

                <h3 class="font-bold text-lg">
                    {{ $recipe->name }}
                </h3>

                <p class="text-gray-600 text-sm mt-2">
                    {{ $recipe->description }}
                </p>

                <p class="text-sm text-gray-500 mt-2">
                    Ukuran:
                    {{ $recipe->length }} x {{ $recipe->width }}
                    @if($recipe->height)
                        x {{ $recipe->height }}
                    @endif
                    cm
                </p>

                <a href="{{ route('diy.recipe', $recipe->id) }}"
                   class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Lihat Resep
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-10 bg-white rounded-xl shadow p-6 text-center">
        <h3 class="text-2xl font-bold">
            Tidak menemukan ukuran yang sesuai?
        </h3>

        <p class="text-gray-600 mt-2">
            Anda dapat mengajukan permintaan custom sesuai ukuran atau kebutuhan khusus.
        </p>

        <a href="{{ route('custom-requests.create', ['project_id' => $project->id]) }}"
           class="inline-block mt-4 bg-green-600 text-white px-6 py-3 rounded font-bold hover:bg-green-700">
            Ajukan Permintaan Custom
        </a>
    </div>

</div>

@endsection