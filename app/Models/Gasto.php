<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;

    protected $table = 'gastos';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'categoria_id',
        'cosecha_id',
        'fecha',
        'concepto',
        'importe',
        'horas_estimadas',
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
            'horas_estimadas' => 'decimal:2',
            'importe' => 'decimal:2',
        ];
    }

    public $timestamps = false;

    public function categoria()
    {
        return $this->belongsTo(CategoriaGasto::class);
    }

    public function cosecha()
    {
        return $this->belongsTo(Cosecha::class);
    }
}
