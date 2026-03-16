<?php

namespace Database\Seeders;

use App\Models\VentaDiaria;
use App\Models\Cosecha;
use Illuminate\Database\Seeder;

class VentaDiariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Venta diaria 1: Coherente con la Cosecha Otoño-Invierno 2025
        VentaDiaria::create([
            'fecha' => '2026-03-13',
            'cosecha_id' => Cosecha::where('nombre_cosecha', 'Cosecha Otoño-Invierno 2025')->first()->id,
            'kilos_primera' => 90.00,
            'precio_primera' => 3.20,
            'kilos_industria' => 30.25,
            'precio_industria' => 1.80,
            'importe_total' => (90.00 * 3.20) + (30.25 * 1.80),
            'observaciones' => 'Venta con alta demanda de primera calidad.',
            'estado' => 'pendiente',
        ]);
    }
}
