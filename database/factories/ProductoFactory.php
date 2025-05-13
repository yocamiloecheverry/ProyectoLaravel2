<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_categoria' => Categoria::factory()->create()->id, // Genera una categoría aleatoria
            'nombre' => $this->faker->word(),
            'marca' => $this->faker->word(),
            'referencia' => $this->faker->word(),
            'capacidad' => $this->faker->numberBetween(1, 100),
            'caracteristicas' => $this->faker->sentence(),
            'slug' => Str::slug($nombre),
        ];
    }
}
