<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Producto;

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
            'nombre' => fake()->word(),
            'foto' => null, // o null si no tenés foto
            'contenidoPorUnidad' => fake()->numberBetween(100, 1000),
            'estado' => 1, // 1 para activo
        ];
    }

    /**
     * Crea el producto con lotes y fórmulas.
     * Uso: Producto::factory()->withLotes()->create()
     * O con múltiples fórmulas: Producto::factory()->withLotes(2)->create()
     */
    public function withLotes(int $formulasCount = 1): static
    {
        return $this->has(
            LoteProductoFactory::new()->withFormulas($formulasCount),
            'lotes'
        );
    }
}

