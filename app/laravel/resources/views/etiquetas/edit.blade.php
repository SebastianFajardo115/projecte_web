@extends('layout')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('videojocs.show', $etiqueta->videojoc) }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Tornar
            </a>
            <h1 class="text-4xl font-bold text-slate-900 flex items-center">
                <span class="text-3xl mr-3">✏️</span>
                Editar Etiqueta
            </h1>
            <p class="text-slate-600 mt-2">Videojoc: {{ $etiqueta->videojoc->nom ?? 'Sense videojoc' }}</p>
        </div>

        @include('etiquetas._form', [
            'action' => route('etiquetas.update', $etiqueta),
            'method' => 'PUT',
            'etiqueta' => $etiqueta
        ])
    </div>

@endsection