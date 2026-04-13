@extends('layout')

@section('content')
    <section class="space-y-4">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-3xl font-bold text-slate-900 flex items-center">
                <span class="text-2xl mr-2">🏷️</span>
                Totes les Etiquetes
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Videojoc</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Accions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($etiquetas as $etiqueta)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600">#{{ $etiqueta->id }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-primary-100 text-primary-800">
                                        {{ $etiqueta->nom }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm">
                                    @if($etiqueta->videojoc)
                                        <a href="{{ route('videojocs.show', $etiqueta->videojoc) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                            {{ $etiqueta->videojoc->nom }}
                                        </a>
                                    @else
                                        <span class="text-slate-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm space-x-2">
                                    @if($etiqueta->videojoc)
                                        <a href="{{ url('videojocs/' . $etiqueta->videojoc->id . '/etiquetas/create') }}" class="inline-flex items-center px-2.5 py-1.5 text-primary-600 hover:text-primary-700 hover:bg-primary-50 rounded transition text-xs font-medium">
                                            Afegir
                                        </a>
                                    @endif
                                    <a href="{{ route('etiquetas.edit', $etiqueta) }}" class="inline-flex items-center px-2.5 py-1.5 text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded transition text-xs font-medium">
                                        Editar
                                    </a>
                                    <form action="{{ route('etiquetas.destroy', $etiqueta) }}" method="POST" class="inline">
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
                                <td colspan="4" class="px-6 py-8 text-center text-slate-600">No hi ha etiquetes registrades.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
