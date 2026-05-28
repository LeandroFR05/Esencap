<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Historial;
use App\Models\Producto;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Historial>
 */
class HistorialFactory extends Factory
{
    protected $model = Historial::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stockInicial = fake()->randomFloat(2, 10, 70);

        return [
            'stockInicial' => $stockInicial,
            'stockActual' => $stockInicial, // Inicialmente igual al stock inicial
            'fechaElaboracion' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
        ];
    }

    /**
     * Crea el historial con fórmulas asociadas.
     */
    public function withFormulas(int $count = 1): static
    {
        return $this->has(
            FormulaFactory::new()->count($count),
            'formulas'
        );
    }
}
