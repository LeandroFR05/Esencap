<?php

namespace Database\Factories;

use App\Models\Carrito;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends Factory<Carrito>
 */
class CarritoFactory extends Factory
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
            'cantidad' => $this->faker->numberBetween(1, 10),
        ];
    }
}
