@extends('layouts.app')

@section('title', 'Masuk Akun')

@section('content')
<div class="max-w-md mx-auto my-12 px-4">
    <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm">
        <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center">Masuk ke MiniUdemy</h2>
        <p class="text-sm text-gray-500 mb-6 text-center">Lanjutkan pembelajaran kursus online Anda.</p>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 text-xs p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Kata Sandi</label>
                <input type="password" name="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg text-sm transition">
                Masuk
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-gray-500">
            Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Daftar sekarang</a>
        </div>

        <div class="mt-6 pt-4 border-t border-gray-100 text-xs text-gray-400 text-center">
            <p>Akun Demo Cepat:</p>
            <p>Siswa: <code>siswa@example.com</code> / <code>password</code></p>
            <p>Instruktur: <code>instruktur@example.com</code> / <code>password</code></p>
        </div>
    </div>
</div>
@endsection
