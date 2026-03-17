@extends('layout')

@section('content')
<h1>Afegir Etiqueta a {{ $videojoc->nom }}</h1>

@include('etiquetas._form', [
    'action' => url('videojocs/' . $videojoc->id . '/etiquetas'),
    'method' => 'POST',
    'etiqueta' => null
])

@endsection