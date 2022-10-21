<?php

namespace App\Policies;

use App\Models\Area;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AreaPolicy
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

    public function update(User $user, Area $area)
    {
        return $user->hasRoles(['administrador']);
    }

    public function destroy(User $user, Area $area)
    {
        return $user->hasRoles(['administrador']);
    }
}
