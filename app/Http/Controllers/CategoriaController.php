<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    public function index()
    {
        return Inertia::render('Categorias/Index', [
            'categorias' => Categoria::all(),
            'message' => session('message'),
        ]);
    }
    public function show(Categoria $categoria)
    {
        return Inertia::render('Categorias/Show', [
            'categoria' => $categoria
        ]);
    }
    public function create()
    {
        return Inertia::render('Categorias/Create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_categoria' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Verificar si el usuario ha subido una imagen
        if ($request->hasFile('imagen')) {
            $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
            // Guarda la imagen en 'storage/app/public/images'
            $rutaImagen = $request->file('imagen')->storeAs('images', $nombreArchivo, 'public');
            // Genera una URL accesible
            $validated['imagen'] = Storage::url($rutaImagen);
        }

        Categoria::create($validated);

        return redirect()->route('categorias.index')->with('message', 'Categoria creada exitosamente.');
    }
    public function edit(Categoria $categoria)
    {
    return Inertia::render('Categorias/Edit', [
        'categoria' => $categoria
    ]);
    }
    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nombre_categoria' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Mantener la imagen anterior si el usuario no sube una nueva
    if ($request->hasFile('imagen')) {
        $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
        $rutaImagen = $request->file('imagen')->storeAs('images', $nombreArchivo, 'public');

        // Generar la URL accesible
        $validated['imagen'] = Storage::url($rutaImagen);
    } else {
        $validated['imagen'] = $categoria->imagen; // Mantener la imagen anterior
    }

        $categoria->update($validated);

        return redirect()->route('categorias.index')
            ->with('message', 'Categoria actualizada exitosamente.');
    }
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('message', 'Categoria eliminada exitosamente.');
    }
}
