<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard con productos disponibles, incluyendo categoría y marca
    Route::get('/dashboard', function () {
        // Si tu modelo Producto define la relación 'categoria', la usas así:
        $productos = Producto::with('categoria')
            ->get()
            ->map(fn($p) => [
                'id_producto'      => $p->id_producto,
                'nombre'           => $p->nombre,
                'slug'             => $p->slug,
                'imagen'           => $p->imagen,
                'marca'            => $p->marca,
                'nombre_categoria' => $p->categoria->nombre_categoria,
            ]);

        return Inertia::render('Dashboard', [
            'productos' => $productos,
        ]);
    })->name('dashboard');

    // Rutas de recursos para categorías
    Route::resource('categorias', CategoriaController::class);

    // Rutas de recursos para productos usando 'slug' en lugar de ID
    Route::resource('productos', ProductoController::class)
         ->scoped([
             'producto' => 'slug',
         ]);
});
