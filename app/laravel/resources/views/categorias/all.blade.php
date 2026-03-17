@extends('layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Totes les Categories</h1>
    <a class="btn btn-secondary" href="{{ route('videojocs.index') }}">Tornar</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Descripció</th>
            <th>Videojoc</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categorias as $categoria)
        <tr>
            <td>{{ $categoria->id }}</td>
            <td>{{ $categoria->nom }}</td>
            <td>{{ $categoria->descripcio }}</td>
            <td>
                @if($categoria->videojoc)
                    <a href="{{ route('videojocs.show', $categoria->videojoc) }}">{{ $categoria->videojoc->nom }}</a>
                @else
                    N/A
                @endif
            </td>
            <td class="d-flex gap-2">
                @if($categoria->videojoc)
                    <a class="btn btn-info btn-sm" href="{{ url('videojocs/' . $categoria->videojoc->id . '/categorias/create') }}">Afegir a aquest videojoc</a>
                @endif
                <a class="btn btn-warning btn-sm" href="{{ route('categorias.edit', $categoria) }}">Editar</a>
                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST">
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
