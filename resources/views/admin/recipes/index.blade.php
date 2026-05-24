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

    {{-- SEARCH & FILTER --}}
    <form method="GET" action="{{ route('admin.recipes.index') }}"
          class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <div class="md:col-span-2">
            <label class="block font-semibold mb-1">Cari Resep</label>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="w-full border rounded p-2"
                   placeholder="Cari nama resep atau deskripsi">
        </div>

        <div>
            <label class="block font-semibold mb-1">Project DIY</label>
            <select name="project_id" class="w-full border rounded p-2">
                <option value="">Semua Project</option>

                @foreach ($projects as $project)
                    <option value="{{ $project->id }}"
                        {{ request('project_id') == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700">
                Cari
            </button>

            <a href="{{ route('admin.recipes.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded">
                Reset
            </a>
        </div>
    </form>

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
                                <a href="{{ route('admin.recipes.show', $recipe->id) }}"
                                   class="bg-blue-600 text-white px-3 py-1 rounded">
                                    Komponen
                                </a>

                                <a href="{{ route('admin.recipes.edit', $recipe->id) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('admin.recipes.destroy', $recipe->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus resep ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded">
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

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $recipes->links() }}
    </div>

</div>

@endsection