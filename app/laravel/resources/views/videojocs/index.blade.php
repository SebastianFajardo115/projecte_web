@extends('layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>BiblioJocs</h1>
    <a class="btn btn-primary" href="{{ route('videojocs.create') }}">Afegir Videojoc</a>
</div>

<!-- Tabla: Videojuegos Jugant -->
<h2>Jugant</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Plataforma</th>
            <th>Any</th>
            <th>Preu</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($videojocs->where('estat', 'JUGANT') as $v)
        <tr>
            <td>{{ $v->nom }}</td>
            <td>{{ $v->plataforma }}</td>
            <td>{{ $v->any_estrena }}</td>
            <td>{{ $v->preu }} €</td>
            <td class="d-flex gap-2">
                <a class="btn btn-info btn-sm" href="{{ route('videojocs.show', $v) }}">Detall</a>

                <form action="{{ route('videojocs.complete', $v) }}" method="POST">
                    @csrf
                    @method('POST')
                    <button class="btn btn-success btn-sm" onclick="return confirm('Completar?')">Completar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Tabla: Videojuegos Pendents -->
<h2>Pendents</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Plataforma</th>
            <th>Any</th>
            <th>Preu</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($videojocs->where('estat', 'PENDENT') as $v)
        <tr>
            <td>{{ $v->nom }}</td>
            <td>{{ $v->plataforma }}</td>
            <td>{{ $v->any_estrena }}</td>
            <td>{{ $v->preu }} €</td>
            <td class="d-flex gap-2">
                <a class="btn btn-info btn-sm" href="{{ route('videojocs.show', $v) }}">Detall</a>

                <form action="{{ route('videojocs.jugar', $v) }}" method="POST">
                    @csrf
                    @method('POST')
                    <button class="btn btn-primary btn-sm" onclick="return confirm('Jugar?')">Jugar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Tabla: Videojuegos Completats -->
<h2>Completats</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Plataforma</th>
            <th>Any</th>
            <th>Preu</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($videojocs->where('estat', 'COMPLETAT') as $v)
        <tr>
            <td>{{ $v->nom }}</td>
            <td>{{ $v->plataforma }}</td>
            <td>{{ $v->any_estrena }}</td>
            <td>{{ $v->preu }} €</td>
            <td class="d-flex gap-2">
                <a class="btn btn-info btn-sm" href="{{ route('videojocs.show', $v) }}">Detall</a>

                <form action="{{ route('videojocs.jugar', $v) }}" method="POST">
                    @csrf
                    @method('POST')
                    <button class="btn btn-warning btn-sm" onclick="return confirm('Jugar?')">Tornar a jugar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Tabla: Todos los videojuegos -->
<h2>Tots els Videojocs</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Plataforma</th>
            <th>Any</th>
            <th>Estat</th>
            <th>Preu</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($videojocs as $v)
        <tr>
            <td>{{ $v->id }}</td>
            <td>{{ $v->nom }}</td>
            <td>{{ $v->plataforma }}</td>
            <td>{{ $v->any_estrena }}</td>
            <td>{{ $v->estat }}</td>
            <td>{{ $v->preu }} €</td>
            <td class="d-flex gap-2">
                <a class="btn btn-info btn-sm" href="{{ route('videojocs.show', $v) }}">Detall</a>
                <a class="btn btn-warning btn-sm" href="{{ route('videojocs.edit', $v) }}">Editar</a>
                <form action="{{ route('videojocs.destroy', $v) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Eliminar?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@foreach($games['results'] as $game)
    <h2>{{ $game['name'] }}</h2>
    <img src="{{ $game['background_image'] }}" width="200">
@endforeach

@endsection