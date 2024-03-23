<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function show(User $authUser, Order $targetOrder)  {

        return $authUser->id == $targetOrder->customer->id;

    }
}
