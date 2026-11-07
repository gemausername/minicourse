@extends('layouts.app')

@section('title', 'Manajemen Kategori Kursus')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Kelola Kategori Kursus</h1>
        <p class="text-sm text-gray-500 mt-1">Atur kategori untuk mengelompokkan materi pembelajaran.</p>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 text-xs p-4 rounded-lg mb-6">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Form Tambah Kategori (Left) -->
        <div class="md:col-span-1">
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm sticky top-24">
                <h3 class="font-bold text-gray-900 text-base mb-4">➕ Tambah Kategori</h3>
                
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Kategori *</label>
                        <input type="text" name="name" required placeholder="Contoh: Mobile App Development"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg text-sm transition">
                        Simpan Kategori
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Kategori (Right) -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3.5 text-left">Nama Kategori</th>
                            <th class="px-6 py-3.5 text-left">Slug</th>
                            <th class="px-6 py-3.5 text-center">Jumlah Kursus</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ $category->name }}
                                </td>
                                <td class="px-6 py-4 text-xs font-mono text-gray-500">
                                    {{ $category->slug }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                        {{ $category->courses_count }} Kursus
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($category->courses_count == 0)
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-medium px-2 py-1 rounded hover:bg-rose-50 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Digunakan</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
