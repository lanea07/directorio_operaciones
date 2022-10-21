<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy
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

    public function update(User $user, Issue $issue)
    {
        return $user->hasRoles(['administrador']);
    }

    public function destroy(User $user, Issue $issue)
    {
        return $user->hasRoles(['administrador']);
    }
}
