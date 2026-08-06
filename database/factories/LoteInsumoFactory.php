<?php

namespace Database\Factories;

use App\Models\LoteInsumo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LoteInsumo>
 */
class LoteInsumoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stockInicial = fake()->randomFloat(2, 10, 1000);
        $fechaCompra = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'stockInicial' => $stockInicial,
            'stockActual' => $stockInicial, // Inicialmente igual al stock inicial
            'fechaCompra' => $fechaCompra->format('Y-m-d'),
            'fechaVencimiento' => Carbon::instance($fechaCompra)->addMonths(fake()->numberBetween(1, 24))->format('Y-m-d'),
        ];
    }
}
