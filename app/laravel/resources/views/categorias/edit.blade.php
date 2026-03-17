@extends('layout')

@section('content')
<h1>Editar Categoria</h1>

@include('categorias._form', [
    'action' => route('categorias.update', $categoria),
    'method' => 'PUT',
    'categoria' => $categoria
])

@endsection