<?php

namespace App\Http\Controllers;

use App\Models\DetallVideojoc;
use App\Models\Videojoc;
use Illuminate\Http\Request;

class DetallVideojocController extends Controller
{
    public function create(Videojoc $videojoc)
    {
        return view('detall_videojoc.create', compact('videojoc'));
    }

    public function store(Request $request, Videojoc $videojoc)
    {
        $validated = $request->validate([
            'descripcio' => 'required|string',
            'duracio' => 'required|integer',
            'pegi' => 'required|integer',
        ]);

        $videojoc->detall()->create($validated);

        return redirect()
            ->route('videojocs.show', $videojoc)
            ->with('status', 'Detall creat correctament!');
    }

    public function edit(DetallVideojoc $detallVideojoc)
    {
        return view('detall_videojoc.edit', compact('detallVideojoc'));
    }

    public function update(Request $request, DetallVideojoc $detallVideojoc)
    {
        $validated = $request->validate([
            'descripcio' => 'required|string',
            'duracio' => 'required|integer',
            'pegi' => 'required|integer',
        ]);

        $detallVideojoc->update($validated);

        return redirect()
            ->route('videojocs.show', $detallVideojoc->videojoc)
            ->with('status', 'Detall actualitzat correctament!');
    }

    public function destroy(DetallVideojoc $detallVideojoc)
    {
        $videojoc = $detallVideojoc->videojoc;
        $detallVideojoc->delete();

        return redirect()
            ->route('videojocs.show', $videojoc)
            ->with('status', 'Detall eliminat correctament!');
    }
}
