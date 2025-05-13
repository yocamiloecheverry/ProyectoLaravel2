<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Categoria extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriaFactory> */
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'nombre_categoria',
        'slug',
        'imagen',
        'descripcion',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($categoria) {
            $categoria->slug = Str::slug($categoria->nombre_categoria);
        });
    }

}
