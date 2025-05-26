<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Carga todas las categorías con sus productos
        $cats = Categoria::with('productos')->get();
        return response()->json($cats);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'nombre_categoria'=>'required|string',
            'descripcion'     =>'nullable|string',
            'imagen'          =>'nullable|url',
        ]);

        $cat = Categoria::create($data);
        return response()->json($cat, 201);
    }

    public function show(Categoria $category)
    {
        $category->load('productos');
        return response()->json($category);
    }

    public function update(Request $req, Categoria $category)
    {
        $data = $req->validate([
            'nombre_categoria'=>'required|string',
            'descripcion'     =>'nullable|string',
            'imagen'          =>'nullable|url',
        ]);

        $category->update($data);
        return response()->json($category);
    }

    public function destroy(Categoria $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}
