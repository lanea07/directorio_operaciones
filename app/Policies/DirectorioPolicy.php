<?php

namespace App\Policies;

use App\Models\Directorio;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DirectorioPolicy
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

    public function update(User $user, Directorio $directorio)
    {
        return $user->hasRoles(['administrador']);
    }

    public function destroy(User $user, Directorio $directorio)
    {
        return $user->hasRoles(['administrador']);
    }

}
