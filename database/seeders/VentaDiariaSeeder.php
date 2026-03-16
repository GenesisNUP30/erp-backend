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
            'kilos_primera' => 120.50,
            'precio_primera' => 3.20,
            'kilos_industria' => 50.00,
            'precio_industria' => 1.80,
            'importe_total' => (120.50 * 3.20) + (50.00 * 1.80),
            'observaciones' => 'Venta con alta demanda de primera calidad.',
            'estado' => 'pendiente',
        ]);

        // Venta diaria 2: Coherente con la Cosecha Primavera-Verano 2026
        VentaDiaria::create([
            'fecha' => '2026-03-14',
            'cosecha_id' => Cosecha::where('nombre_cosecha', 'Cosecha Primavera-Verano 2026')->first()->id,
            'kilos_primera' => 90.00,
            'precio_primera' => 3.50,
            'kilos_industria' => 30.25,
            'precio_industria' => 2.00,
            'importe_total' => (90.00 * 3.50) + (30.25 * 2.00),
            'observaciones' => 'Venta con precios estables.',
            'estado' => 'cobrada',
        ]);
    }
}
