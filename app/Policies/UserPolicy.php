<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function update(User $user, User $userToSave)
    {
        return $user->hasRoles(['administrador']);
    }

    public function destroy(User $user, User $userToSave)
    {
        return $user->hasRoles(['administrador']) && $userToSave->id <> 1;
    }
}
