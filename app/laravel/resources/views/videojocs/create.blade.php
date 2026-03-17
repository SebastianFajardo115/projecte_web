@extends('layout')

@section('content')
<h1>Afegir Videojoc</h1>

@include('videojocs._form', [
    'action' => route('videojocs.store'),
    'method' => 'POST',
    'videojoc' => null
])

@endsection