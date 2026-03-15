<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumoAgua extends Model
{
    use HasFactory;

    protected $table = 'consumo_agua';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'parcela_id',
        'fecha_inicio',
        'fecha_fin',
        'litros_consumidos',
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
            'litros_consumidos' => 'decimal:2',
        ];
    }

    public $timestamps = false;

    public function parcela()
    {
        return $this->belongsTo(Parcela::class);
    }
}
