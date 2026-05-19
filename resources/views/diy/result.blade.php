@extends('layouts.customer')

@section('title', 'Hasil Estimasi')

@section('content')

<div class="bg-blue-600 text-white py-16 text-center">
    <h1 class="text-4xl font-bold">Hasil Estimasi</h1>
    <p class="mt-4">{{ $recipe->name }}</p>
</div>

<div class="max-w-4xl mx-auto px-6 py-10">
    <div class="bg-white rounded-xl shadow p-6">

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

            <div class="mt-6 flex gap-3">
                <a href="{{ route('checkout.create') }}"
                   class="inline-block bg-green-600 text-white px-6 py-3 rounded font-bold hover:bg-green-700">
                    Lanjut Checkout
                </a>

                <a href="{{ route('diy.recipe', $recipe->id) }}"
                   class="inline-block bg-gray-600 text-white px-6 py-3 rounded font-bold hover:bg-gray-700">
                    Kembali Ubah Pilihan
                </a>
            </div>

        @endif

    </div>
</div>

@endsection