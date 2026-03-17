@extends('layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Totes les Etiquetes</h1>
    <a class="btn btn-secondary" href="{{ route('videojocs.index') }}">Tornar</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Videojoc</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($etiquetas as $etiqueta)
        <tr>
            <td>{{ $etiqueta->id }}</td>
            <td><span class="badge bg-info">{{ $etiqueta->nom }}</span></td>
            <td>
                @if($etiqueta->videojoc)
                    <a href="{{ route('videojocs.show', $etiqueta->videojoc) }}">{{ $etiqueta->videojoc->nom }}</a>
                @else
                    N/A
                @endif
            </td>
            <td class="d-flex gap-2">
                @if($etiqueta->videojoc)
                    <a class="btn btn-info btn-sm" href="{{ url('videojocs/' . $etiqueta->videojoc->id . '/etiquetas/create') }}">Afegir a aquest videojoc</a>
                @endif
                <a class="btn btn-warning btn-sm" href="{{ route('etiquetas.edit', $etiqueta) }}">Editar</a>
                <form action="{{ route('etiquetas.destroy', $etiqueta) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Eliminar?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
