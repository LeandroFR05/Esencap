<?php

namespace Database\Factories;

use App\Models\Insumo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Insumo>
 */
class InsumoFactory extends Factory
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
            'idFamilia' => fake()->numberBetween(1, 5), // Asegúrate de que existan familias con estos IDs
            'fase' => fake()->randomElement(['Acuosa', 'Oleosa', 'Activos']),
            'estado' => 1, // 1 para activo
            'unidadDeMedida' => fake()->randomElement(['gramos', 'unidades', 'kilos', 'litros']),
        ];
    }

    /**
     * Crea el insumo con lotes asociados.
     * Uso: Insumo::factory()->withLotes()->create()
     * O con múltiples lotes: Insumo::factory()->withLotes(3)->create()
     */
    public function withLotes(int $count = 1): static
    {
        return $this->has(
            LoteInsumoFactory::new()->count($count),
            'lotes'
        );
    }
}

