<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Familia;

class FamiliaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $familias = [
            ['nombre' => 'Aceites'],
            ['nombre' => 'Polvos'],
            ['nombre' => 'Colorantes'],
            ['nombre' => 'Emulsionantes'],
            ['nombre' => 'Conservantes'],
        ];

        foreach ($familias as $familia) {
            Familia::create($familia);
        }
    }
}
