<?php

namespace App\Http\Controllers;

use App\Models\Videojoc;
use Illuminate\Http\Request;
use App\Services\RawgService;
use App\Services\VideojocFromRawgService;

class VideojocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(RawgService $rawg)
{
    $videojocs = Videojoc::all();
    $games = $rawg->getGames();

    return view('videojocs.index', compact('videojocs', 'games'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('videojocs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'         => 'required|unique:videojocs,nom',
            'plataforma'  => 'required|string',
            'any_estrena' => 'required|integer',
            'estat'       => 'required|in:JUGANT,COMPLETAT,PENDENT',
            'preu'        => 'required|numeric',
        ]);

        Videojoc::create($validated);

        return redirect()->route('videojocs.index')->with('status', 'Videojoc creat correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Videojoc $videojoc)
    {
        $videojoc->load(['detall', 'categorias', 'etiquetas']);
        return view('videojocs.show', compact('videojoc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Videojoc $videojoc)
    {
        return view('videojocs.edit', compact('videojoc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Videojoc $videojoc)
    {
        $validated = $request->validate([
            'nom'         => 'required|unique:videojocs,nom,' . $videojoc->id,
            'plataforma'  => 'required|string',
            'any_estrena' => 'required|integer',
            'estat'       => 'required|in:JUGANT,COMPLETAT,PENDENT',
            'preu'        => 'required|numeric',
        ]);

        $videojoc->update($validated);

        return redirect()->route('videojocs.index')->with('status', 'Videojoc actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Videojoc $videojoc)
    {
        $videojoc->delete();

        return redirect()->route('videojocs.index')->with('status', 'Videojoc eliminat correctament!');
    }

    public function complete(Videojoc $videojoc)
    {
        // Si quieres asegurarte de que solo se pueda completar si no está ya completado
        if ($videojoc->estat !== 'COMPLETAT') {
            $videojoc->update(['estat' => 'COMPLETAT']);
            
            // Mensaje de éxito opcional
            return redirect()->route('videojocs.index')
                ->with('success', '¡Videojuego marcado como completado!');
        }
        
        return redirect()->route('videojocs.index')
            ->with('info', 'El videojuego ya estaba completado');
    }

        public function jugar(Videojoc $videojoc)
    {
        // Si quieres asegurarte de que solo se pueda completar si no está ya completado
        if ($videojoc->estat !== 'JUGANT') {
            $videojoc->update(['estat' => 'JUGANT']);
            
            // Mensaje de éxito opcional
            return redirect()->route('videojocs.index')
                ->with('success', '¡Videojuego marcado como completado!');
        }
        
        return redirect()->route('videojocs.index')
            ->with('info', 'El videojuego ya estaba completado');
    }

        public function pendent(Videojoc $videojoc)
    {
        // Si quieres asegurarte de que solo se pueda completar si no está ya completado
        if ($videojoc->estat !== 'PENDENT') {
            $videojoc->update(['estat' => 'PENDENT']);
            
            // Mensaje de éxito opcional
            return redirect()->route('videojocs.index')
                ->with('success', '¡Videojuego marcado como completado!');
        }
        
        return redirect()->route('videojocs.index')
            ->with('info', 'El videojuego ya estaba completado');
    }

    /**
     * Mostrar formulario para crear videojuego desde RAWG
     */
    public function createFromRawg(RawgService $rawg)
    {
        $games = $rawg->getGames();
        return view('videojocs.create-from-rawg', compact('games'));
    }

    /**
     * Guardar videojuego creado desde RAWG
     */
    public function storeFromRawg(Request $request, VideojocFromRawgService $service)
    {
        $validated = $request->validate([
            'game_id'     => 'required|integer',
            'plataforma'  => 'required|string',
            'estat'       => 'required|in:JUGANT,COMPLETAT,PENDENT',
            'preu'        => 'nullable|numeric|min:0',
        ]);

        try {
            $videojoc = $service->crearDesdeRawg(
                gameId: $validated['game_id'],
                plataforma: $validated['plataforma'],
                estat: $validated['estat'],
                preu: $validated['preu'] ?? 0
            );

            return redirect()->route('videojocs.show', $videojoc->id)
                ->with('success', 'Videojuego importado desde RAWG correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al importar el videojuego: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Obtener detalles de un juego de RAWG
     */
    public function gameDetail(int $gameId, RawgService $rawg)
    {
        try {
            $game = $rawg->getGame($gameId);
            return response()->json($game);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

