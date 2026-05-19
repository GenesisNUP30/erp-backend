<?php

namespace App\Policies;

use App\Models\Recoleccion;
use App\Models\User;

class RecoleccionPolicy
{
    // Admin y Encargado ven el listado. Sin token también.
    public function viewAny(?User $user): bool
    {
        if (is_null($user)) return true;
        return in_array($user->rol, ['administrador', 'encargado']);
    }

    // Admin, Encargado y el propio Recolector pueden ver su detalle.
    public function view(?User $user, Recoleccion $recoleccion): bool
    {
        if (is_null($user)) return true;
        if (in_array($user->rol, ['administrador', 'encargado'])) return true;
        // El recolector solo puede ver sus propias recolecciones
        return $user->rol === 'recolector' && $recoleccion->user_id === $user->id;
    }

    // Solo Admin crea recolecciones (o el encargado las registra).
    public function create(User $user): bool
    {
        return in_array($user->rol, ['administrador', 'encargado']);
    }

    // Admin y Encargado pueden editar.
    public function update(User $user, Recoleccion $recoleccion): bool
    {
        return in_array($user->rol, ['administrador', 'encargado']);
    }

    // Solo Admin puede borrar.
    public function delete(User $user, Recoleccion $recoleccion): bool
    {
        return $user->rol === 'administrador';
    }

    public function restore(User $user, Recoleccion $recoleccion): bool
    {
        return false;
    }
    public function forceDelete(User $user, Recoleccion $recoleccion): bool
    {
        return false;
    }
}
