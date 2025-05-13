<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;
    protected $fillable = [
        'id_categoria',
        'nombre',
        'marca',
        'referencia',
        'capacidad',
        'caracteristicas',
        'imagen', // Para almacenar la ruta de la imagen
        'slug',
    ];
    protected $primaryKey = 'id_producto';
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($producto) {
            $producto->slug = Str::slug($producto->nombre);
        });
    }
}
