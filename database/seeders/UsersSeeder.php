<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dueño
        User::create([
            'name' => 'Pepe Rodríguez Sánchez',
            'username' => 'peperodriguez',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'),
            'dni' => '22636097A',
            'telefono' => '600000000',
            'rol' => 'administrador',
            'fecha_alta' => '2024-01-11',
            'fecha_baja' => null,
            'remember_token' => Str::random(20),
        ]);

        // Encargado
        User::create([
            'name' => 'Manuel García López',
            'username' => 'manugarcia',
            'email' => 'manuelgl94@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'),
            'dni' => '80270811Y',
            'telefono' => '635184792',
            'rol' => 'encargado',
            'fecha_alta' => '2024-02-05',
            'fecha_baja' => null,
            'remember_token' => Str::random(20),
        ]);

        // Recolectores
        User::create([
            'name' => 'Juan Pérez Martínez',
            'username' => 'juanperez',
            'email' => 'juanperez@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'),
            'dni' => '78572852E',
            'telefono' => '634567890',
            'rol' => 'recolector',
            'fecha_alta' => '2024-02-21',
            'fecha_baja' => null,
            'remember_token' => Str::random(20),
        ]);

        User::create([
            'name' => 'Ana Martínez Fernández',
            'username' => 'anamartinez',
            'email' => 'anamarfer00@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'),
            'dni' => '80851996G',
            'telefono' => '645678901',
            'rol' => 'recolector',
            'estado' => 'inactivo',
            'fecha_alta' => '2024-04-05',
            'fecha_baja' => '2025-01-20',
            'remember_token' => Str::random(20),
        ]);

        User::create([
            'name' => 'Luis Fernández Gómez',
            'username' => 'luisfernandez',
            'email' => null,
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'),
            'dni' => '12344458J',
            'telefono' => '659647012',
            'rol' => 'recolector',
            'fecha_alta' => '2024-06-18',
            'fecha_baja' => null,
            'remember_token' => Str::random(20),
        ]);
    }
}
