<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * El Admin y el Encargado pueden ver la lista y el detalle.
     */
    public function viewAny(?User $user): bool
    {
        // De momento permitimos siempre el acceso para poder ver la api
        if (is_null($user)) return true;

        return in_array($user->rol, ['administrador', 'encargado']);
    }

    /**
 * Determina si el usuario puede ver un trabajador específico.
 */
    public function view(User $user, User $worker): bool
    {
        if ($user->rol === 'administrador') return true;
    
    if ($user->rol === 'encargado') {
        return $worker->rol !== 'administrador';
    }

        return false;
    }

    /**
     * Solo el Admin puede crear trabajadores.
     */
    public function create(User $user): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Admin puede todo. Encargado puede editar pero con restricciones (validadas en Request).
     */
    public function update(User $user, User $worker): bool
    {
        if ($user->rol === 'administrador') return true;
        
        if ($user->rol === 'encargado') {
            // No permitimos que un encargado edite a un administrador
            return $worker->rol !== 'administrador';
        }

        return false;
    }

    /**
     * Solo el Admin puede borrar (SoftDelete).
     */
    public function delete(User $user, User $worker): bool
    {
        return $user->rol === 'administrador';;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
