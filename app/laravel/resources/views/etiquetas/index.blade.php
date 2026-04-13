@extends('layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>BiblioJocs</h1>
    <a class="btn btn-primary" href="{{ route('videojocs.create') }}">Afegir Videojoc</a>
</div>

<!-- Taula: Videojocs jugant -->
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

                <form action="{{ route('videojocs.complete', $v) }}" method="POST">
                    @csrf
                    @method('POST')
                    <button class="btn btn-success btn-sm" onclick="return confirm('Marcar com a completat?')">Completar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Taula: Videojocs pendents -->
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

<!-- Taula: Videojocs completats -->
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

<!-- Taula: Tots els videojocs -->
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

@endsection