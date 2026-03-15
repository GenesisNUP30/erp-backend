<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variedad extends Model
{
    use HasFactory;

    protected $table = 'variedades';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'tipo',
        'descripcion'
    ];

    public $timestamps = false;

    public function plantaciones()
    {
        return $this->hasMany(Plantacion::class);
    }
}
