<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recoleccion extends Model
{
    use HasFactory;

    protected $table = 'recolecciones';

    // Campos que se le permite almacenamiento masivo en la base de datos
    protected $fillable = [
        'cosecha_id',
        'user_id',
        'fecha',
        'num_cajas',
        'kilos_caja',
        'notas',
        'estado',
    ];

    // Conversión aiutomática de tipos de datos
    protected function casts(): array
    {
        return [
            'fecha' => 'date:Y-m-d',
        ];
    }

    public $timestamps = false;

    // Relaciones
    public function cosecha()
    {
        return $this->belongsTo(Cosecha::class);
    }

    public function recolector()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}


