<?php

namespace Database\Factories;

use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Venta>
 */
class VentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idUsuario' => 1, 
            'fecha' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'cliente' => $this->faker->name(),
        ];
    }

    public function withDetalleVentas(): static
    {
        return $this->has(
            DetalleVentaFactory::new(),
            'detalleVentas'
        );
    }
}
