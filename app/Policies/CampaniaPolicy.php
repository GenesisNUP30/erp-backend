<?php

namespace App\Policies;

use App\Models\Campania;
use App\Models\User;

class CampaniaPolicy
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
    public function view(?User $user, Campania $campania): bool
    {
        if (is_null($user)) return true;

        return in_array($user->rol, ['administrador', 'encargado']);
    }

    /**
     * Solo el Admin puede crear campañas.
     */
    public function create(User $user): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     *Solo el Admin puede editar campañas.
     */
    public function update(User $user, Campania $campania): bool
    {
        return in_array($user->rol, ['administrador', 'encargado']);
    }

    /**
     * Solo el Admin puede borrar.
     */
    public function delete(User $user, Campania $campania): bool
    {
        return $user->rol === 'administrador';
    }

    public function restore(User $user, Campania $campania): bool
    {
        return false;
    }

    public function forceDelete(User $user, Campania $campania): bool
    {
        return false;
    }
}