@extends('layouts.customer')

@section('title', 'Permintaan Custom')

@section('content')

    <div class="bg-blue-600 text-white py-16 text-center">
        <h1 class="text-4xl font-bold">Permintaan Custom</h1>
        <p class="mt-4">
            Ajukan ukuran atau kebutuhan khusus sesuai project DIY yang Anda inginkan.
        </p>
    </div>

    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="bg-white rounded-xl shadow p-6">

            <form action="{{ route('custom-requests.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block font-semibold mb-1">Nama Pelanggan</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                            class="w-full border rounded p-2" placeholder="Masukkan nama lengkap">

                        @error('customer_name')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">
                            Nomor WhatsApp <span class="text-red-600">*</span>
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" inputmode="numeric"
                            pattern="[0-9]{10,15}" class="w-full border rounded p-2" placeholder="Contoh: 081234567890">

                        @error('phone')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Project DIY</label>
                        <select name="project_id" class="w-full border rounded p-2">
                            <option value="">-- Pilih Project --</option>

                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ old('project_id', $selectedProjectId ?? '') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Kualitas Bahan</label>
                        <select name="quality" class="w-full border rounded p-2">
                            <option value="">-- Pilih Kualitas --</option>
                            <option value="Ekonomis" {{ old('quality') == 'Ekonomis' ? 'selected' : '' }}>Ekonomis</option>
                            <option value="Standar" {{ old('quality') == 'Standar' ? 'selected' : '' }}>Standar</option>
                            <option value="Premium" {{ old('quality') == 'Premium' ? 'selected' : '' }}>Premium</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Panjang (cm)</label>
                        <input type="number" name="length" value="{{ old('length') }}" class="w-full border rounded p-2"
                            placeholder="Contoh: 80">
                        @error('length')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Lebar (cm)</label>
                        <input type="number" name="width" value="{{ old('width') }}" class="w-full border rounded p-2"
                            placeholder="Contoh: 30">
                        @error('width')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Tinggi (cm)</label>
                        <input type="number" name="height" value="{{ old('height') }}" class="w-full border rounded p-2"
                            placeholder="Opsional">
                    </div>

                </div>

                <div class="mt-4">
                    <label class="block font-semibold mb-1">Catatan Kebutuhan</label>
                    <textarea name="note" rows="5" class="w-full border rounded p-2"
                        placeholder="Contoh: Saya ingin membuat rak ambalan ukuran 80x30 cm untuk kamar, warna natural, bahan lebih kuat.">{{ old('note') }}</textarea>

                    @error('note')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded font-bold hover:bg-blue-700">
                        Kirim Permintaan
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection
