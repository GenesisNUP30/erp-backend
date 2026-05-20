<?php

namespace App\Policies;

use App\Models\Cosecha;
use App\Models\User;

class CosechaPolicy
{
    // Admin y Encargado ven el listado. Sin token también (modo profesor).
    public function viewAny(?User $user): bool
    {
        if (is_null($user)) return true;
        return in_array($user->rol, ['administrador', 'encargado']);
    }

    // Admin y Encargado ven el detalle. Sin token también.
    public function view(?User $user, Cosecha $cosecha): bool
    {
        if (is_null($user)) return true;
        return in_array($user->rol, ['administrador', 'encargado']);
    }

    // Solo Admin crea cosechas.
    public function create(User $user): bool
    {
        return $user->rol === 'administrador';
    }

    // Admin y Encargado pueden editar.
    public function update(User $user, Cosecha $cosecha): bool
    {
        return in_array($user->rol, ['administrador', 'encargado']);
    }

    // Solo Admin puede borrar.
    public function delete(User $user, Cosecha $cosecha): bool
    {
        return $user->rol === 'administrador';
    }

    public function restore(User $user, Cosecha $cosecha): bool
    {
        return false;
    }
    public function forceDelete(User $user, Cosecha $cosecha): bool
    {
        return false;
    }
}
