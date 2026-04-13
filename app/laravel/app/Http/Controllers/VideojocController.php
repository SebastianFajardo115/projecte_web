<?php

namespace App\Http\Controllers;

use App\Models\Videojoc;
use Illuminate\Http\Request;
use App\Services\RawgService;

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
        // Només es marca com a completat si encara no ho està
        if ($videojoc->estat !== 'COMPLETAT') {
            $videojoc->update(['estat' => 'COMPLETAT']);

            return redirect()->route('videojocs.index')
                ->with('success', 'Videojoc marcat com a completat!');
        }

        return redirect()->route('videojocs.index')
            ->with('info', 'El videojoc ja estava completat.');
    }

    public function jugar(Videojoc $videojoc)
    {
        // Només es marca com a jugant si encara no ho està
        if ($videojoc->estat !== 'JUGANT') {
            $videojoc->update(['estat' => 'JUGANT']);

            return redirect()->route('videojocs.index')
                ->with('success', 'Videojoc marcat com a jugant!');
        }

        return redirect()->route('videojocs.index')
            ->with('info', 'El videojoc ja estava marcat com a jugant.');
    }

    public function pendent(Videojoc $videojoc)
    {
        // Només es marca com a pendent si encara no ho està
        if ($videojoc->estat !== 'PENDENT') {
            $videojoc->update(['estat' => 'PENDENT']);

            return redirect()->route('videojocs.index')
                ->with('success', 'Videojoc marcat com a pendent!');
        }

        return redirect()->route('videojocs.index')
            ->with('info', 'El videojoc ja estava marcat com a pendent.');
    }
}

