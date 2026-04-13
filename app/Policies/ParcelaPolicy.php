<?php

namespace App\Policies;

use App\Models\Parcela;
use App\Models\User;

class ParcelaPolicy
{
    /**
     * Admin y Encargado pueden ver el listado.
     * Sin token (profesor) también puede ver.
     */
    public function viewAny(?User $user): bool
    {
        if (is_null($user)) return true;

        return in_array($user->rol, ['administrador', 'encargado']);
    }

    /**
     * Admin y Encargado pueden ver el detalle.
     * Sin token (profesor) también puede ver.
     */
    public function view(?User $user, Parcela $parcela): bool
    {
        if (is_null($user)) return true;

        return in_array($user->rol, ['administrador', 'encargado']);
    }

    /**
     * Solo el Admin puede crear parcelas.
     */
    public function create(User $user): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Admin puede todo. Encargado puede editar.
     */
    public function update(User $user, Parcela $parcela): bool
    {
        return in_array($user->rol, ['administrador', 'encargado']);
    }

    /**
     * Solo el Admin puede borrar.
     */
    public function delete(User $user, Parcela $parcela): bool
    {
        return $user->rol === 'administrador';
    }

    public function restore(User $user, Parcela $parcela): bool
    {
        return false;
    }

    public function forceDelete(User $user, Parcela $parcela): bool
    {
        return false;
    }
}