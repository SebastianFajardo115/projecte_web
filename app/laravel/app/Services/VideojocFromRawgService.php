<?php

namespace App\Services;

use App\Models\Videojoc;
use App\Models\DetallVideojoc;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class VideojocFromRawgService
{
    protected $rawgService;

    public function __construct(RawgService $rawgService)
    {
        $this->rawgService = $rawgService;
    }

    /**
     * Crear un videojuego desde datos de RAWG
     *
     * @param int $gameId ID del juego en RAWG
     * @param string $gameName Nombre del juego
     * @param string|null $gameReleased Fecha de lanzamiento
     * @param string $plataforma Plataforma del juego
     * @param string $estat Estado inicial (JUGANT, PENDENT, COMPLETAT)
     * @param float|null $preu Precio del juego
     * @return Videojoc
     */
    public function crearDesdeRawg(int $gameId, string $gameName, ?string $gameReleased = null, string $plataforma, string $estat = 'PENDENT', ?float $preu = 0): Videojoc
    {
        // Obtener datos adicionales de la API RAWG
        $gameData = $this->rawgService->getGame($gameId);

        $nom = trim($gameName);
        $anyEstrena = $this->extraerAnio($gameReleased);

        return DB::transaction(function () use ($gameData, $plataforma, $estat, $preu, $nom, $anyEstrena) {
            // Crear el videojuego
            $videojoc = Videojoc::create([
                'nom' => $nom,
                'plataforma' => $plataforma,
                'any_estrena' => $anyEstrena,
                'estat' => in_array($estat, ['JUGANT', 'COMPLETAT', 'PENDENT']) ? $estat : 'PENDENT',
                'preu' => $preu,
            ]);

            // Crear el detalle del videojuego
            $this->crearDetalle($videojoc, $gameData);

            // Crear las categorías (géneros)
            $this->crearCategorias($videojoc, $gameData);

            return $videojoc;
        });
    }

    /**
     * Crear el detalle del videojuego
     */
    private function crearDetalle(Videojoc $videojoc, array $gameData): DetallVideojoc
    {
        return DetallVideojoc::create([
            'descripcio' => $gameData['description'] ?? 'Sin descripción disponible',
            'duracio' => $gameData['playtime'] ?? 0,
            'pegi' => $this->extraerPEGI($gameData['esrb_rating'] ?? null),
            'videojoc_id' => $videojoc->id,
        ]);
    }

    /**
     * Crear categorías desde los géneros de RAWG
     */
    private function crearCategorias(Videojoc $videojoc, array $gameData): void
    {
        $genres = $gameData['genres'] ?? [];

        foreach ($genres as $genre) {
            Categoria::create([
                'nom' => $genre['name'] ?? 'Sin género',
                'videojoc_id' => $videojoc->id,
            ]);
        }
    }

    /**
     * Extraer el año de una fecha
     */
    private function extraerAnio(?string $fecha): int
    {
        if (!$fecha) {
            return 2000; // Año por defecto si no hay fecha
        }

        try {
            $year = (int) substr($fecha, 0, 4);
            return $year > 1980 && $year <= now()->year ? $year : 2000;
        } catch (\Exception $e) {
            return 2000;
        }
    }

    /**
     * Extraer rating PEGI del rating ESRB de RAWG
     * Conversión aproximada ESRB -> PEGI
     */
    private function extraerPEGI(?array $esrbRating): int
    {
        if (!$esrbRating) {
            return 12; // Default PEGI
        }

        $slug = $esrbRating['slug'] ?? '';

        $conversion = [
            'everyone' => 3,
            'everyone-10-plus' => 7,
            'teen' => 12,
            'mature' => 16,
            'adults-only' => 18,
            'rating-pending' => 12,
        ];

        return $conversion[$slug] ?? 12;
    }

    /**
     * Actualizar estado de un videojuego
     *
     * @param Videojoc $videojoc
     * @param string $nuevoEstat (JUGANT, PENDENT, COMPLETAT)
     */
    public function actualizarEstat(Videojoc $videojoc, string $nuevoEstat): Videojoc
    {
        if (!in_array($nuevoEstat, ['JUGANT', 'PENDENT', 'COMPLETAT'])) {
            return $videojoc;
        }

        switch ($nuevoEstat) {
            case 'JUGANT':
                $videojoc->jugar();
                break;
            case 'COMPLETAT':
                $videojoc->completar();
                break;
            case 'PENDENT':
                $videojoc->pendent();
                break;
        }

        return $videojoc;
    }
}
