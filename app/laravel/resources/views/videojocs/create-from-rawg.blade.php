@extends('layout')

@section('content')
    <div class="max-w-4xl">
        <div class="mb-8">
            <a href="{{ route('videojocs.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Tornar
            </a>
            <h1 class="text-4xl font-bold text-slate-900 flex items-center">
                <span class="text-3xl mr-3">🎮</span>
                Importar Videojoc des de RAWG
            </h1>
            <p class="text-slate-600 mt-2">Selecciona un joc del catàleg i configura-lo per a la teva biblioteca</p>
        </div>

        <form action="{{ route('videojocs.store-from-rawg') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Selección de juego -->
            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <label for="game_search" class="block text-sm font-bold text-slate-900 mb-2">
                    🔍 Buscar Videojoc
                </label>
                <input 
                    type="text" 
                    id="game_search" 
                    placeholder="Escriu el nom del joc..." 
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
            </div>

            <!-- Grid de juegos disponibles -->
            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <label class="block text-sm font-bold text-slate-900 mb-4">
                    ⭐ Jocs Disponibles
                </label>
                
                <div id="games_grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto">
                    @forelse($games['results'] ?? [] as $game)
                        <label class="cursor-pointer">
                            <input 
                                type="radio" 
                                name="game_id" 
                                value="{{ $game['id'] }}" 
                                class="hidden peer"
                                data-game-name="{{ $game['name'] }}"
                                data-game-rating="{{ $game['rating'] ?? 0 }}"
                                data-game-image="{{ $game['background_image'] ?? '' }}"
                            >
                            <div class="peer-checked:ring-2 peer-checked:ring-primary-500 peer-checked:border-primary-500 border-2 border-slate-200 rounded-lg p-3 hover:border-primary-300 transition">
                                @if($game['background_image'])
                                    <img src="{{ $game['background_image'] }}" alt="{{ $game['name'] }}" class="w-full h-32 object-cover rounded mb-2">
                                @else
                                    <div class="w-full h-32 bg-slate-200 rounded mb-2 flex items-center justify-center text-slate-400">
                                        <span>Sin imatge</span>
                                    </div>
                                @endif
                                <h3 class="font-semibold text-slate-900 text-sm line-clamp-2">{{ $game['name'] }}</h3>
                                <div class="flex items-center justify-between mt-1 text-xs text-slate-600">
                                    <span>⭐ {{ $game['rating'] ?? 'N/A' }}</span>
                                    <span>{{ $game['released'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </label>
                    @empty
                        <div class="col-span-full text-center py-8 text-slate-500">
                            No hi ha jocs disponibles
                        </div>
                    @endforelse
                </div>

                @error('game_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Vista previa del juego seleccionado -->
            <div id="game_preview" class="bg-slate-50 rounded-lg border border-slate-200 p-6 hidden">
                <h3 class="text-sm font-bold text-slate-900 mb-4">📋 Previsualització del Joc</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <img id="preview_image" src="" alt="" class="h-48 object-cover rounded col-span-1">
                    <div class="col-span-2 space-y-2">
                        <p><strong>Nom:</strong> <span id="preview_name"></span></p>
                        <p><strong>Valoració:</strong> <span id="preview_rating"></span></p>
                        <p><strong>Any:</strong> <span id="preview_year"></span></p>
                    </div>
                </div>
            </div>

            <!-- Configuración del videojoc -->
            <div class="bg-white rounded-lg border border-slate-200 p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-900">⚙️ Configuració del Videojoc</h3>

                <!-- Plataforma -->
                <div>
                    <label for="plataforma" class="block text-sm font-medium text-slate-900 mb-1">
                        Plataforma <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="plataforma" 
                        id="plataforma"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        required
                    >
                        <option value="">Selecciona una plataforma</option>
                        <option value="PC">PC</option>
                        <option value="PlayStation 5">PlayStation 5</option>
                        <option value="PlayStation 4">PlayStation 4</option>
                        <option value="Xbox Series X/S">Xbox Series X/S</option>
                        <option value="Xbox One">Xbox One</option>
                        <option value="Nintendo Switch">Nintendo Switch</option>
                        <option value="Android">Android</option>
                        <option value="iOS">iOS</option>
                    </select>
                    @error('plataforma')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label for="estat" class="block text-sm font-medium text-slate-900 mb-1">
                        Estat <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="estat" 
                        id="estat"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        required
                    >
                        <option value="PENDENT">⏳ Pendent</option>
                        <option value="JUGANT">🎮 Jugant</option>
                        <option value="COMPLETAT">✅ Completat</option>
                    </select>
                    @error('estat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio -->
                <div>
                    <label for="preu" class="block text-sm font-medium text-slate-900 mb-1">
                        Preu (€) <span class="text-slate-500 text-xs">(opcional)</span>
                    </label>
                    <input 
                        type="number" 
                        name="preu" 
                        id="preu"
                        step="0.01" 
                        min="0"
                        placeholder="0.00"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    >
                    @error('preu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex gap-3">
                <a href="{{ route('videojocs.index') }}" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 font-medium transition">
                    Cancelar
                </a>
                <button 
                    type="submit" 
                    class="flex-1 px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-medium transition flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Importar Videojoc
                </button>
            </div>
        </form>
    </div>

    <script>
        const gameSearchInput = document.getElementById('game_search');
        const gamesGrid = document.getElementById('games_grid');
        const gamePreview = document.getElementById('game_preview');
        const gameRadios = document.querySelectorAll('input[name="game_id"]');

        // Filtrar juegos mientras se escribe
        gameSearchInput.addEventListener('input', (e) => {
            const searchText = e.target.value.toLowerCase();
            const games = gamesGrid.querySelectorAll('label');

            games.forEach(game => {
                const gameName = game.querySelector('h3').textContent.toLowerCase();
                if (gameName.includes(searchText) || searchText === '') {
                    game.classList.remove('hidden');
                } else {
                    game.classList.add('hidden');
                }
            });
        });

        // Mostrar previsualización cuando se selecciona un juego
        gameRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                if (e.target.checked) {
                    document.getElementById('preview_name').textContent = e.target.dataset.gameName;
                    document.getElementById('preview_rating').textContent = e.target.dataset.gameRating + ' / 5';
                    document.getElementById('preview_year').textContent = e.target.value;
                    document.getElementById('preview_image').src = e.target.dataset.gameImage;
                    gamePreview.classList.remove('hidden');
                }
            });
        });

        // Prevenir envío si no hay juego seleccionado
        document.querySelector('form').addEventListener('submit', (e) => {
            if (!document.querySelector('input[name="game_id"]:checked')) {
                e.preventDefault();
                alert('Por favor, selecciona un joc');
            }
        });
    </script>
@endsection
