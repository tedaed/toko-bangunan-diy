<!DOCTYPE html>
<html>
<head>
    <title>Hasil Estimasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="bg-blue-600 text-white p-10 text-center">
    <h1 class="text-4xl font-bold">Hasil Estimasi</h1>
    <p class="mt-4">{{ $recipe->name }}</p>
</div>

<div class="p-10">
    <div class="bg-white rounded shadow p-6 max-w-4xl mx-auto">

        <h2 class="text-2xl font-bold mb-6">Rincian Belanja</h2>

        @if (count($items) == 0)
            <p class="text-gray-600">Belum ada komponen yang dipilih.</p>
        @else
            <div class="space-y-4">
                @foreach ($items as $item)
                    <div class="border rounded p-4">
                        <h3 class="font-bold text-lg">
                            {{ $item['product']->name }}
                            -
                            {{ $item['product']->specification }}
                        </h3>

                        <p class="text-gray-600">
                            Komponen: {{ $item['component_name'] }}
                        </p>

                        <p>
                            Quantity:
                            {{ $item['quantity'] }}
                            {{ $item['product']->unit }}
                        </p>

                        <p>
                            Harga:
                            Rp {{ number_format($item['product']->price, 0, ',', '.') }}
                        </p>

                        <p class="font-bold">
                            Subtotal:
                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </p>

                        @if ($item['stock_enough'])
                            <p class="text-green-600 font-bold mt-2">
                                Stok tersedia
                            </p>
                        @else
                            <p class="text-red-600 font-bold mt-2">
                                Stok kurang! Dibutuhkan {{ $item['quantity'] }},
                                tersedia {{ $item['product']->stock }}.
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-right">
                <h2 class="text-2xl font-bold">
                    Total Estimasi:
                    Rp {{ number_format($total, 0, ',', '.') }}
                </h2>
            </div>
        @endif

        <a href="{{ route('diy.recipe', $recipe->id) }}"
           class="inline-block mt-6 bg-gray-600 text-white px-4 py-2 rounded">
            Kembali Ubah Pilihan
        </a>

    </div>
</div>

</body>
</html>