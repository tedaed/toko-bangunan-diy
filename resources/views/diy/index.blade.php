<!DOCTYPE html>
<html>
<head>
    <title>Panduan DIY</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="bg-blue-600 text-white p-10 text-center">
    <h1 class="text-4xl font-bold">Panduan DIY</h1>
    <p class="mt-4">Pilih proyek DIY yang ingin Anda buat</p>
</div>

<div class="p-10">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach ($projects as $project)
            <div class="bg-white rounded shadow p-4">
                <img src="{{ $project->image }}" class="rounded mb-4">

                <h2 class="font-bold text-lg">{{ $project->name }}</h2>

                <p class="text-gray-600 text-sm mt-2">
                    {{ $project->description }}
                </p>

                <p class="text-sm text-gray-500 mt-2">
                    {{ $project->recipes_count }} resep tersedia
                </p>

                <a href="{{ route('diy.project', $project->id) }}"
                   class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                    Pilih Project
                </a>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>