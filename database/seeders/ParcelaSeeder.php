<?php

namespace Database\Seeders;

use App\Models\Parcela;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParcelaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Parcela::create([
            'nombre' => 'Parcela 1',
            'superficie_hectareas' => 2.50,
            'ubicacion' => 'En la zona norte, límite con el campo de Juan .',
            'estado' => 'activa',
        ]);

        Parcela::create([
            'nombre' => 'Parcela 2',
            'superficie_hectareas' => 1.50,
            'ubicacion' => 'Enfrente del pozo, al lado de los caballos.',
            'estado' => 'activa',
        ]);
    }
}
