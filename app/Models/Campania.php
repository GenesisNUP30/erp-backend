<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campania extends Model
{
    use HasFactory;

    protected $table = 'campanias';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio' => 'date:d-m-Y',
        'fecha_fin' => 'date:d-m-Y',
    ];

    public $timestamps = false;

    public function plantaciones()
    {
        return $this->hasMany(Plantacion::class);
    }

    public function cosechas()
    {
        return $this->hasMany(Cosecha::class);
    }
}
