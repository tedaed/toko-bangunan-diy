@extends('layouts.admin')

@section('title', 'Kelola Resep DIY')
@section('page-title', 'Kelola Resep DIY')

@section('content')

    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold">Data Resep DIY</h3>
                <p class="text-sm text-gray-500">
                    Kelola variasi resep berdasarkan project dan ukuran.
                </p>
            </div>

            <a href="{{ route('admin.recipes.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700">
                + Tambah Resep
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border">Nama Resep</th>
                        <th class="p-3 border">Project</th>
                        <th class="p-3 border">Ukuran</th>
                        <th class="p-3 border">Deskripsi</th>
                        <th class="p-3 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recipes as $recipe)
                        <tr>
                            <td class="p-3 border font-semibold">
                                {{ $recipe->name }}
                            </td>

                            <td class="p-3 border">
                                {{ $recipe->project->name ?? '-' }}
                            </td>

                            <td class="p-3 border">
                                {{ $recipe->length ?? '-' }}
                                x
                                {{ $recipe->width ?? '-' }}

                                @if ($recipe->height)
                                    x {{ $recipe->height }}
                                @endif

                                cm
                            </td>

                            <td class="p-3 border">
                                {{ $recipe->description ?? '-' }}
                            </td>

                            <td class="p-3 border">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.recipes.edit', $recipe->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded">
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.recipes.show', $recipe->id) }}"
                                        class="bg-blue-600 text-white px-3 py-1 rounded">
                                        Komponen
                                    </a>

                                    <form action="{{ route('admin.recipes.destroy', $recipe->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus resep ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">
                                Belum ada data resep DIY.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection
