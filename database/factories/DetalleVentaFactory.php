<?php

namespace Database\Factories;

use App\Models\DetalleVenta;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends Factory<DetalleVenta>
 */
class DetalleVentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //Quiero el id de un producto existente, no crear uno nuevo cada vez
            'idProducto' => DB::table('productos')->inRandomOrder()->value('idProducto'),
            'precioUnitario' => $this->faker->randomFloat(2, 1, 100),
            'cantidad' => $this->faker->numberBetween(1, 10),
        ];
    }
}
