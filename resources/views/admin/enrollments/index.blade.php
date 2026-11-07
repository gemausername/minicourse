@extends('layouts.app')

@section('title', 'Validasi Pendaftaran Siswa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Validasi & Persetujuan Pendaftaran</h1>
        <p class="text-sm text-gray-500 mt-1">Pantau siswa yang mendaftar dan setujui akses materi pembelajaran.</p>
    </div>

    <!-- Filter Pills -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.enrollments.index') }}" 
           class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ !request('status') ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            Semua ({{ $pendingCount + $activeCount }})
        </a>
        <a href="{{ route('admin.enrollments.index', ['status' => 'pending']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2 {{ request('status') == 'pending' ? 'bg-amber-600 text-white' : 'bg-white border border-gray-200 text-amber-700 hover:bg-amber-50' }}">
            <span>⏳ Menunggu Approval</span>
            <span class="px-2 py-0.5 text-xs rounded-full {{ request('status') == 'pending' ? 'bg-white text-amber-800' : 'bg-amber-100 text-amber-800' }}">{{ $pendingCount }}</span>
        </a>
        <a href="{{ route('admin.enrollments.index', ['status' => 'active']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2 {{ request('status') == 'active' ? 'bg-emerald-600 text-white' : 'bg-white border border-gray-200 text-emerald-700 hover:bg-emerald-50' }}">
            <span>✅ Aktif</span>
            <span class="px-2 py-0.5 text-xs rounded-full {{ request('status') == 'active' ? 'bg-white text-emerald-800' : 'bg-emerald-100 text-emerald-800' }}">{{ $activeCount }}</span>
        </a>
    </div>

    <!-- Tabel Pendaftaran -->
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        @if($enrollments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3.5 text-left">Nama Siswa</th>
                            <th class="px-6 py-3.5 text-left">Kursus yang Diambil</th>
                            <th class="px-6 py-3.5 text-left">Biaya</th>
                            <th class="px-6 py-3.5 text-left">Tanggal Daftar</th>
                            <th class="px-6 py-3.5 text-center">Status</th>
                            <th class="px-6 py-3.5 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($enrollments as $enrollment)
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $enrollment->user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $enrollment->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('courses.show', $enrollment->course->slug) }}" class="font-semibold text-gray-800 hover:text-indigo-600">
                                        {{ $enrollment->course->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $enrollment->course->price == 0 ? 'Gratis' : 'Rp ' . number_format($enrollment->course->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    {{ $enrollment->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($enrollment->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                    @if($enrollment->status === 'pending')
                                        <form action="{{ route('admin.enrollments.approve', $enrollment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-md shadow-sm transition">
                                                ✓ Setujui (Approve)
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.enrollments.reject', $enrollment->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus / membatalkan pendaftaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 px-3 py-1.5 rounded-md transition">
                                            Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 text-gray-400 text-sm">
                Tidak ada data pendaftaran yang sesuai dengan filter.
            </div>
        @endif
    </div>
</div>
@endsection
