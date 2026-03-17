@extends('layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>{{ $videojoc->nom }}</h1>
    <div class="d-flex gap-2">
        <a class="btn btn-warning" href="{{ route('videojocs.edit', $videojoc) }}">Editar</a>
        <a class="btn btn-secondary" href="{{ route('videojocs.index') }}">Tornar</a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Informació del Videojoc</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Plataforma:</strong> {{ $videojoc->plataforma }}</p>
                <p><strong>Any d'estrena:</strong> {{ $videojoc->any_estrena }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Estat:</strong> 
                    <span class="badge bg-{{ $videojoc->estat == 'COMPLETAT' ? 'success' : ($videojoc->estat == 'JUGANT' ? 'primary' : 'secondary') }}">
                        {{ $videojoc->estat }}
                    </span>
                </p>
                <p><strong>Preu:</strong> {{ $videojoc->preu }} €</p>
            </div>
        </div>
    </div>
</div>

{{-- Detall del Videojoc --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detalls</h5>
        @if (!$videojoc->detall)
            <a class="btn btn-sm btn-primary" href="{{ url('videojocs/' . $videojoc->id . '/detall/create') }}">Afegir Detall</a>
        @endif
    </div>
    <div class="card-body">
        @if ($videojoc->detall)
            <p><strong>Descripció:</strong> {{ $videojoc->detall->descripcio }}</p>
            <p><strong>Duració:</strong> {{ $videojoc->detall->duracio }} hores</p>
            <p><strong>PEGI:</strong> {{ $videojoc->detall->pegi }}</p>
            <div class="d-flex gap-2">
                <a class="btn btn-warning btn-sm" href="{{ route('detall_videojoc.edit', $videojoc->detall) }}">Editar</a>
                <form action="{{ route('detall_videojoc.destroy', $videojoc->detall) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Eliminar?')">Eliminar</button>
                </form>
            </div>
        @else
            <p class="text-muted">No hi ha detalls disponibles.</p>
        @endif
    </div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Categories</h5>
        @if(auth()->user()->isAdmin())
            <a class="btn btn-sm btn-primary" href="{{ url('videojocs/' . $videojoc->id . '/categorias/create') }}">Afegir Categoria</a>
        @endif
    </div>
    <div class="card-body">
        @if ($videojoc->categorias->count() > 0)
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Descripció</th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($videojoc->categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nom }}</td>
                        <td>{{ $categoria->descripcio }}</td>
                        <td class="d-flex gap-2">
                            @if(auth()->user()->isAdmin())
                                <a class="btn btn-warning btn-sm" href="{{ route('categorias.edit', $categoria) }}">Editar</a>
                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Eliminar?')">Eliminar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No hi ha categories.</p>
        @endif
    </div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Etiquetes</h5>
        @if(auth()->user()->isAdmin())
            <a class="btn btn-sm btn-primary" href="{{ url('videojocs/' . $videojoc->id . '/etiquetas/create') }}">Afegir Etiqueta</a>
        @endif
    </div>
    <div class="card-body">
        @if ($videojoc->etiquetas->count() > 0)
            <div class="d-flex flex-wrap gap-2">
                @foreach ($videojoc->etiquetas as $etiqueta)
                    <span class="badge bg-info d-flex align-items-center gap-1">
                        {{ $etiqueta->nom }}
                        @if(auth()->user()->isAdmin())
                            <form action="{{ route('etiquetas.destroy', $etiqueta) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-close btn-close-white" style="font-size: 0.5rem;" onclick="return confirm('Eliminar?')"></button>
                            </form>
                        @endif
                    </span>
                @endforeach
            </div>
        @else
            <p class="text-muted">No hi ha etiquetes.</p>
        @endif
    </div>
</div>

@endsection
