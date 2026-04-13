<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'mes',
        'anio',
        'total_horas',
        'monto_total',
        'estado',
        'fecha_pago',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_pago' => 'date:Y-m-d',
            'total_horas' => 'decimal:2',
            'monto_total' => 'decimal:2',
        ];
    }

    public $timestamps = false;

    public function trabajador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    //TODO: Asegurar que el borrado de un usuario no afecta al pago
    public function horasTrabajadas()
    {
        return $this->hasMany(HorasTrabajada::class);
    }
}
