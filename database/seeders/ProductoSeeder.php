<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Seed the productos table with test data.
     */
    public function run(): void
    {
        // Crear 100 productos de prueba
        Producto::factory(100)->withLotes(2)->create();
    }
}
