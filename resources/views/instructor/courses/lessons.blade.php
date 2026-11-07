@extends('layouts.app')

@section('title', 'Kelola Modul: ' . $course->title)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('instructor.courses.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Kembali ke Dashboard Kursus</a>
            <h1 class="text-2xl font-bold text-gray-900 mt-2">Silabus Modul: {{ $course->title }}</h1>
            <p class="text-sm text-gray-500">Tambah dan atur urutan modul materi belajar.</p>
        </div>
        <a href="{{ route('courses.show', $course->slug) }}" target="_blank"
           class="inline-flex items-center text-xs font-semibold bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg transition">
            Lihat Tampilan Publik ↗
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Tambah Modul Baru (Left) -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm sticky top-24">
                <h3 class="font-bold text-gray-900 text-base mb-4">➕ Tambah Modul Baru</h3>

                <form action="{{ route('instructor.courses.lessons.store', $course->id) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Judul Modul *</label>
                        <input type="text" name="title" required placeholder="Contoh: Pengenalan Sintaks PHP"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">URL Video Embed (YouTube/Lainnya)</label>
                        <input type="url" name="video_url" placeholder="https://www.youtube.com/embed/..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <p class="text-[11px] text-gray-400 mt-0.5">Gunakan link embed youtube (bukan link watch).</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor Urut Bab</label>
                        <input type="number" name="order_number" value="{{ $course->lessons->count() + 1 }}" min="1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Rangkuman / Catatan Teks Materi</label>
                        <textarea name="content" rows="4" placeholder="Tuliskan rangkuman isi materi di sini..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg text-sm transition">
                        Tambah ke Silabus
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Modul yang Sudah Ada (Right) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-sm">Daftar Modul Saat Ini ({{ $course->lessons->count() }})</h3>
                </div>

                @if($course->lessons->count() > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach($course->lessons as $lesson)
                            <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-4">
                                    <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-xs">
                                        {{ $lesson->order_number }}
                                    </span>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-sm">{{ $lesson->title }}</h4>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            {{ $lesson->video_url ? '🎬 Ada Video Embed' : '📝 Teks Saja' }}
                                        </p>
                                    </div>
                                </div>

                                <form action="{{ route('instructor.courses.lessons.destroy', [$course->id, $lesson->id]) }}" method="POST" onsubmit="return confirm('Hapus modul ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-medium px-2.5 py-1 rounded hover:bg-rose-50 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-400 text-sm">
                        Belum ada modul. Gunakan formulir di samping untuk menambahkan modul pertama!
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
