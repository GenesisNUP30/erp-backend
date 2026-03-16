<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorasTrabajada extends Model
{
    use HasFactory;

    protected $table = 'horas_trabajadas';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'cosecha_id',
        'pago_id',
        'fecha',
        'horas',
        'precio_hora',
        'tipo_trabajo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected function casts(): array
    {
        return [
            'fecha' => 'date:Y-m-d',
            'horas' => 'decimal:2',
            'precio_hora' => 'decimal:2',
        ];
    }

    public $timestamps = false;

    public function trabajador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cosecha()
    {
        return $this->belongsTo(Cosecha::class);
    }

    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }
}
