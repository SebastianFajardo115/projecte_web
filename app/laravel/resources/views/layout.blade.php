<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BiblioJocs - Gestiona tu colección de videojuegos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-gradient-primary shadow-lg border-b border-primary-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center space-x-2">
                    @auth
                        <a href="{{ route('videojocs.index') }}" class="flex items-center space-x-2 hover:opacity-90 transition-opacity">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                                <span class="text-primary-700 font-bold">📚</span>
                            </div>
                            <span class="text-white font-bold text-lg hidden sm:inline">BiblioJocs</span>
                        </a>
                    @else
                        <a href="{{ route('welcome') }}" class="flex items-center space-x-2 hover:opacity-90 transition-opacity">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                                <span class="text-primary-700 font-bold">📚</span>
                            </div>
                            <span class="text-white font-bold text-lg hidden sm:inline">BiblioJocs</span>
                        </a>
                    @endauth
                </div>

                <!-- Admin Links -->
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="hidden md:flex items-center space-x-1">
                            <a href="{{ route('videojocs.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-primary-700 transition">Videojocs</a>
                            <a href="{{ route('categorias.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-primary-700 transition">Categorias</a>
                            <a href="{{ route('etiquetas.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-primary-700 transition">Etiquetes</a>
                        </div>
                    @endif
                @endauth

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="hidden sm:flex items-center space-x-2">
                            <span class="text-primary-100 text-sm font-medium truncate">{{ auth()->user()->name }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 capitalize">
                                {{ auth()->user()->role }}
                            </span>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-white bg-primary-700 hover:bg-primary-800 transition">
                            Perfil
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-primary-700 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium bg-white text-primary-700 hover:bg-primary-50 transition font-semibold">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alerts -->
        @if (session('status') || session('success') || session('info'))
            <div class="mb-6 space-y-3">
                @if (session('status'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center space-x-3">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-emerald-800">{{ session('status') }}</span>
                    </div>
                @endif
                @if (session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center space-x-3">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-emerald-800">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('info'))
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-blue-800">{{ session('info') }}</span>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 mt-12 py-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm">&copy; 2026 BiblioJocs. Gestiona tu colección de videojuegos.</p>
                </div>
                <div class="text-sm">
                    <p>Desarrollado con ❤️ en Laravel + Tailwind CSS</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
