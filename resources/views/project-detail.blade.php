<!DOCTYPE html>
<html>
<head>
    <title>{{ $project->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

    <img src="{{ $project->image }}"
         class="rounded mb-6 w-full h-64 object-cover">

    <h1 class="text-3xl font-bold mb-4">
        {{ $project->name }}
    </h1>

    <p class="text-gray-600 mb-6">
        {{ $project->description }}
    </p>

    <h2 class="text-2xl font-bold mb-4">
        Daftar Bahan
    </h2>

    <div class="space-y-4">

        @php
            $total = 0;
        @endphp

        @foreach ($project->products as $product)

        @php
            $subtotal = $product->price * $product->pivot->quantity;
            $total += $subtotal;
        @endphp

        <div class="border p-4 rounded">

            <h3 class="font-bold text-lg">
                {{ $product->name }}
            </h3>

            <p>
                Jumlah:
                {{ $product->pivot->quantity }}
                {{ $product->unit }}
            </p>

            <p>
                Harga:
                Rp {{ number_format($product->price) }}
            </p>

            <p class="font-bold">
                Subtotal:
                Rp {{ number_format($subtotal) }}
            </p>

        </div>

        @endforeach

    </div>

    <div class="mt-8 text-right">

        <h2 class="text-2xl font-bold">
            Estimasi Total:
            Rp {{ number_format($total) }}
        </h2>

    </div>

</div>

</body>
</html>