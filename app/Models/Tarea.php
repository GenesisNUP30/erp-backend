<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tareas';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'parcela_id',
        'user_id',
        'titulo',
        'tipo',
        'fecha',
        'horas_estimadas',
        'descripcion',
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
            'fecha' => 'date:d-m-Y',
            'horas_estimadas' => 'decimal:2',
        ];
    }

    public $timestamps = false;

    public function parcela()
    {
        return $this->belongsTo(Parcela::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
