@extends('layouts.app')

@section('title', 'Katalog Kursus Online')

@section('content')
<!-- Hero Section -->
<div class="bg-indigo-700 text-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Kembangkan Keahlianmu Sekarang</h1>
        <p class="mt-3 text-lg text-indigo-100 max-w-2xl mx-auto">
            Pelajari keahlian digital masa depan mulai dari pemrograman web hingga desain antarmuka bersama instruktur berpengalaman.
        </p>

        <!-- Search Form -->
        <form action="{{ route('courses.index') }}" method="GET" class="mt-6 max-w-xl mx-auto flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari materi atau kursus..."
                   class="flex-1 px-4 py-3 rounded-lg text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-6 py-3 rounded-lg text-sm transition">
                Cari
            </button>
        </form>
    </div>
</div>

<!-- Main Catalog Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Category Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-6 border-b border-gray-200">
        <a href="{{ route('courses.index') }}" 
           class="px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Semua Kategori
        </a>
        @foreach($categories as $category)
            <a href="{{ route('courses.index', ['category' => $category->slug]) }}" 
               class="px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap {{ request('category') == $category->slug ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                {{ $category->name }} ({{ $category->courses_count }})
            </a>
        @endforeach
    </div>

    <!-- Course Cards Grid -->
    @if($courses->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                    <img src="{{ $course->thumbnail ?? 'https://via.placeholder.com/600x350?text=No+Thumbnail' }}" 
                         alt="{{ $course->title }}" class="h-44 w-full object-cover">
                    
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 mb-2">
                                {{ $course->category->name }}
                            </span>
                            <h3 class="font-bold text-gray-900 text-lg leading-snug line-clamp-2">
                                <a href="{{ route('courses.show', $course->slug) }}" class="hover:text-indigo-600">
                                    {{ $course->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $course->description }}</p>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-500">Oleh: <strong>{{ $course->instructor->name }}</strong></span>
                            <span class="text-base font-bold {{ $course->price == 0 ? 'text-emerald-600' : 'text-indigo-600' }}">
                                {{ $course->price == 0 ? 'GRATIS' : 'Rp ' . number_format($course->price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl border border-dashed border-gray-300">
            <p class="text-gray-500 text-base">Belum ada kursus yang ditemukan.</p>
        </div>
    @endif
</div>
@endsection
