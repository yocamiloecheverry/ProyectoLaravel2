<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Trae todos los productos con su categoría
        $products = Producto::with('categoria')->get();
        return response()->json($products);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'id_categoria'   => 'required|exists:categorias,id_categoria',
            'nombre'         => 'required|string|max:255',
            'marca'          => 'nullable|string|max:255',
            'referencia'     => 'nullable|string|max:255',
            'capacidad'      => 'nullable|string|max:255',
            'caracteristicas'=> 'nullable|string',
            'imagen'         => 'nullable|url',
            'slug'           => 'required|string|unique:productos,slug',
        ]);

        $product = Producto::create($data);
        // recargamos la relación para devolverla
        $product->load('categoria');

        return response()->json($product, 201);
    }

    public function show(Producto $product)
    {
        // $product viene por route-model binding (id_producto)
        $product->load('categoria');
        return response()->json($product);
    }

    public function update(Request $req, Producto $product)
    {
        $data = $req->validate([
            'id_categoria'   => 'required|exists:categorias,id_categoria',
            'nombre'         => 'required|string|max:255',
            'marca'          => 'nullable|string|max:255',
            'referencia'     => 'nullable|string|max:255',
            'capacidad'      => 'nullable|string|max:255',
            'caracteristicas'=> 'nullable|string',
            'imagen'         => 'nullable|url',
            'slug'           => "required|string|unique:productos,slug,{$product->id_producto},id_producto",
        ]);

        $product->update($data);
        $product->load('categoria');

        return response()->json($product);
    }

    public function destroy(Producto $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
