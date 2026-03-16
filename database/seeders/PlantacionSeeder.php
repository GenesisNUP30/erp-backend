<?php

namespace Database\Seeders;

use App\Models\Campania;
use App\Models\Parcela;
use App\Models\Plantacion;
use App\Models\Variedad;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlantacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de parcelas existentes
        $parcela1 = Parcela::where('nombre', 'Parcela 1')->first()->id;
        $parcela2 = Parcela::where('nombre', 'Parcela 2')->first()->id;

        // Obtener IDs de variedades existentes
        $variedadLyon = Variedad::where('nombre', 'Lyon (Glen Lyon)')->first()->id;
        $campaniaFinalizada = Campania::where('estado', 'finalizada')->first()->id;

        $variedadAdelita = Variedad::where('nombre', 'like', '%Adelita%')->first()->id;
        $campaniaActiva = Campania::where('estado', 'activa')->first()->id;

        $variedadAdelita = Variedad::where('nombre', 'like', '%Adelita%')->first()->id;
        $campaniaPlanificada = Campania::where('estado', 'planificada')->first();
        if (!$campaniaPlanificada) {
            throw new Exception("No se encontró una campaña con el estado 'planificada'.");
        }
        $campaniaPlanificada = $campaniaPlanificada->id;

        // Parcela 1 - Variedad Lyon (Glen Lyon) - Plantación no remontante
        Plantacion::create([
            'parcela_id' => $parcela1,
            'variedad_id' => $variedadLyon,
            'campania_id' => $campaniaFinalizada,
            'fecha_siembra' => '2023-02-10',
            'numero_plantas' => 4100,
            'fecha_fin' => '2025-06-30',
            'estado' => 'finalizada',
        ]);

        // Parcela 1 - Variedad Adelita - Plantación adicional requerida
        Plantacion::create([
            'parcela_id' => $parcela1,
            'variedad_id' => $variedadAdelita,
            'campania_id' => $campaniaActiva,
            'fecha_siembra' => '2024-05-01',
            'numero_plantas' => 4500,
            'fecha_fin' => null,
            'estado' => 'activa',
        ]);

        // Parcela 2 - Variedad Adelita - Plantación secundaria inactiva
        Plantacion::create([
            'parcela_id' => $parcela2,
            'variedad_id' => $variedadAdelita,
            'campania_id' => $campaniaFinalizada,
            'fecha_siembra' => '2024-04-01',
            'numero_plantas' => 3200,
            'fecha_fin' => '2025-12-31',
            'estado' => 'finalizada',
        ]);

        // Parcela 2 - Variedad Lyon (Glen Lyon) - Plantación activa
        Plantacion::create([
            'parcela_id' => $parcela2,
            'variedad_id' => $variedadLyon,
            'campania_id' => $campaniaActiva,
            'fecha_siembra' => '2024-02-20',
            'numero_plantas' => 2400,
            'fecha_fin' => null,
            'estado' => 'activa',
        ]);
    }
}
