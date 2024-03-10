<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function profile(User $authUser, User $targetedUser) {

        return $authUser->id == $targetedUser->id;

    }
}
