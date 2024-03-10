<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{

    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function editProduct(User $authUser, Product $target) {

        return ($authUser->id == $target->distributor->id && $authUser->roles->contains('name', 'Seller'))
                || $authUser->roles->contains('name', 'Admin');

    }

}
