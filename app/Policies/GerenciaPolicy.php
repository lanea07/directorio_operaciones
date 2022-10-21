<?php

namespace App\Policies;

use App\Models\Gerencia;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GerenciaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Gerencia $gerencia)
    {
        return $user->hasRoles(['administrador']);
    }

    public function destroy(User $user, Gerencia $gerencia)
    {
        return $user->hasRoles(['administrador']);
    }
}
