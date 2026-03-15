<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cosecha extends Model
{
    use HasFactory;

    protected $table = 'cosechas';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'plantacion_id',
        'campania_id',
        'nombre_cosecha',
        'fecha_inicio',
        'fecha_fin',
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
            'fecha_inicio' => 'date:d-m-Y',
            'fecha_fin' => 'date:d-m-Y',
        ];
    }

    public $timestamps = false;

    public function plantacion()
    {
        return $this->belongsTo(Plantacion::class);
    }

    public function campania()
    {
        return $this->belongsTo(Campania::class);
    }

    public function recolecciones()
    {
        return $this->hasMany(Recoleccion::class);
    }

    public function gastos()
    {
        return $this->hasMany(Gasto::class);
    }

    public function ventasDiarias()
    {
        return $this->hasMany(VentaDiaria::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function horasTrabajadas()
    {
        return $this->hasMany(HorasTrabajada::class);
    }
}
