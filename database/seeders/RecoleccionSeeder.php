<?php

namespace Database\Seeders;

use App\Models\Recoleccion;
use App\Models\Cosecha;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecoleccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Recolecciones diarias para la misma cosecha activa en la Campaña 2025-2026
        Recoleccion::create([
            'cosecha_id' => Cosecha::where('nombre_cosecha', 'Cosecha Otoño-Invierno 2025')->first()->id,
            'user_id' => User::where('username', 'juanperez')->first()->id,
            'fecha' => '2026-03-15',
            'num_cajas' => 12,
            'kilos_caja' => 2.5,
            'notas' => null,
            'estado' => 'registrada',
        ]);

        Recoleccion::create([
            'cosecha_id' => Cosecha::where('nombre_cosecha', 'Cosecha Otoño-Invierno 2025')->first()->id,
            'user_id' => User::where('username', 'juanperez')->first()->id,
            'fecha' => '2026-03-15',
            'num_cajas' => 10,
            'kilos_caja' => 2.5,
            'notas' => 'Poco rendimiento.',
            'estado' => 'registrada',
        ]);

         Recoleccion::create([
            'cosecha_id' => Cosecha::where('nombre_cosecha', 'Cosecha Otoño-Invierno 2025')->first()->id,
            'user_id' => User::where('username', 'luisfernandez')->first()->id,
            'fecha' => '2026-03-15',
            'num_cajas' => 14,
            'kilos_caja' => 2.5,
            'notas' => null,
            'estado' => 'registrada',
        ]);

    }
}
