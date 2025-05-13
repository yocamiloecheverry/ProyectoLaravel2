<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Inertia\Inertia;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        return Inertia::render('Productos/Index', [
            'productos' => Producto::all(),
            'message' => session('message'),
        ]);
    }
    public function show(Producto $producto)
    {
        return Inertia::render('Productos/Show', [
            'producto' => $producto,
            'categorias' => Categoria::all(),
        ]);
    }
    public function create()
{
    $categorias = Categoria::all(); // Obtener todas las categorías

    return Inertia::render('Productos/Create', [
        'categorias' => $categorias
    ]);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'nombre' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'referencia' => 'nullable|string|max:255',
            'capacidad' => 'nullable|string|max:255',
            'caracteristicas' => 'nullable|string',
            'imagen' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        // Verificar si el usuario ha subido una imagen
        if ($request->hasFile('imagen')) {
            $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
            
            // ✅ Guarda la imagen en 'storage/app/public/images'
            $rutaImagen = $request->file('imagen')->storeAs('images', $nombreArchivo, 'public');
        
            // ✅ Genera una URL accesible
            $validated['imagen'] = Storage::url($rutaImagen);
        }

        Producto::create($validated);
        return redirect()->route('productos.index')->with('message', 'Producto creado exitosamente.');
    }
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all(); // Obtener todas las categorías

        return Inertia::render('Productos/Edit', [
            'producto' => $producto,
            'categorias' => $categorias
        ]);
    }
    public function update(Request $request, Producto $producto)
    {
        //dd($request->all());
        $validated = $request->validate([
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'nombre' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'referencia' => 'nullable|string|max:255',
            'capacidad' => 'nullable|string|max:255',
            'caracteristicas' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Mantener la imagen anterior si el usuario no sube una nueva
    if ($request->hasFile('imagen')) {
        $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
        $rutaImagen = $request->file('imagen')->storeAs('images', $nombreArchivo, 'public');

        // Generar la URL accesible
        $validated['imagen'] = Storage::url($rutaImagen);
    } else {
        $validated['imagen'] = $producto->imagen; // Mantener la imagen anterior
    }

        $producto->update($validated);

        return redirect()->route('productos.index')
            ->with('message', 'Producto actualizado exitosamente.');
    }
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')
            ->with('message', 'Producto eliminado exitosamente.');
    }
}
