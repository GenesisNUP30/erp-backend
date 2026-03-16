<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'dni',
        'telefono',
        'rol',
        'fecha_alta',
        'fecha_baja',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'fecha_alta' => 'date:Y-m-d',
            'fecha_baja' => 'date:Y-m-d',
            'email_verified_at' => 'datetime',
        ];
    }

    public function recolecciones()
    {
        return $this->hasMany(Recoleccion::class, 'user_id');
    }

    public function horasTrabajadas()
    {
        return $this->hasMany(HorasTrabajada::class, 'user_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'user_id');
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'user_id');
    }
}
