<form action="{{ $action }}" method="POST" class="card p-4">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input type="text" name="nom" class="form-control"
               value="{{ old('nom', $videojoc->nom ?? '') }}">
        @error('nom') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Plataforma</label>
        <input type="text" name="plataforma" class="form-control"
               value="{{ old('plataforma', $videojoc->plataforma ?? '') }}">
        @error('plataforma') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Any d’Estrena</label>
        <input type="number" name="any_estrena" class="form-control"
               value="{{ old('any_estrena', $videojoc->any_estrena ?? '') }}">
        @error('any_estrena') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Estat</label>
        <select name="estat" class="form-select">
            @foreach (['JUGANT','COMPLETAT','PENDENT'] as $estat)
                <option value="{{ $estat }}"
                    {{ old('estat', $videojoc->estat ?? '') == $estat ? 'selected' : '' }}>
                    {{ $estat }}
                </option>
            @endforeach
        </select>
        @error('estat') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Preu (€)</label>
        <input type="number" step="0.01" name="preu" class="form-control"
               value="{{ old('preu', $videojoc->preu ?? '') }}">
        @error('preu') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <button class="btn btn-success">Desar</button>
    <a href="{{ route('videojocs.index') }}" class="btn btn-secondary">Cancel·lar</a>
</form>

