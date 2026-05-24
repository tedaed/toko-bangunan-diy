@extends('layouts.admin')

@section('title', 'Kelola Project DIY')
@section('page-title', 'Kelola Project DIY')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold">Data Project DIY</h3>
            <p class="text-sm text-gray-500">
                Kelola kategori project DIY seperti rak ambalan, kandang ayam, meja makan, dan lainnya.
            </p>
        </div>

        <a href="{{ route('admin.projects.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700">
            + Tambah Project
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.projects.index') }}"
          class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <div class="md:col-span-3">
            <label class="block font-semibold mb-1">Cari Project</label>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="w-full border rounded p-2"
                   placeholder="Cari nama atau deskripsi project">
        </div>

        <div class="flex items-end gap-2">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700">
                Cari
            </button>

            <a href="{{ route('admin.projects.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded">
                Reset
            </a>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3 border">Nama Project</th>
                    <th class="p-3 border">Deskripsi</th>
                    <th class="p-3 border">Jumlah Resep</th>
                    <th class="p-3 border">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td class="p-3 border font-semibold">
                            {{ $project->name }}
                        </td>

                        <td class="p-3 border">
                            {{ $project->description }}
                        </td>

                        <td class="p-3 border">
                            {{ $project->recipes_count }} resep
                        </td>

                        <td class="p-3 border">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.projects.edit', $project->id) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('admin.projects.destroy', $project->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus project ini?')">
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
                        <td colspan="4" class="p-4 text-center text-gray-500">
                            Belum ada data project DIY.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $projects->links() }}
    </div>

</div>

@endsection