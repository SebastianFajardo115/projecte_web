<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Models\Videojoc;
use Illuminate\Http\Request;

class EtiquetaController extends Controller
{
    public function index(Videojoc $videojoc)
    {
        $etiquetas = $videojoc->etiquetas;

        return view('etiquetas.index', compact('videojoc', 'etiquetas'));
    }

    public function create(Videojoc $videojoc)
    {
        return view('etiquetas.create', compact('videojoc'));
    }

    public function store(Request $request, Videojoc $videojoc)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
        ]);

        $videojoc->etiquetas()->create($validated);

        return redirect()
            ->route('videojocs.show', $videojoc)
            ->with('status', 'Etiqueta creada correctament!');
    }

    public function edit(Etiqueta $etiqueta)
    {
        return view('etiquetas.edit', compact('etiqueta'));
    }

    public function update(Request $request, Etiqueta $etiqueta)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
        ]);

        $etiqueta->update($validated);

        return redirect()
            ->route('videojocs.show', $etiqueta->videojoc)
            ->with('status', 'Etiqueta actualitzada correctament!');
    }

    public function destroy(Etiqueta $etiqueta)
    {
        $videojoc = $etiqueta->videojoc;
        $etiqueta->delete();

        return redirect()
            ->route('videojocs.show', $videojoc)
            ->with('status', 'Etiqueta eliminada correctament!');
    }

    public function all()
{
    $etiquetas = Etiqueta::with('videojoc')->get();
    return view('etiquetas.all', compact('etiquetas'));
}
}
