@extends('layouts.app')

@section('title', 'Manajemen Kursus Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Dashboard Kursus Instruktur</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola kursus, unggah silabus, dan pantau siswa terdaftar.</p>
        </div>
        <a href="{{ route('instructor.courses.create') }}" 
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2.5 rounded-lg text-sm shadow-sm transition">
            <span>➕</span> Buat Kursus Baru
        </a>
    </div>

    @if($courses->count() > 0)
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3.5 text-left">Kursus</th>
                            <th class="px-6 py-3.5 text-left">Kategori</th>
                            <th class="px-6 py-3.5 text-left">Harga</th>
                            <th class="px-6 py-3.5 text-center">Total Modul</th>
                            <th class="px-6 py-3.5 text-center">Siswa</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($courses as $course)
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $course->thumbnail ?? 'https://via.placeholder.com/80' }}" class="w-12 h-12 object-cover rounded-md border border-gray-200">
                                        <div>
                                            <a href="{{ route('courses.show', $course->slug) }}" class="font-bold text-gray-900 hover:text-indigo-600">
                                                {{ $course->title }}
                                            </a>
                                            <p class="text-xs text-gray-400 mt-0.5">Dibuat: {{ $course->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-2.5 py-1 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700">
                                        {{ $course->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $course->price == 0 ? 'Gratis' : 'Rp ' . number_format($course->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-semibold text-gray-700">{{ $course->lessons->count() }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-semibold text-gray-700">{{ $course->enrollments->count() }}</span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('instructor.courses.lessons', $course->id) }}" 
                                       class="inline-block text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 px-3 py-1.5 rounded-md transition">
                                        Modul ({{ $course->lessons->count() }})
                                    </a>
                                    <a href="{{ route('instructor.courses.edit', $course->id) }}" 
                                       class="inline-block text-xs font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-md transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kursus ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 px-3 py-1.5 rounded-md transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl border border-dashed border-gray-300">
            <p class="text-gray-500 mb-4">Anda belum memiliki kursus yang dipublikasikan.</p>
            <a href="{{ route('instructor.courses.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-lg text-sm">
                Buat Kursus Pertama Anda
            </a>
        </div>
    @endif
</div>
@endsection
