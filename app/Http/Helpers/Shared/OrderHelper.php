<?php

namespace App\Http\Helpers\Shared;

enum OrderStatus : string {

    case UNPAID = 'unpaid';
    case PAID = 'paid';

}
