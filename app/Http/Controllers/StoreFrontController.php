<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreFrontController extends Controller
{
    public function StoreFront() {

        return view('storefront.welcome');

    }
}
