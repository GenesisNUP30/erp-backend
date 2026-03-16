<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDiaria extends Model
{
    use HasFactory;

    protected $table = 'ventas_diarias';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fecha',
        'cosecha_id',
        'kilos_primera',
        'precio_primera',
        'kilos_industria',
        'precio_industria',
        'importe_total',
        'observaciones',
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
            'fecha' => 'date:Y-m-d',
            'kilos_primera' => 'decimal:2',
            'precio_primera' => 'decimal:2',
            'kilos_industria' => 'decimal:2',
            'precio_industria' => 'decimal:2',
            'importe_total' => 'decimal:2'
        ];
    }

    public $timestamps = false;

    public function cosecha()
    {
        return $this->belongsTo(Cosecha::class);
    }
}
