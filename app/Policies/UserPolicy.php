<?php

namespace App\Policies;

use App\Http\Helpers\Shared\ROLES;
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

    public function legacyEdit(User $authUser, User $targetedUser) {

        $cannotEditUser = false;

        $canEditUser = false;

        $adminRole = ROLES::ADMIN->value;
        $moderatorRole = ROLES::MODERATOR->value;
        $customerRole = ROLES::CUSTOMER->value;
        // dd($moderatorRole, $authUser->Roles->contains('name', $moderatorRole) && $targetedUser->Roles->contains('name', $adminRole));

        if ($authUser->Roles->contains('name', 'Admin')) {
            // dd('I\'m Admin');
            $canEditUser = true;
            return $canEditUser;
        }

        if ($authUser->Roles->contains('name', 'Moderator')) {

            if ($authUser->id == $targetedUser->id) {
                // dd('Myself!');
                $canEditUser = true;
                return $canEditUser;
            }

            if ($targetedUser->Roles->contains('name', 'Customer') &&
                !$targetedUser->Roles->contains('name', 'Moderator') &&
                !$targetedUser->Roles->contains('name', 'Admin'))
            {

                // dd('A customer');
                $canEditUser = true;
                return $canEditUser;
            }

            if ($targetedUser->Roles->contains('name', 'Moderator') ||
                $targetedUser->Roles->contains('name', 'Admin')
            ) {
                // dd('Other moderator or Admin');
                $canEditUser = false;
                return $canEditUser;

            }

            return $canEditUser;

        }


        // if ($authUser->Roles->contains('name', $moderatorRole) &&
        //     !$authUser->Roles->contains('name', $adminRole))
        // {

        //     if ($targetedUser->Roles->contains('name', $adminRole) ||
        //         $targetedUser->Roles->contains('name', $moderatorRole))
        //     {
        //         $cannotEditUser = true;
        //     }
        //     else {
        //         $cannotEditUser = false;
        //     }

        // }

        // if ($authUser->Roles->contains('name', $moderatorRole) ||
        //     $authUser->Roles->contains('name', $adminRole))
        // {
        //     if ($authUser->id == $targetedUser->id) {
        //         $cannotEditUser = false;
        //     }
        // }

        // dd("cannot edit user details:", $cannotEditUser);

        return $canEditUser;

    }
}
