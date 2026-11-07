@extends('layouts.app')

@section('title', $lesson->title . ' - ' . $course->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-4 flex items-center gap-2">
        <a href="{{ route('courses.show', $course->slug) }}" class="hover:text-indigo-600">&larr; Kembali ke Detail Kursus</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">{{ $course->title }}</span>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Video & Lesson Content Player (Left) -->
        <div class="flex-1">
            <div class="bg-black rounded-xl overflow-hidden shadow-lg aspect-video w-full mb-6">
                @if($lesson->video_url)
                    <iframe class="w-full h-full" src="{{ $lesson->video_url }}" title="{{ $lesson->title }}" 
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                    </iframe>
                @else
                    <div class="flex items-center justify-center h-full text-gray-400">
                        Tidak ada video embed untuk modul ini.
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2.5 py-1 rounded">Modul {{ $lesson->order_number }}</span>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $lesson->title }}</h1>
                </div>

                <div class="prose max-w-none text-gray-700 leading-relaxed border-t border-gray-100 pt-6">
                    <p>{{ $lesson->content ?? 'Tidak ada catatan teks tambahan pada materi ini.' }}</p>
                </div>
            </div>
        </div>

        <!-- Playlist / Lesson Sidebar (Right) -->
        <div class="w-full lg:w-80">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm sticky top-24">
                <div class="p-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-bold text-gray-900 text-sm">Daftar Modul Belajar</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $course->lessons->count() }} Modul tersedia</p>
                </div>

                <div class="divide-y divide-gray-100 max-h-[600px] overflow-y-auto">
                    @foreach($course->lessons as $l)
                        <a href="{{ route('lessons.show', [$course->slug, $l->id]) }}" 
                           class="p-4 flex items-start gap-3 hover:bg-gray-50 transition {{ $l->id === $lesson->id ? 'bg-indigo-50/70 border-l-4 border-indigo-600' : '' }}">
                            <span class="text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center {{ $l->id === $lesson->id ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                {{ $l->order_number }}
                            </span>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold {{ $l->id === $lesson->id ? 'text-indigo-900' : 'text-gray-800' }}">
                                    {{ $l->title }}
                                </h4>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
