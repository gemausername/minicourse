<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mini Udemy') - Platform Kursus Online</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Desain bersih tanpa efek blur */
        * { -webkit-font-smoothing: antialiased; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('courses.index') }}" class="text-2xl font-bold text-indigo-600 flex items-center gap-2">
                        <span>🎓</span> MiniUdemy
                    </a>
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('courses.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Katalog Kursus</a>
                        @auth
                            <a href="{{ route('my.courses') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Kursus Saya</a>
                            @if(in_array(Auth::user()->role, ['instructor', 'admin']))
                                <a href="{{ route('instructor.courses.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold px-3 py-2 text-sm">
                                    ⚙️ Kelola Kursus
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-3">
                    @auth
                        <span class="text-sm text-gray-600 hidden sm:inline">Halo, <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->role }})</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-md font-medium transition">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-600 font-medium px-3 py-1.5">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-1.5 rounded-md transition shadow-sm">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-sm mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-lg text-sm mb-4">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12 py-6 text-center text-sm text-gray-500">
        <p>&copy; {{ date('Y') }} Mini Udemy LMS - Pengembangan dengan Laravel & SQLite.</p>
    </footer>

</body>
</html>
