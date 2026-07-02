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

            <div class="mb-6 bg-gray-50 border rounded-lg p-4">

                <label class="block font-bold mb-2">
                    Jumlah Bundling / Set Proyek
                </label>

                <input type="number" id="bundleQty" min="1" value="1" class="w-32 border rounded p-2">

                <p class="text-sm text-gray-500 mt-2">
                    Semua jumlah rekomendasi komponen akan dikalikan sesuai jumlah bundling.
                </p>

            </div>

            <h2 class="text-2xl font-bold mb-6">Pilih Komponen</h2>
            @if (session('required_warning'))
                <div class="mb-6 bg-yellow-100 border border-yellow-300 text-yellow-800 p-4 rounded">
                    <p class="font-bold">Peringatan:</p>
                    <p>{{ session('required_warning') }}</p>
                </div>
            @endif

            <div id="ruleBasedInfo" class="hidden mb-6 bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded">
                <p class="font-bold mb-2">Rekomendasi Rule-Based</p>
                <div id="ruleBasedRules" class="text-sm space-y-1"></div>
            </div>

            <form action="{{ route('diy.calculate', $recipe->id) }}" method="POST">
                @csrf
                <input type="hidden" name="bundle_quantity" id="bundleQuantityHidden" value="1">
                <div class="space-y-6">
                    @forelse ($recipe->components as $component)

                        @continue($component->options->isEmpty())

                        @php
                            $defaultOption =
                                $component->options->where('is_default', true)->first() ?? $component->options->first();
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
                                    @php
                                        $oldComponents = old('components');
                                        $isChecked =
                                            $oldComponents !== null
                                                ? isset($oldComponents[$component->id]['selected'])
                                                : $component->is_required;
                                    @endphp

                                    <input type="checkbox" name="components[{{ $component->id }}][selected]"
                                        value="1" {{ $isChecked ? 'checked' : '' }}>
                                    Pilih
                                </label>
                            </div>

                            <label class="block text-sm font-semibold mb-1">
                                Pilihan Produk
                            </label>

                            <select name="components[{{ $component->id }}][option_id]"
                                data-component-id="{{ $component->id }}"
                                data-component-name="{{ strtolower($component->component_name) }}"
                                class="component-select w-full border rounded p-2 mb-3">
                                @foreach ($component->options as $option)
                                    @php
                                        $optionText =
                                            $option->product->name .
                                            ' - ' .
                                            $option->product->specification .
                                            ' | Rp ' .
                                            number_format($option->product->price, 0, ',', '.') .
                                            ' | Stok: ' .
                                            $option->product->stock;
                                    @endphp

                                    <option value="{{ $option->id }}" data-product-id="{{ $option->product->id }}"
                                        data-original-text="{{ $optionText }}"
                                        {{ $option->is_default ? 'selected' : '' }}>
                                        {{ $optionText }}
                                    </option>
                                @endforeach
                            </select>

                            <label class="block text-sm font-semibold mb-1">
                                Quantity
                            </label>

                            <input type="number" name="components[{{ $component->id }}][quantity]"
                                data-component-id="{{ $component->id }}"
                                data-original-qty="{{ $defaultOption ? $defaultOption->recommended_quantity : 1 }}"
                                value="{{ $defaultOption ? $defaultOption->recommended_quantity : 1 }}" min="1"
                                class="component-qty w-full border rounded p-2">
                            <p id="rule-quantity-{{ $component->id }}"
                                class="hidden mt-1 text-xs font-medium text-blue-600">
                            </p>

                        </div>

                    @empty
                        <div class="bg-yellow-100 text-yellow-700 p-4 rounded">
                            Belum ada komponen produk yang tersedia untuk resep ini.
                        </div>
                    @endforelse
                </div>

                <button type="submit" class="mt-6 bg-green-600 text-white px-6 py-3 rounded font-bold">
                    Hitung Estimasi
                </button>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.component-qty').forEach(function(input) {
                input.addEventListener('input', function() {
                    const ruleMin = parseInt(input.dataset.ruleMin || 0);
                    const currentValue = parseInt(input.value || 1);

                    let warning = input.parentElement.querySelector('.quantity-warning');

                    if (!warning) {
                        warning = document.createElement('p');
                        warning.className = 'quantity-warning text-yellow-600 text-sm mt-1';
                        input.parentElement.appendChild(warning);
                    }

                    if (ruleMin > 0 && currentValue < ruleMin) {
                        warning.textContent =
                            'Peringatan: jumlah ini di bawah rekomendasi sistem untuk proyek lengkap.';
                    } else {
                        warning.textContent = '';
                    }
                });
            });
            const apiUrl = "{{ route('api.rule-recommendations') }}";
            const recipeId = "{{ $recipe->id }}";

            const selects = document.querySelectorAll('.component-select');
            const ruleBox = document.getElementById('ruleBasedInfo');
            const ruleList = document.getElementById('ruleBasedRules');

            function findMainProductSelect() {
                return Array.from(selects).find(function(select) {
                    const name = select.dataset.componentName || '';

                    return name.includes('papan') ||
                        name.includes('kayu') ||
                        name.includes('kaca') ||
                        name.includes('kawat') ||
                        name.includes('hollow') ||
                        name.includes('triplek') ||
                        name.includes('blok');
                });
            }

            function resetOptionLabels() {
                selects.forEach(function(select) {
                    Array.from(select.options).forEach(function(option) {
                        if (option.dataset.originalText) {
                            option.textContent = option.dataset.originalText;
                        }
                    });
                });
            }

            function updateRuleInfo(rules) {
                if (!rules || rules.length === 0) {
                    ruleBox.classList.add('hidden');
                    ruleList.innerHTML = '';
                    return;
                }

                ruleBox.classList.remove('hidden');

                ruleList.innerHTML = rules.map(function(rule) {
                    return `
                        <div>
                            <span class="font-semibold">${rule.code}</span>:
                            ${rule.if}
                            →
                            ${rule.then}
                        </div>
                    `;
                }).join('');
            }

            async function applyRuleBasedRecommendation() {
                const mainSelect = findMainProductSelect();

                if (!mainSelect) {
                    console.log('Komponen utama papan/kayu tidak ditemukan.');
                    return;
                }

                const selectedOption = mainSelect.options[mainSelect.selectedIndex];
                const mainProductId = selectedOption.dataset.productId;

                if (!mainProductId) {
                    return;
                }

                resetOptionLabels();

                try {
                    const response = await fetch(
                        `${apiUrl}?recipe_id=${recipeId}&main_product_id=${mainProductId}`, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        }
                    );

                    const data = await response.json();

                    if (!data.success) {
                        return;
                    }

                    const recommendations = data.recommendations || {};

                    Object.values(recommendations).forEach(function(recommendation) {
                        if (!recommendation) {
                            return;
                        }

                        const select = document.querySelector(
                            `.component-select[data-component-id="${recommendation.component_id}"]`
                        );

                        const quantityInput = document.querySelector(
                            `.component-qty[data-component-id="${recommendation.component_id}"]`
                        );

                        if (select && recommendation.option_id) {
                            select.value = recommendation.option_id;

                            const recommendedOption = select.querySelector(
                                `option[value="${recommendation.option_id}"]`
                            );

                            if (recommendedOption && recommendedOption.dataset.originalText) {
                                recommendedOption.textContent = '⭐ ' + recommendedOption.dataset
                                    .originalText;
                            }
                        }

                        if (quantityInput && recommendation.quantity) {
                            quantityInput.dataset.originalQty = recommendation.quantity;
                            quantityInput.value = recommendation.quantity;
                            quantityInput.dataset.ruleMin = recommendation.quantity;

                            const recommendationText = document.getElementById(
                                `rule-quantity-${recommendation.component_id}`
                            );

                            if (recommendationText) {
                                recommendationText.textContent =
                                    `★ Jumlah rekomendasi sistem untuk proyek lengkap: ${recommendation.quantity}`;

                                recommendationText.classList.remove('hidden');
                            }
                        }
                    });

                    updateBundleQuantity();

                    updateRuleInfo(data.rules || []);

                } catch (error) {
                    console.error('Gagal mengambil rekomendasi rule-based:', error);
                }
            }


            const bundleInput = document.getElementById('bundleQty');

            function updateBundleQuantity() {

                const multiplier = parseInt(bundleInput.value) || 1;
                document.getElementById('bundleQuantityHidden').value = multiplier;
                document.querySelectorAll('.component-qty').forEach(function(qtyInput) {

                    const originalQty =
                        parseInt(qtyInput.dataset.originalQty || qtyInput.value);

                    qtyInput.value = originalQty * multiplier;

                    qtyInput.dataset.ruleMin = originalQty * multiplier;

                    const componentId =
                        qtyInput.dataset.componentId;

                    const recommendationText =
                        document.getElementById(
                            `rule-quantity-${componentId}`
                        );

                    if (recommendationText) {

                        recommendationText.textContent =
                            `★ Jumlah rekomendasi sistem untuk ${multiplier} bundling : ${
                    originalQty * multiplier
                }`;

                    }

                });

            }

            bundleInput.addEventListener(
                'input',
                updateBundleQuantity
            );
            const mainSelect = findMainProductSelect();

            if (mainSelect) {
                mainSelect.addEventListener('change', applyRuleBasedRecommendation);
                applyRuleBasedRecommendation();
            }
        });
    </script>

</body>

</html>
