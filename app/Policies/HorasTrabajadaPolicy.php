<?php

namespace App\Policies;

use App\Models\HorasTrabajada;
use App\Models\User;

class HorasTrabajadaPolicy
{
    // Admin y Encargado ven el listado completo. Sin token también.
    public function viewAny(?User $user): bool
    {
        if (is_null($user)) return true;
        return in_array($user->rol, ['administrador', 'encargado', 'recolector']);
    }

    // Admin y Encargado ven cualquier registro.
    // El Recolector solo puede ver sus propias horas.
    public function view(?User $user, HorasTrabajada $horas): bool
    {
        if (is_null($user)) return true;
        if (in_array($user->rol, ['administrador', 'encargado'])) return true;
        return $user->rol === 'recolector' && $horas->user_id === $user->id;
    }

    // Solo Admin puede registrar horas.
    public function create(User $user): bool
    {
        return $user->rol === 'administrador';
    }

    // Solo Admin puede editar.
    public function update(User $user, HorasTrabajada $horas): bool
    {
        return $user->rol === 'administrador';
    }

    // Solo Admin puede borrar.
    public function delete(User $user, HorasTrabajada $horas): bool
    {
        return $user->rol === 'administrador';
    }

    public function restore(User $user, HorasTrabajada $horas): bool
    {
        return false;
    }
    public function forceDelete(User $user, HorasTrabajada $horas): bool
    {
        return false;
    }
}
