<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Videojoc;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Videojoc $videojoc)
    {
        $categorias = $videojoc->categorias;

        return view('categorias.index', compact('videojoc', 'categorias'));
    }

    public function create(Videojoc $videojoc)
    {
        return view('categorias.create', compact('videojoc'));
    }

    public function store(Request $request, Videojoc $videojoc)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'descripcio' => 'required|string',
        ]);

        $videojoc->categorias()->create($validated);

        return redirect()
            ->route('videojocs.show', $videojoc)
            ->with('status', 'Categoria creada correctament!');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'descripcio' => 'required|string',
        ]);

        $categoria->update($validated);

        return redirect()
            ->route('videojocs.show', $categoria->videojoc)
            ->with('status', 'Categoria actualitzada correctament!');
    }

    public function destroy(Categoria $categoria)
    {
        $videojoc = $categoria->videojoc;
        $categoria->delete();

        return redirect()
            ->route('videojocs.show', $videojoc)
            ->with('status', 'Categoria eliminada correctament!');
    }
    public function all()
{
    $categorias = Categoria::with('videojoc')->get();
    return view('categorias.all', compact('categorias'));
}
}