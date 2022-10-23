<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
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

    public function update(User $user, Role $issue)
    {
        return $user->hasRoles(['administrador']);
    }

    public function destroy(User $user, Role $issue)
    {
        return $user->hasRoles(['administrador']);
    }
}
