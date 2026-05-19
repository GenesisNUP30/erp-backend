<?php

namespace App\Policies;

use App\Models\Pago;
use App\Models\User;

class PagoPolicy
{
    // Admin y Encargado ven el listado. Sin token también.
    public function viewAny(?User $user): bool
    {
        if (is_null($user)) return true;
        return in_array($user->rol, ['administrador', 'encargado']);
    }

    // Admin y Encargado ven cualquier pago.
    // El Recolector solo puede ver sus propios pagos.
    public function view(?User $user, Pago $pago): bool
    {
        if (is_null($user)) return true;
        if (in_array($user->rol, ['administrador', 'encargado'])) return true;
        return $user->rol === 'recolector' && $pago->user_id === $user->id;
    }

    // Solo Admin crea pagos.
    public function create(User $user): bool
    {
        return $user->rol === 'administrador';
    }

    // Admin y Encargado pueden actualizar estado (ej: validar un borrador).
    public function update(User $user, Pago $pago): bool
    {
        return in_array($user->rol, ['administrador', 'encargado']);
    }

    // Solo Admin puede borrar.
    public function delete(User $user, Pago $pago): bool
    {
        return $user->rol === 'administrador';
    }

    public function restore(User $user, Pago $pago): bool
    {
        return false;
    }
    public function forceDelete(User $user, Pago $pago): bool
    {
        return false;
    }
}
