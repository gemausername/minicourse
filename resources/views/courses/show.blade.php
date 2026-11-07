@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="bg-gray-900 text-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto flex flex-col md:flex-row gap-8 items-start">
        <div class="flex-1">
            <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded bg-indigo-500/20 text-indigo-300 border border-indigo-400/30 mb-3">
                {{ $course->category->name }}
            </span>
            <h1 class="text-3xl font-extrabold sm:text-4xl leading-tight">{{ $course->title }}</h1>
            <p class="mt-4 text-gray-300 text-base leading-relaxed">{{ $course->description }}</p>
            <div class="mt-6 flex items-center gap-4 text-sm text-gray-400">
                <span>Instruktur: <strong class="text-white">{{ $course->instructor->name }}</strong></span>
                <span>•</span>
                <span>{{ $course->lessons->count() }} Modul Pembelajaran</span>
            </div>
        </div>

        <!-- Sticky Enrollment Card -->
        <div class="w-full md:w-80 bg-white text-gray-900 rounded-xl p-6 shadow-xl border border-gray-100">
            <img src="{{ $course->thumbnail ?? 'https://via.placeholder.com/600x350' }}" alt="{{ $course->title }}" class="rounded-lg h-40 w-full object-cover mb-4">
            
            <div class="text-2xl font-black {{ $course->price == 0 ? 'text-emerald-600' : 'text-gray-900' }} mb-4">
                {{ $course->price == 0 ? 'GRATIS' : 'Rp ' . number_format($course->price, 0, ',', '.') }}
            </div>

            @auth
                @if($isEnrolled)
                    @if($course->lessons->count() > 0)
                        <a href="{{ route('lessons.show', [$course->slug, $course->lessons->first()->id]) }}"
                           class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg shadow-sm transition">
                            Lanjutkan Belajar 🚀
                        </a>
                    @else
                        <button disabled class="w-full bg-gray-300 text-gray-600 font-bold py-3 rounded-lg cursor-not-allowed">
                            Materi Segera Hadir
                        </button>
                    @endif
                @else
                    <form action="{{ route('enroll.store', $course->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow-sm transition">
                            Daftar Kursus Sekarang
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow-sm transition">
                    Masuk untuk Mendaftar
                </a>
            @endauth
        </div>
    </div>
</div>

<!-- Syllabus / Lessons List -->
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Silabus Kurikulum</h2>

    @if($course->lessons->count() > 0)
        <div class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100">
            @foreach($course->lessons as $index => $lesson)
                <div class="p-4 sm:p-5 flex items-center justify-between hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <span class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-700 font-bold flex items-center justify-center text-sm">
                            {{ $lesson->order_number }}
                        </span>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">{{ $lesson->title }}</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Video Pembelajaran & Materi Teks</p>
                        </div>
                    </div>

                    @auth
                        @if($isEnrolled)
                            <a href="{{ route('lessons.show', [$course->slug, $lesson->id]) }}" 
                               class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                                Buka Materi &rarr;
                            </a>
                        @else
                            <span class="text-xs bg-gray-100 text-gray-500 px-2.5 py-1 rounded">Terkunci 🔒</span>
                        @endif
                    @else
                        <span class="text-xs bg-gray-100 text-gray-500 px-2.5 py-1 rounded">Terkunci 🔒</span>
                    @endauth
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 italic">Belum ada silabus yang diunggah untuk kursus ini.</p>
    @endif
</div>
@endsection
