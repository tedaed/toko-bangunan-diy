<!DOCTYPE html>
<html>
<head>
    <title>DIY Bangunan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="bg-blue-600 text-white p-10 text-center">
    <h1 class="text-4xl font-bold">
        DIY Bangunan by Toko Anugrah Jaya
    </h1>

    <p class="mt-4">
        Temukan proyek DIY dan bahan yang dibutuhkan
    </p>
</div>

<div class="p-10">

    <h2 class="text-2xl font-bold mb-6">
        Project DIY
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach ($projects as $project)

        <div class="bg-white rounded shadow p-4">

    <img src="{{ $project->image }}"
         class="rounded mb-4">

    <h3 class="font-bold text-lg">
        {{ $project->name }}
    </h3>

    <p class="text-gray-600">
        {{ $project->description }}
    </p>

    <a href="/projects/{{ $project->id }}"
       class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded">
       Lihat Detail
    </a>

</div>

        @endforeach

    </div>

</div>

</body>
</html>