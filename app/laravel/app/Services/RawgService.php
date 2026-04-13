<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class RawgService
{
    protected $baseUrl = 'http://api.rawg.io/api';

    /**
     * Obtener lista de juegos
     *
     * @param string|null $search
     * @param int $perPage
     * @return array
     */
    public function getGames(?string $search = null, int $perPage = 40): array
    {
        return Cache::remember("rawg_games_" . md5($search ?? '') . "_" . $perPage, 3600, function () use ($search, $perPage) {
            try {
                $response = Http::timeout(10)
                    ->retry(3, 200)
                    ->get($this->baseUrl . '/games', [
                        'key' => config('services.rawg.key'),
                        'search' => $search,
                        'page_size' => $perPage,
                    ]);

                if ($response->successful() && $response->json()) {
                    return $response->json();
                }

                return $this->getMockGames();

            } catch (\Exception $e) {
                \Log::warning("RAWG API error: " . $e->getMessage());
                return $this->getMockGames();
            }
        });
    }

    /**
     * Retorna juegos mock para desarrollo/errores
     */
    private function getMockGames(): array
    {
        return [
            'results' => [
                [
                    'id' => 1,
                    'name' => 'The Witcher 3: Wild Hunt',
                    'background_image' => 'https://media.rawg.io/media/games/511/5118aff5091cb3efadf2145e1264778a.jpg',
                    'rating' => 4.6,
                    'released' => '2015-05-19',
                    'genres' => [
                        ['id' => 4, 'name' => 'Action'],
                        ['id' => 5, 'name' => 'RPG']
                    ]
                ],
                [
                    'id' => 2,
                    'name' => 'Elden Ring',
                    'background_image' => 'https://media.rawg.io/media/games/26d/26d548332195e992eb37fc048a0dbc99.jpg',
                    'rating' => 4.5,
                    'released' => '2022-02-25',
                    'genres' => [
                        ['id' => 4, 'name' => 'Action'],
                        ['id' => 5, 'name' => 'RPG']
                    ]
                ],
                [
                    'id' => 3,
                    'name' => 'Cyberpunk 2077',
                    'background_image' => 'https://media.rawg.io/media/games/4a7/4a7f78b19b121e56566556cb405a7ec4.jpg',
                    'rating' => 3.7,
                    'released' => '2020-12-10',
                    'genres' => [
                        ['id' => 4, 'name' => 'Action'],
                        ['id' => 5, 'name' => 'RPG']
                    ]
                ],
                [
                    'id' => 4,
                    'name' => 'Baldur\'s Gate 3',
                    'background_image' => 'https://media.rawg.io/media/games/bc0/bc06a29497498e2c8eb2e9efb211fbd1.jpg',
                    'rating' => 4.7,
                    'released' => '2023-08-03',
                    'genres' => [
                        ['id' => 5, 'name' => 'RPG']
                    ]
                ],
                [
                    'id' => 5,
                    'name' => 'Palworld',
                    'background_image' => 'https://media.rawg.io/media/games/50f/50f1a4f4c2a1cdd4c8cfc18d1b16eb4f.jpg',
                    'rating' => 4.2,
                    'released' => '2024-01-18',
                    'genres' => [
                        ['id' => 14, 'name' => 'Simulation'],
                        ['id' => 5, 'name' => 'RPG']
                    ]
                ]
            ]
        ];
    }

    /**
     * Obtener detalles de un juego por ID
     *
     * @param int|string $id
     * @return array
     */
    public function getGame($id): array
    {
        return Cache::remember("rawg_game_" . $id, 3600, function () use ($id) {
            try {
                $response = Http::withoutVerifying()
                    ->timeout(10)
                    ->retry(3, 200)
                    ->get($this->baseUrl . "/games/{$id}", [
                        'key' => config('services.rawg.key'),
                    ]);

                if ($response->failed()) {
                    return [];
                }

                return $response->json();

            } catch (\Exception $e) {
                // \Log::error("RAWG API error (game {$id}): " . $e->getMessage());
                return [];
            }
        });
    }
}