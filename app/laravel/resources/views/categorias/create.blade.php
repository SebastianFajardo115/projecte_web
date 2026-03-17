@extends('layout')

@section('content')
<h1>Afegir Categoria a {{ $videojoc->nom }}</h1>

@include('categorias._form', [
    'action' => url('videojocs/' . $videojoc->id . '/categorias'),
    'method' => 'POST',
    'categoria' => null
])

@endsection