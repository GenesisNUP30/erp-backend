<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recoleccion extends Model
{
    use HasFactory;

    protected $table = 'recolecciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'cosecha_id',
        'user_id',
        'fecha',
        'num_cajas',
        'kilos_caja',
        'notas',
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
        ];
    }

    public $timestamps = false;

    public function cosecha()
    {
        return $this->belongsTo(Cosecha::class);
    }

    public function recolector()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
