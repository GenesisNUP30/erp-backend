<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcela extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'parcelas';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'superficie_hectareas',
        'ubicacion',
        'estado',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'superficie_hectareas' => 'decimal:2',
        ];
    }

    public function plantaciones()
    {
        return $this->hasMany(Plantacion::class);
    }

    public function consumosAgua()
    {
        return $this->hasMany(ConsumoAgua::class);
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }
}
