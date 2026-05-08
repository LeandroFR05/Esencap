<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Formula;
use App\Models\Familia;
use App\Models\Insumo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formula>
 */
class FormulaFactory extends Factory
{
    protected $model = Formula::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtener un Insumo aleatorio que exista
        $insumo = Insumo::inRandomOrder()->first();
        $familia = Familia::inRandomOrder()->first();

        // Si no existen registros, usamos null (deberías semillar primero)
        return [
            'idFamilia' => $familia?->idFamilia ?? 1,
            'porcentaje' => fake()->randomFloat(2, 1, 100),
            'idInsumo' => $insumo?->idInsumo ?? 1,
            'contenido' => fake()->randomFloat(2, 10, 1000),
        ];
    }
}
