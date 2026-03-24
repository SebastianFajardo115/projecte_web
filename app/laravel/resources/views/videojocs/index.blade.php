@extends('layout')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-4xl font-bold text-slate-900">📚 BiblioJocs</h1>
                <p class="text-slate-600 mt-1">Gestiona tu colección personal de videojuegos</p>
            </div>
            <a href="{{ route('videojocs.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-primary text-white rounded-lg hover:shadow-lg transition-shadow font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Afegir Videojoc
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-emerald-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">En joc</p>
                        <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $videojocs->where('estat', 'JUGANT')->count() }}</p>
                    </div>
                    <svg class="w-12 h-12 text-emerald-100" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a4 4 0 00-8 0v2a2 2 0 002 2h4a2 2 0 002-2z"/>
                    </svg>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-amber-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Pendents</p>
                        <p class="text-3xl font-bold text-amber-600 mt-1">{{ $videojocs->where('estat', 'PENDENT')->count() }}</p>
                    </div>
                    <svg class="w-12 h-12 text-amber-100" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-primary-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Completats</p>
                        <p class="text-3xl font-bold text-primary-600 mt-1">{{ $videojocs->where('estat', 'COMPLETAT')->count() }}</p>
                    </div>
                    <svg class="w-12 h-12 text-primary-100" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Status Sections -->
        @foreach(['JUGANT' => ['Jugant', 'emerald', '🎮'], 'PENDENT' => ['Pendents', 'amber', '⏳'], 'COMPLETAT' => ['Completats', 'primary', '✅']] as $status => [$label, $color, $emoji])
            @if($videojocs->where('estat', $status)->count() > 0)
                <section class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">{{ $emoji }}</span>
                        <h2 class="text-2xl font-bold text-slate-900">{{ $label }}</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $color }}-100 text-{{ $color }}-800">
                            {{ $videojocs->where('estat', $status)->count() }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($videojocs->where('estat', $status) as $v)
                            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden border border-slate-200">
                                <div class="p-4 space-y-3">
                                    <div>
                                        <h3 class="font-semibold text-slate-900 text-lg line-clamp-2">{{ $v->nom }}</h3>
                                        <p class="text-sm text-slate-600 mt-1">{{ $v->plataforma }} · {{ $v->any_estrena }}</p>
                                    </div>

                                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                                        <span class="text-2xl font-bold text-primary-600">{{ $v->preu }}€</span>
                                        <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">ID #{{ $v->id }}</span>
                                    </div>

                                    <div class="flex gap-2 pt-2">
                                        <a href="{{ route('videojocs.show', $v) }}" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-primary-50 text-primary-700 rounded-md hover:bg-primary-100 transition font-medium text-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Detall
                                        </a>
                                        @if($status === 'JUGANT')
                                            <form action="{{ route('videojocs.complete', $v) }}" method="POST" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 bg-emerald-50 text-emerald-700 rounded-md hover:bg-emerald-100 transition font-medium text-sm" onclick="return confirm('Marcar com completat?')">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Fet
                                                </button>
                                            </form>
                                        @elseif($status === 'PENDENT')
                                            <form action="{{ route('videojocs.jugar', $v) }}" method="POST" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 bg-gradient-primary text-white rounded-md hover:shadow-md transition font-medium text-sm" onclick="return confirm('Iniciar videojoc?')">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                                    </svg>
                                                    Jugar
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('videojocs.jugar', $v) }}" method="POST" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 bg-amber-50 text-amber-700 rounded-md hover:bg-amber-100 transition font-medium text-sm" onclick="return confirm('Tornar a jugar?')">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                                    </svg>
                                                    Replay
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach

        <!-- All Games Table -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-slate-900 flex items-center">
                <span class="text-2xl mr-2">📋</span>
                Tots els Videojocs
            </h2>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-slate-200">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Plataforma</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Any</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Estat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Preu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Accions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($videojocs as $v)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600">#{{ $v->id }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-slate-900">{{ $v->nom }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600">{{ $v->plataforma }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600">{{ $v->any_estrena }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'JUGANT' => ['bg-emerald-100', 'text-emerald-800', '🎮'],
                                                'PENDENT' => ['bg-amber-100', 'text-amber-800', '⏳'],
                                                'COMPLETAT' => ['bg-primary-100', 'text-primary-800', '✅'],
                                            ];
                                            $config = $statusConfig[$v->estat] ?? ['bg-slate-100', 'text-slate-800', '❓'];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $config[0] }} {{ $config[1] }}">
                                            {{ $config[2] }} {{ $v->estat }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm font-semibold text-primary-600">{{ $v->preu }}€</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm space-x-2">
                                        <a href="{{ route('videojocs.show', $v) }}" class="inline-flex items-center px-2.5 py-1.5 text-primary-600 hover:text-primary-700 hover:bg-primary-50 rounded transition text-xs font-medium">
                                            Veure
                                        </a>
                                        <a href="{{ route('videojocs.edit', $v) }}" class="inline-flex items-center px-2.5 py-1.5 text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded transition text-xs font-medium">
                                            Editar
                                        </a>
                                        <form action="{{ route('videojocs.destroy', $v) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 text-red-600 hover:text-red-700 hover:bg-red-50 rounded transition text-xs font-medium" onclick="return confirm('Estàs segur?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center">
                                        <p class="text-slate-600">No hi ha videojocs. <a href="{{ route('videojocs.create') }}" class="text-primary-600 hover:text-primary-700 font-semibold">Crea un!</a></p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Featured Games from RAWG -->
        @if(!empty($games['results']) && count($games['results']) > 0)
            <div class="py-16 px-4 bg-slate-50">
                <div class="max-w-7xl mx-auto space-y-8">
                    <div class="text-center">
                        <h2 class="text-4xl font-bold text-slate-900 flex items-center justify-center mb-2">
                            <span class="text-3xl mr-3">🔥</span>
                            Jocs Populars
                        </h2>
                        <p class="text-slate-600">Els videojocs més destacats segons RAWG.io</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($games['results'] as $game)
                            <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow overflow-hidden border border-slate-200">
                                @if($game['background_image'])
                                    <div class="h-48 bg-gradient-to-br from-slate-300 to-slate-400 overflow-hidden">
                                        <img src="{{ $game['background_image'] }}" alt="{{ $game['name'] }}" class="w-full h-full object-cover hover:scale-105 transition-transform">
                                    </div>
                                @else
                                    <div class="h-48 bg-gradient-to-br from-primary-300 to-primary-500 flex items-center justify-center">
                                        <span class="text-4xl">🎮</span>
                                    </div>
                                @endif
                                
                                <div class="p-4 space-y-3">
                                    <h3 class="font-semibold text-slate-900 line-clamp-2">{{ $game['name'] }}</h3>
                                    
                                    <div class="flex gap-2 flex-wrap">
                                        @if(!empty($game['genres']) && is_array($game['genres']))
                                            @foreach(array_slice($game['genres'], 0, 2) as $genre)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-primary-100 text-primary-800">
                                                    {{ $genre['name'] }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                                        <span class="text-sm text-slate-600">
                                            ⭐ {{ number_format($game['rating'] ?? 0, 1) }}
                                        </span>
                                        <span class="text-xs text-slate-500">
                                            {{ \Carbon\Carbon::parse($game['released'] ?? now())->year }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="py-16 px-4">
                <div class="max-w-7xl mx-auto text-center">
                    <p class="text-slate-600">No es pot connectar amb la base de dades de jocs.</p>
                </div>
            </div>
        @endif
    </div>

@endsection