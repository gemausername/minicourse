@extends('layouts.app')

@section('title', 'Buat Kursus Baru')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-6">
        <a href="{{ route('instructor.courses.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Kembali ke Dashboard</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">Buat Kursus Baru</h1>
        <p class="text-sm text-gray-500">Lengkapi formulir informasi kursus di bawah ini.</p>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 text-xs p-4 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('instructor.courses.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-xl border border-gray-200 shadow-sm space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Kursus *</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Belajar Pemrograman Web Laravel dari Nol"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Kursus *</label>
            <select name="category_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Lengkap Kursus *</label>
            <textarea name="description" rows="5" required placeholder="Jelaskan apa yang akan dipelajari siswa di kursus ini..."
                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp) *</label>
                <input type="number" name="price" value="{{ old('price', 0) }}" min="0" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <p class="text-xs text-gray-400 mt-1">Ketik 0 jika kursus ini gratis.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">URL Gambar Thumbnail</label>
                <input type="url" name="thumbnail" value="{{ old('thumbnail') }}" placeholder="https://images.unsplash.com/..."
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <p class="text-xs text-gray-400 mt-1">Kosongkan untuk memakai gambar default.</p>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('instructor.courses.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm shadow-sm transition">
                Simpan & Lanjut Isi Silabus &rarr;
            </button>
        </div>
    </form>
</div>
@endsection
