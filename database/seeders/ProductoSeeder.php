<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the productos table with test data.
     */
    public function run(): void
    {
        // Crear 50 productos de prueba
        Producto::factory(40)->withHistorial(2)->create();
    }
}
