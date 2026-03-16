<?php

namespace Database\Seeders;

use App\Models\Variedad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariedadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Variedad::create([
            'nombre' => 'Noelia (R15)',
            'tipo' => 'remontante',
            'descripcion' => 'Variedad premium de tamaño medio-grande, color rojo claro y brillante. Es altamente productiva y precoz.',
        ]);

        Variedad::create([
            'nombre' => 'Adelita',
            'tipo' => 'remontante',
            'descripcion' => 'Gran tamaño y color rojo brillante. Altamente productiva y larga vida de anaquel. Sabor dulce ligeramente ácido, ideal para consumo fresco y reposteria y confiteria.',
        ]);

        Variedad::create([
            'nombre' => 'Lyon (Glen Lyon)',
            'tipo' => 'no_remontante',
            'descripcion' => 'Forma redonda ligeramente cónica y tamaño medio. Delicioso sabor ácido. Se adapta bien a climas templados y fríos, de arbusto vigoroso y resistente a enfermedades',
        ]);

        Variedad::create([
            'nombre' => 'Clarita',
            'tipo' => 'remontante',
            'descripcion' => 'Destaca por el exquisito sabor de su fruto y la altísima producción. Es una planta muy dura y resistente, con un porte contenido perfecto para espacios reducidos y macetas.',
        ]);

        Variedad::create([
            'nombre' => 'Alegría',
            'tipo' => 'remontante',
            'descripcion' => 'Variedad premium andaluza de tamaño grande, color rojo medio y excelente equilibrio entre dulzor y acidez',
        ]);

        Variedad::create([
            'nombre' => 'Heritage',
            'tipo' => 'remontante',
            'descripcion' => 'Variedad remontante muy productiva. Frutos medianos, firmes y de excelente sabor. Ideal para consumo en fresco y congelación. Resistente a enfermedades fúngicas.',
        ]);

        Variedad::create([
            'nombre' => 'Maravilla (Driscoll\'s Maravilla)',
            'tipo' => 'remontante',
            'descripcion' => 'Brotes son gruesos, erectos, cubiertos de pequeñas espinas púrpuras. Alto rendimiento y frutos grandes, con forma regular',
        ]);
    }
}
