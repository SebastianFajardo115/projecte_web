<?php

namespace App\Http\Controllers;

use App\Services\RawgService;

class GameController extends Controller
{
    protected $rawg;

    public function __construct(RawgService $rawg)
    {
        $this->rawg = $rawg;
    }

    public function index()
    {
        $games = $this->rawg->getGames();
        return view('games.index', compact('games'));
    }

    public function show($id)
    {
        $game = $this->rawg->getGame($id);
        return view('games.show', compact('game'));
    }
}

