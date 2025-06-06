<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function generate(User $user)
    {
        return $user->hasRole('admin');
    }
}
