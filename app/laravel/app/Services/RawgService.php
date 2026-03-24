<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RawgService
{
    protected $baseUrl = 'https://api.rawg.io/api';

    public function getGames($search = null)
    {
        $response = Http::get($this->baseUrl . '/games', [
            'key' => env('RAWG_API_KEY'),
            'search' => $search
        ]);

        return $response->json();
    }

    public function getGame($id)
    {
        $response = Http::get($this->baseUrl . "/games/{$id}", [
            'key' => env('RAWG_API_KEY'),
        ]);

        return $response->json();
    }
}