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

            @if (!empty($ruleBasedResult) && !empty($ruleBasedResult['rules']))
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded">
                    <p class="font-bold mb-2">Rekomendasi Material</p>

                    <p class="text-sm mb-3">
                        Rekomendasi dihitung berdasarkan bahan utama:
                        <span class="font-semibold">
                            {{ $ruleBasedResult['main_product']['name'] ?? '-' }}
                            -
                            {{ $ruleBasedResult['main_product']['specification'] ?? '-' }}
                        </span>
                    </p>

                    <div class="mt-3">
                        <p class="font-semibold mb-1">Detail Aturan Sistem:</p>

                        <div class="text-sm space-y-1">
                            @foreach ($ruleBasedResult['rules'] as $rule)
                                <div>
                                    <span class="font-semibold">{{ $rule['code'] }}</span>:
                                    {{ $rule['if'] }}
                                    →
                                    {{ $rule['then'] }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

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

                            @if (!empty($item['is_rule_recommended_product']))
                                <p class="text-blue-600 font-semibold mt-2">
                                    ⭐ Direkomendasikan oleh sistem untuk proyek ini.
                                </p>
                            @endif

                            @if (!empty($item['minimum_rule_quantity']))
                                <p class="text-sm text-gray-600 mt-1">
                                    Jumlah minimum yang disarankan:
                                    {{ $item['minimum_rule_quantity'] }}
                                    {{ $item['product']->unit }}
                                </p>
                            @endif

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

                @php
                    $hasStockIssue = collect($items)->contains(function ($item) {
                        return !$item['stock_enough'];
                    });
                @endphp

                <div class="mt-6 flex flex-wrap gap-3">

                    @if ($hasStockIssue)
                        <div class="w-full bg-red-100 border border-red-300 text-red-700 p-4 rounded">
                            <p class="font-bold">Checkout tidak dapat dilanjutkan.</p>
                            <p>
                                Terdapat produk dengan stok kosong atau stok kurang dari jumlah yang Anda pilih.
                                Silakan kurangi quantity atau ubah pilihan produk.
                            </p>
                        </div>
                    @else
                        <a href="{{ route('checkout.create') }}"
                            class="inline-flex items-center justify-center bg-green-600 text-white px-4 py-2 rounded font-semibold hover:bg-green-700">
                            Lanjut Checkout
                        </a>
                    @endif

                    <a href="{{ route('diy.recipe', $recipe->id) }}"
                        class="inline-flex items-center justify-center bg-gray-600 text-white px-4 py-2 rounded font-semibold hover:bg-gray-700">
                        Kembali Ubah Pilihan
                    </a>
                </div>
            @endif

        </div>
    </div>

@endsection