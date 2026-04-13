@extends('layout')

@section('content')
    <section class="space-y-4">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-3xl font-bold text-slate-900 flex items-center">
                <span class="text-2xl mr-2">📂</span>
                Totes les Categories
            </h1>
            <a href="{{ route('videojocs.index') }}" class="btn-secondary">Tornar</a>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-slate-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Descripció</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Videojoc</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Accions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($categorias as $categoria)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600">#{{ $categoria->id }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-slate-900">{{ $categoria->nom }}</td>
                                <td class="px-6 py-3 text-sm text-slate-600">{{ $categoria->descripcio }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm">
                                    @if($categoria->videojoc)
                                        <a href="{{ route('videojocs.show', $categoria->videojoc) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                            {{ $categoria->videojoc->nom }}
                                        </a>
                                    @else
                                        <span class="text-slate-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm space-x-2">
                                    @if($categoria->videojoc)
                                        <a href="{{ url('videojocs/' . $categoria->videojoc->id . '/categorias/create') }}" class="inline-flex items-center px-2.5 py-1.5 text-primary-600 hover:text-primary-700 hover:bg-primary-50 rounded transition text-xs font-medium">
                                            Afegir
                                        </a>
                                    @endif
                                    <a href="{{ route('categorias.edit', $categoria) }}" class="inline-flex items-center px-2.5 py-1.5 text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded transition text-xs font-medium">
                                        Editar
                                    </a>
                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 text-red-600 hover:text-red-700 hover:bg-red-50 rounded transition text-xs font-medium" onclick="return confirm('Eliminar?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-600">No hi ha categories registrades.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
