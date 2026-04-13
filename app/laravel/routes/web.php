<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DetallVideojocController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideojocController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/games', [GameController::class, 'index']);
Route::get('/games/{id}', [GameController::class, 'show']);

Route::middleware('guest')->group(function () {
    Route::get('/', function (\App\Services\RawgService $rawg) {
        $games = $rawg->getGames();
        return view('landing', compact('games'));
    })->name('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('videojocs.index');
    })->name('dashboard');

    // Rutas personalizadas de videojocs (ANTES del resource)
    Route::get('videojocs/create-from-rawg', [VideojocController::class, 'createFromRawg'])->name('videojocs.create-from-rawg');
    Route::post('videojocs/store-from-rawg', [VideojocController::class, 'storeFromRawg'])->name('videojocs.store-from-rawg');
    Route::get('videojocs/game-detail/{gameId}', [VideojocController::class, 'gameDetail'])->name('videojocs.game-detail');

    // Resource (genera index, store, show, edit, update, destroy)
    Route::resource('videojocs', VideojocController::class);

    // Rutas de cambio de estado
    Route::post('videojocs/{videojoc}/complete', [VideojocController::class, 'complete'])->name('videojocs.complete');
    Route::post('videojocs/{videojoc}/jugar', [VideojocController::class, 'jugar'])->name('videojocs.jugar');
    Route::post('videojocs/{videojoc}/pendent', [VideojocController::class, 'pendent'])->name('videojocs.pendent');

    Route::get('videojocs/{videojoc}/detall/create', [DetallVideojocController::class, 'create'])->name('detall_videojoc.create');
    Route::post('videojocs/{videojoc}/detall', [DetallVideojocController::class, 'store'])->name('detall_videojoc.store');
    Route::get('detall_videojoc/{detallVideojoc}/edit', [DetallVideojocController::class, 'edit'])->name('detall_videojoc.edit');
    Route::match(['put', 'patch'], 'detall_videojoc/{detallVideojoc}', [DetallVideojocController::class, 'update'])->name('detall_videojoc.update');
    Route::delete('detall_videojoc/{detallVideojoc}', [DetallVideojocController::class, 'destroy'])->name('detall_videojoc.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('categorias', [CategoriaController::class, 'all'])->name('categorias.index');
    Route::get('etiquetas', [EtiquetaController::class, 'all'])->name('etiquetas.index');

    Route::get('videojocs/{videojoc}/categorias', [CategoriaController::class, 'index'])->name('videojocs.categorias.index');
    Route::get('videojocs/{videojoc}/categorias/create', [CategoriaController::class, 'create'])->name('videojocs.categorias.create');
    Route::post('videojocs/{videojoc}/categorias', [CategoriaController::class, 'store'])->name('videojocs.categorias.store');
    Route::get('categorias/{categoria}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::match(['put', 'patch'], 'categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

    Route::get('videojocs/{videojoc}/etiquetas', [EtiquetaController::class, 'index'])->name('videojocs.etiquetas.index');
    Route::get('videojocs/{videojoc}/etiquetas/create', [EtiquetaController::class, 'create'])->name('videojocs.etiquetas.create');
    Route::post('videojocs/{videojoc}/etiquetas', [EtiquetaController::class, 'store'])->name('videojocs.etiquetas.store');
    Route::get('etiquetas/{etiqueta}/edit', [EtiquetaController::class, 'edit'])->name('etiquetas.edit');
    Route::match(['put', 'patch'], 'etiquetas/{etiqueta}', [EtiquetaController::class, 'update'])->name('etiquetas.update');
    Route::delete('etiquetas/{etiqueta}', [EtiquetaController::class, 'destroy'])->name('etiquetas.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
