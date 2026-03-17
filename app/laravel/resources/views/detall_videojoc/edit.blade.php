@extends('layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Editar Detall - {{ $detallVideojoc->videojoc->nom }}</h1>
    <a class="btn btn-secondary" href="{{ route('videojocs.show', $detallVideojoc->videojoc) }}">Tornar</a>
</div>

<form action="{{ route('detall_videojoc.update', $detallVideojoc) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="descripcio" class="form-label">Descripció</label>
        <textarea class="form-control @error('descripcio') is-invalid @enderror" id="descripcio" name="descripcio" rows="3">{{ old('descripcio', $detallVideojoc->descripcio) }}</textarea>
        @error('descripcio')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="duracio" class="form-label">Duració (hores)</label>
        <input type="number" class="form-control @error('duracio') is-invalid @enderror" id="duracio" name="duracio" value="{{ old('duracio', $detallVideojoc->duracio) }}">
        @error('duracio')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="pegi" class="form-label">PEGI</label>
        <input type="number" class="form-control @error('pegi') is-invalid @enderror" id="pegi" name="pegi" value="{{ old('pegi', $detallVideojoc->pegi) }}">
        @error('pegi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Actualitzar</button>
</form>

@endsection
