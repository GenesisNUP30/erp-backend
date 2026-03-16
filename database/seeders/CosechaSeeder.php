<?php

namespace Database\Seeders;

use App\Models\Campania;
use App\Models\Cosecha;
use App\Models\Plantacion;
use App\Models\Variedad;
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
        $variedadLyon = Variedad::where('nombre', 'like', '%Lyon%')->first();
        $variedadAdelita = Variedad::where('nombre', 'like', '%Adelita%')->first();

        $plantacionAdelita = Plantacion::where('parcela_id', 1)
                        ->where('variedad_id', $variedadAdelita->id)
                        ->first();
        if (!$plantacionAdelita) {
            throw new Exception("No se encontró una plantación con parcela_id = 1 y variedad_id = {$variedadAdelita->id}.");
        }

        Cosecha::create([ // Cosecha Otoño-Invierno 2025
            'plantacion_id' => $plantacionAdelita->id,
            'campania_id' => $campaniaActiva,
            'nombre_cosecha' => 'Cosecha Otoño-Invierno 2025',
            'fecha_inicio' => '2025-09-15',
            'fecha_fin' => '2026-03-30',
            'estado' => 'en_recoleccion',
        ]);

        // Cosechas para la Campaña Primavera 2024-2025
        $plantacionLyon = Plantacion::where('parcela_id', 2)
                        ->where('variedad_id', $variedadLyon->id)
                        ->first();
        if (!$plantacionLyon) {
            throw new Exception("No se encontró una plantación con parcela_id = 2 y variedad_id = {$variedadLyon->id}.");
        }

        Cosecha::create([
            'plantacion_id' => $plantacionLyon->id,
            'campania_id' => $campaniaFinalizada,
            'nombre_cosecha' => 'Cosecha Otoño-Invierno 2024',
            'fecha_inicio' => '2024-09-15',
            'fecha_fin' => '2025-01-10',
            'estado' => 'finalizada',
        ]);

    }
}
