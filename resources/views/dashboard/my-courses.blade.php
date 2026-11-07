@extends('layouts.app')

@section('title', 'Kursus Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Kursus Terdaftar Saya</h1>
        <p class="text-sm text-gray-500 mt-1">Lanjutkan progres belajar Anda di bawah ini.</p>
    </div>

    @if($enrollments->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($enrollments as $enrollment)
                @php $course = $enrollment->course; @endphp
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm flex flex-col justify-between">
                    <div>
                        <img src="{{ $course->thumbnail ?? 'https://via.placeholder.com/600x350' }}" 
                             alt="{{ $course->title }}" class="h-40 w-full object-cover">
                        <div class="p-5">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded bg-indigo-50 text-indigo-700">
                                {{ $course->category->name }}
                            </span>
                            <h3 class="font-bold text-gray-900 text-lg mt-2 line-clamp-2">{{ $course->title }}</h3>
                            <p class="text-xs text-gray-400 mt-2">Status: <span class="capitalize font-medium text-emerald-600">{{ $enrollment->status }}</span></p>
                        </div>
                    </div>

                    <div class="p-5 pt-0">
                        @if($course->lessons->count() > 0)
                            <a href="{{ route('lessons.show', [$course->slug, $course->lessons->first()->id]) }}" 
                               class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg text-sm transition">
                                Belajar Sekarang &rarr;
                            </a>
                        @else
                            <button disabled class="w-full bg-gray-200 text-gray-500 font-semibold py-2.5 rounded-lg text-sm cursor-not-allowed">
                                Modul Belum Siap
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl border border-dashed border-gray-300">
            <p class="text-gray-500 text-base mb-4">Anda belum mendaftar di kursus manapun.</p>
            <a href="{{ route('courses.index') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm">
                Jelajahi Katalog Kursus
            </a>
        </div>
    @endif
</div>
@endsection
