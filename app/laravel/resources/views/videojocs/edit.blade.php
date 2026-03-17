@extends('layout')

@section('content')
<h1>Editar Videojoc</h1>

@include('videojocs._form', [
    'action' => route('videojocs.update', $videojoc),
    'method' => 'PUT',
    'videojoc' => $videojoc
])

@endsection