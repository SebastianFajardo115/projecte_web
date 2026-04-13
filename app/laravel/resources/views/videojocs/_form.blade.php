<form action="{{ $action }}" method="POST" class="card p-6 space-y-4">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div>
        <label class="form-label">Nom</label>
        <input type="text" name="nom" class="form-input"
               value="{{ old('nom', $videojoc->nom ?? '') }}">
        @error('nom') <div class="form-error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="form-label">Plataforma</label>
        <input type="text" name="plataforma" class="form-input"
               value="{{ old('plataforma', $videojoc->plataforma ?? '') }}">
        @error('plataforma') <div class="form-error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="form-label">Any d’Estrena</label>
        <input type="number" name="any_estrena" class="form-input"
               value="{{ old('any_estrena', $videojoc->any_estrena ?? '') }}">
        @error('any_estrena') <div class="form-error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="form-label">Estat</label>
        <select name="estat" class="form-select">
            @foreach (['JUGANT','COMPLETAT','PENDENT'] as $estat)
                <option value="{{ $estat }}"
                    {{ old('estat', $videojoc->estat ?? '') == $estat ? 'selected' : '' }}>
                    {{ $estat }}
                </option>
            @endforeach
        </select>
        @error('estat') <div class="form-error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="form-label">Preu (€)</label>
        <input type="number" step="0.01" name="preu" class="form-input"
               value="{{ old('preu', $videojoc->preu ?? '') }}">
        @error('preu') <div class="form-error">{{ $message }}</div> @enderror
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button type="submit" class="btn-success">Desar</button>
        <a href="{{ route('videojocs.index') }}" class="btn-secondary">Cancel·lar</a>
    </div>
</form>

