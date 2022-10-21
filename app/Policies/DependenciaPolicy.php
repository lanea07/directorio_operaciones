<?php

namespace App\Policies;

use App\Models\Dependencia;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DependenciaPolicy
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

    public function update(User $user, Dependencia $gerencia)
    {
        return $user->hasRoles(['administrador']);
    }

    public function destroy(User $user, Dependencia $gerencia)
    {
        return $user->hasRoles(['administrador']);
    }
}
