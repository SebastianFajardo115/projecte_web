@extends('layout')

@section('content')
<h1>Editar Etiqueta</h1>

@include('etiquetas._form', [
    'action' => route('etiquetas.update', $etiqueta),
    'method' => 'PUT',
    'etiqueta' => $etiqueta
])

@endsection