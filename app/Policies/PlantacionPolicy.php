<?php

namespace App\Policies;

use App\Models\Plantacion;
use App\Models\User;

class PlantacionPolicy
{
    /**
     * Admin y Encargado pueden ver el listado.
     * Sin token el profesor también puede ver.
     */
    public function viewAny(?User $user): bool
    {
        if (is_null($user)) return true;

        return in_array($user->rol, ['administrador', 'encargado']);
    }

    /**
     * Admin y Encargado pueden ver el detalle.
     * Sin token el profesor también puede ver.
     */
    public function view(?User $user, Plantacion $plantacion): bool
    {
        if (is_null($user)) return true;

        return in_array($user->rol, ['administrador', 'encargado']);
    }

    /**
     * Solo el Admin puede crear plantaciones.
     */
    public function create(User $user): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Admin puede todo. Encargado puede editar.
     */
    public function update(User $user, Plantacion $plantacion): bool
    {
        return in_array($user->rol, ['administrador', 'encargado']);
    }

    /**
     * Solo el Admin puede borrar.
     */
    public function delete(User $user, Plantacion $plantacion): bool
    {
        return $user->rol === 'administrador';
    }

    public function restore(User $user, Plantacion $plantacion): bool
    {
        return false;
    }

    public function forceDelete(User $user, Plantacion $plantacion): bool
    {
        return false;
    }
}
