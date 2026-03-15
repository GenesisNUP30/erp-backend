<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plantaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'parcela_id',
        'variedad_id',
        'campania_id',
        'fecha_siembra',
        'numero_plantas',
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
            'fecha_siembra' => 'date:d-m-Y',
            'fecha_fin' => 'date:d-m-Y',
        ];
    }

    public function parcela()
    {
        return $this->belongsTo(Parcela::class);
    }

    public function variedad()
    {
        return $this->belongsTo(Variedad::class);
    }

    public function campania()
    {
        return $this->belongsTo(Campania::class);
    }

    public function cosechas()
    {
        return $this->hasMany(Cosecha::class);
    }
}
