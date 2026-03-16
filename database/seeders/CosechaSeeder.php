<?php

namespace Database\Seeders;

use App\Models\Campania;
use App\Models\Cosecha;
use App\Models\Plantacion;
use Exception;
use Illuminate\Database\Seeder;

class CosechaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaniaFinalizada = Campania::where('estado', 'finalizada')->first()->id;
        $campaniaActiva = Campania::where('estado', 'activa')->first()->id;

        // Cosechas para la Campaña Primavera 2024-2025
        $plantacion = Plantacion::where('parcela_id', 1)->where('variedad_id', 1)->first();
        if (!$plantacion) {
            throw new Exception("No se encontró una plantación con parcela_id = 1 y variedad_id = 1.");
        }

        Cosecha::create([
            'plantacion_id' => $plantacion->id,
            'campania_id' => $campaniaFinalizada,
            'nombre_cosecha' => 'Cosecha Otoño-Invierno 2024',
            'fecha_inicio' => '2024-09-15',
            'fecha_fin' => '2025-01-10',
            'estado' => 'finalizada',
        ]);

        $plantacion = Plantacion::where('parcela_id', 1)->where('variedad_id', 1)->first();
        if (!$plantacion) {
            throw new Exception("No se encontró una plantación con parcela_id = 1 y variedad_id = 1.");
        }

        Cosecha::create([
            'plantacion_id' => $plantacion->id,
            'campania_id' => $campaniaFinalizada,
            'nombre_cosecha' => 'Cosecha Primavera-Verano 2025',
            'fecha_inicio' => '2025-03-20',
            'fecha_fin' => '2025-06-15',
            'estado' => 'finalizada',
        ]);

        // Cosechas para la Campaña 2025-2026
        $plantacion = Plantacion::where('parcela_id', 1)->where('variedad_id', 2)->first();
        if (!$plantacion) {
            throw new Exception("No se encontró una plantación válida para la parcela 1 y la variedad 2.");
        }

        Cosecha::create([
            'plantacion_id' => $plantacion->id,
            'campania_id' => $campaniaActiva,
            'nombre_cosecha' => 'Cosecha Otoño-Invierno 2025',
            'fecha_inicio' => '2025-09-20',
            'fecha_fin' => null,
            'estado' => 'en_recoleccion',
        ]);
    }
}
