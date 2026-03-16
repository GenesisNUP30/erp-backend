<?php

namespace Database\Seeders;

use App\Models\Campania;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Campaña finalizada (temporada 2024-2025)
        Campania::create([
            'nombre' => 'Campaña Primavera 2024-2025',
            'fecha_inicio' => '2024-02-05',
            'fecha_fin' => '2025-06-30',
            'descripcion' => 'Prueba 1 campaña 2024-2025 finalizada',
            'estado' => 'finalizada',
        ]);

        // Campaña 2025-2026
        Campania::create([
            'nombre' => 'Campaña 2025-2026',
            'fecha_inicio' => '2025-09-10',
            'fecha_fin' => null,
            'descripcion' => 'Prueba campaña activa 2025-2026',
            'estado' => 'activa',
        ]);

        // Campaña planificada
        Campania::create([
            'nombre' => 'Campaña Planificada 2026-2027',
            'fecha_inicio' => '2026-10-01',
            'fecha_fin' => '2027-06-30',
            'descripcion' => 'Campaña planificada para la temporada 2026-2027.',
            'estado' => 'planificada',
        ]);
    }
}
