<form action="{{ $action }}" method="POST" class="card p-6 space-y-4">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div>
        <label class="form-label">Nom de l'Etiqueta</label>
        <input type="text" name="nom" class="form-input" value="{{ old('nom', $etiqueta->nom ?? '') }}" required>
        @error('nom') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="flex items-center gap-3 pt-2">
        <button type="submit" class="btn-success">Desar</button>
        <a href="{{ url()->previous() }}" class="btn-secondary">Cancel·lar</a>
    </div>
</form>
