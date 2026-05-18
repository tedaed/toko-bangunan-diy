<!DOCTYPE html>
<html>
<head>
    <title>{{ $recipe->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="bg-blue-600 text-white p-10 text-center">
    <h1 class="text-4xl font-bold">{{ $recipe->name }}</h1>
    <p class="mt-4">{{ $recipe->description }}</p>
</div>

<div class="p-10">
    <div class="bg-white rounded shadow p-6 max-w-4xl mx-auto">

        <h2 class="text-2xl font-bold mb-6">Pilih Komponen</h2>

        <form action="{{ route('diy.calculate', $recipe->id) }}" method="POST">
            @csrf

            <div class="space-y-6">
                @foreach ($recipe->components as $component)
                    @php
                        $defaultOption = $component->options->where('is_default', true)->first() ?? $component->options->first();
                    @endphp

                    <div class="border rounded p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h3 class="font-bold text-lg">
                                    {{ $component->component_name }}
                                </h3>

                                <p class="text-sm text-gray-500">
                                    {{ ucfirst($component->component_type) }}
                                    -
                                    {{ $component->is_required ? 'Direkomendasikan' : 'Opsional' }}
                                </p>
                            </div>

                            <label class="flex items-center gap-2">
                                <input type="checkbox"
                                       name="components[{{ $component->id }}][selected]"
                                       value="1"
                                       checked>
                                Pilih
                            </label>
                        </div>

                        <label class="block text-sm font-semibold mb-1">
                            Pilihan Produk
                        </label>

                        <select name="components[{{ $component->id }}][option_id]"
                                class="w-full border rounded p-2 mb-3">
                            @foreach ($component->options as $option)
                                <option value="{{ $option->id }}"
                                        {{ $option->is_default ? 'selected' : '' }}>
                                    {{ $option->product->name }}
                                    -
                                    {{ $option->product->specification }}
                                    |
                                    Rp {{ number_format($option->product->price, 0, ',', '.') }}
                                    |
                                    Stok: {{ $option->product->stock }}
                                </option>
                            @endforeach
                        </select>

                        <label class="block text-sm font-semibold mb-1">
                            Quantity
                        </label>

                        <input type="number"
                               name="components[{{ $component->id }}][quantity]"
                               value="{{ $defaultOption ? $defaultOption->recommended_quantity : 1 }}"
                               min="1"
                               class="w-full border rounded p-2">
                    </div>
                @endforeach
            </div>

            <button type="submit"
                    class="mt-6 bg-green-600 text-white px-6 py-3 rounded font-bold">
                Hitung Estimasi
            </button>
        </form>

    </div>
</div>

</body>
</html>