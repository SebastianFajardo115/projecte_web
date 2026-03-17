<?php









namespace App\Http\Controllers;

use App\Models\Videojoc;
use Illuminate\Http\Request;

class VideojocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videojocs = Videojoc::all();

        return view('videojocs.index', compact('videojocs'));
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
}

