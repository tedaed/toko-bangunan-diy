<!DOCTYPE html>
<html>
<head>
    <title>{{ $project->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="bg-blue-600 text-white p-10 text-center">
    <h1 class="text-4xl font-bold">{{ $project->name }}</h1>
    <p class="mt-4">{{ $project->description }}</p>
</div>

<div class="p-10">
    <h2 class="text-2xl font-bold mb-6">Pilih Ukuran / Resep</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($project->recipes as $recipe)
            <div class="bg-white rounded shadow p-4">
                <img src="{{ $recipe->image }}" class="rounded mb-4">

                <h3 class="font-bold text-lg">{{ $recipe->name }}</h3>

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
                   class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                    Lihat Resep
                </a>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>