<form action="{{ $action }}" method="POST" class="card p-4">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nom de l'Etiqueta</label>
        <input type="text" name="nom" class="form-control" value="{{ old('nom', $etiqueta->nom ?? '') }}" required>
        @error('nom') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <button class="btn btn-success">Desar</button>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel·lar</a>
</form>
